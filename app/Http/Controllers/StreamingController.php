<?php

namespace App\Http\Controllers;

use App\Events\StreamStarted;
use App\Events\WebRTCSignalRelay;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StreamingController extends Controller
{

    /**
     * JSON for the authenticated model's stream admin dashboard (session auth; includes pending).
     */
    public function getStreamInfoForDashboard(Stream $stream)
    {
        abort_unless((int) $stream->user_id === (int) auth()->id(), 403);

        return $this->getStreamInfo($stream);
    }

    public function getStreamInfo(Stream $stream)
    {
        $stream->load('user.profile');

        if ($stream->status === 'pending') {
            if (! auth()->check() || (int) auth()->id() !== (int) $stream->user_id) {
                return response()->json(['error' => 'Stream no está activo'], 404);
            }

            return response()->json([
                'stream_id' => $stream->id,
                'model_id' => $stream->user_id,
                'model_name' => $stream->user->name,
                'title' => $stream->title,
                'status' => 'pending',
                'viewers_count' => $stream->viewers_count,
                'started_at' => $stream->started_at,
                'websocket_channel' => "stream.{$stream->id}",
                'webrtc_room' => "room_{$stream->id}",
            ]);
        }

        if ($stream->status !== 'live' && $stream->status !== 'paused') {
            return response()->json(['error' => 'Stream no está activo'], 404);
        }

        return response()->json([
            'stream_id' => $stream->id,
            'model_id' => $stream->user_id,
            'model_name' => $stream->user->name,
            'title' => $stream->title,
            'status' => $stream->status,
            'viewers_count' => $stream->viewers_count,
            'started_at' => $stream->started_at,
            'websocket_channel' => "stream.{$stream->id}",
            'webrtc_room' => "room_{$stream->id}",
        ]);
    }

    public function getNewChatMessages(Request $request, Stream $stream)
    {
        $lastId = $request->query('last_id', 0);
        
        $messages = $stream->chatMessages()
            ->with(['user'])
            ->where('id', '>', $lastId)
            ->orderBy('id', 'asc')
            ->get();
            
        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }


    public function startBroadcast(Request $request, $streamId)
    {
        $stream = Stream::findOrFail($streamId);

        if ($stream->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }


        $wasPending = $stream->status === 'pending';

        $updates = ['status' => 'live'];
        if (! $stream->started_at) {
            $updates['started_at'] = now();
        }
        $stream->update($updates);

        $stream->user->profile()->update(['is_streaming' => true]);

        if ($wasPending) {
            event(new StreamStarted($stream));
        }

        Log::info("Stream {$streamId} iniciado por usuario {$stream->user_id}");

        return response()->json([
            'success' => true,
            'message' => __('admin.flash.streaming.started'),
            'stream_info' => [
                'id' => $stream->id,
                'channel' => "stream.{$stream->id}",
                'room' => "room_{$stream->id}",
            ]
        ]);
    }


    public function stopBroadcast(Request $request, $streamId)
    {
        $stream = Stream::findOrFail($streamId);

        if ($stream->user_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado'], 403);
        }


        $stream->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);


        $stream->user->profile()->update(['is_streaming' => false]);

        Log::info("Stream {$streamId} finalizado por usuario {$stream->user_id}");

        return response()->json([
            'success' => true,
            'message' => __('admin.flash.streaming.stopped'),
        ]);
    }


    public function joinAsViewer(Request $request, $streamId)
    {
        $stream = Stream::findOrFail($streamId);

        if (! in_array($stream->status, ['live', 'paused'], true)) {
            return response()->json(['error' => 'Stream no está activo'], 404);
        }

        $stream->increment('viewers_count');

        Log::info("Viewer se unió al stream {$streamId}");

        return response()->json([
            'success' => true,
            'message' => __('admin.flash.streaming.connected'),
            'viewers_count' => $stream->viewers_count,
            'stream_info' => [
                'id' => $stream->id,
                'channel' => "stream.{$stream->id}",
                'room' => "room_{$stream->id}",
            ]
        ]);
    }


    public function leaveAsViewer(Request $request, $streamId)
    {
        $stream = Stream::findOrFail($streamId);


        if ($stream->viewers_count > 0) {
            $stream->decrement('viewers_count');
        }

        Log::info("Viewer salió del stream {$streamId}");

        return response()->json([
            'success' => true,
            'message' => __('admin.flash.streaming.disconnected'),
            'viewers_count' => $stream->viewers_count
        ]);
    }

    public function relayWebRTCSignal(Request $request, $streamId)
    {
        $stream = Stream::findOrFail($streamId);

        if (! $this->streamAllowsWebRtcSignaling($stream)) {
            return response()->json(['success' => false, 'message' => 'Stream not active'], 422);
        }

        $validated = $request->validate([
            'senderPeerId' => 'required|string|max:100',
            'signalEvent' => 'required|string|in:viewer-ready,broadcaster-ready,webrtc-offer,webrtc-answer,webrtc-ice',
            'payload' => 'nullable|array',
        ]);

        $signalEvent = $validated['signalEvent'];
        $payload = $validated['payload'] ?? [];
        $inlineMax = (int) config('streaming.webrtc_inline_max_bytes', 16000);

        // Combined viewer-ready + join: increment viewer count in the same request.
        if ($signalEvent === 'viewer-ready' && !empty($payload['joinViewer'])) {
            $stream->increment('viewers_count');
            unset($payload['joinViewer']);
        }

        // Try to send the full payload inline via Pusher (fastest path).
        // Only fall back to cache relay if the serialized payload exceeds the Pusher-safe limit.
        $fullPayload = $payload;
        $payloadSize = strlen(json_encode($fullPayload, JSON_UNESCAPED_UNICODE));

        if ($payloadSize > $inlineMax) {
            // Payload too large for Pusher: store in cache, broadcast only relayId.
            $relayId = (string) Str::uuid();
            $ttl = (int) config('streaming.webrtc_relay_ttl_seconds', 120);
            Cache::put("webrtc_relay:{$relayId}", [
                'stream_id' => (int) $stream->id,
                'sender_peer_id' => $validated['senderPeerId'],
                'signal_event' => $signalEvent,
                'payload' => $payload,
            ], $ttl);

            // Verify cache write succeeded.
            $verify = Cache::get("webrtc_relay:{$relayId}");
            Log::info('[WebRTC] Cache relay stored', [
                'relayId' => $relayId,
                'size' => $payloadSize,
                'inlineMax' => $inlineMax,
                'cached' => $verify !== null,
                'cache_driver' => config('cache.default'),
            ]);

            broadcast(new WebRTCSignalRelay(
                streamId: (int) $stream->id,
                senderUserId: (int) (auth()->id() ?? 0),
                senderPeerId: $validated['senderPeerId'],
                signalEvent: $signalEvent,
                payload: ['relayId' => $relayId]
            ))->toOthers();

            return response()->json(['success' => true]);
        }

        // Fast path: send everything inline via Pusher (no extra HTTP fetch needed).
        // If Pusher rejects (payload too large), fall back to cache relay.
        try {
            broadcast(new WebRTCSignalRelay(
                streamId: (int) $stream->id,
                senderUserId: (int) (auth()->id() ?? 0),
                senderPeerId: $validated['senderPeerId'],
                signalEvent: $signalEvent,
                payload: $payload
            ))->toOthers();
        } catch (\Throwable $e) {
            Log::warning('[WebRTC] Inline broadcast failed, falling back to cache relay', [
                'error' => $e->getMessage(),
                'payload_size' => $payloadSize,
            ]);
            $relayId = (string) Str::uuid();
            $ttl = (int) config('streaming.webrtc_relay_ttl_seconds', 120);
            Cache::put("webrtc_relay:{$relayId}", [
                'stream_id' => (int) $stream->id,
                'sender_peer_id' => $validated['senderPeerId'],
                'signal_event' => $signalEvent,
                'payload' => $payload,
            ], $ttl);

            broadcast(new WebRTCSignalRelay(
                streamId: (int) $stream->id,
                senderUserId: (int) (auth()->id() ?? 0),
                senderPeerId: $validated['senderPeerId'],
                signalEvent: $signalEvent,
                payload: ['relayId' => $relayId]
            ))->toOthers();
        }

        return response()->json(['success' => true]);
    }

    /**
     * Fetch a WebRTC signaling payload stored by relayWebRTCSignal (offer/answer too large for Pusher).
     */
    public function fetchWebRtcRelayPayload($streamId, string $relayId)
    {
        $stream = Stream::findOrFail($streamId);

        if (! $this->streamAllowsWebRtcSignaling($stream)) {
            return response()->json(['success' => false, 'message' => 'Stream not active'], 404);
        }

        if (in_array($stream->status, ['live', 'paused'], true)) {
            // Guests and all roles may fetch SDP payloads while the stream is watchable.
        } else {
            $user = auth()->user();
            if (! $user || (! $user->isAdmin() && (int) $user->id !== (int) $stream->user_id)) {
                return response()->json(['success' => false, 'message' => 'Forbidden'], 403);
            }
        }

        if (!preg_match('/^[0-9a-f\-]{36}$/i', $relayId)) {
            return response()->json(['success' => false, 'message' => 'Invalid relay id'], 422);
        }

        // Try cache first, then fall back to legacy file relay.
        $data = Cache::get("webrtc_relay:{$relayId}");
        if (!$data) {
            $data = $this->readWebRtcRelayFile($relayId);
        }
        if (!$data) {
            Log::warning('[WebRTC] Relay not found', [
                'relayId' => $relayId,
                'stream_id' => $stream->id,
                'cache_driver' => config('cache.default'),
            ]);
            return response()->json(['success' => false, 'message' => 'Expired or unknown relay'], 404);
        }

        if ((int) ($data['stream_id'] ?? 0) !== (int) $stream->id) {
            return response()->json(['success' => false, 'message' => 'Relay does not belong to this stream'], 404);
        }

        return response()->json([
            'success' => true,
            'senderPeerId' => $data['sender_peer_id'] ?? null,
            'signalEvent' => $data['signal_event'] ?? null,
            'payload' => $data['payload'] ?? [],
        ]);
    }

    private function streamAllowsWebRtcSignaling(Stream $stream): bool
    {
        if (in_array($stream->status, ['live', 'paused'], true)) {
            return true;
        }

        if ($stream->status !== 'pending') {
            return false;
        }

        return auth()->check() && (int) auth()->id() === (int) $stream->user_id;
    }

    private function webrtcRelayDir(): string
    {
        $dir = storage_path('app/webrtc-relays');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }

    private function storeWebRtcRelayFile(string $relayId, array $body): void
    {
        if (!preg_match('/^[0-9a-f\-]{36}$/i', $relayId)) {
            return;
        }
        $path = $this->webrtcRelayDir() . DIRECTORY_SEPARATOR . $relayId . '.json';
        $body['expires_at'] = time() + 600;
        file_put_contents($path, json_encode($body, JSON_UNESCAPED_UNICODE));
    }

    private function readWebRtcRelayFile(string $relayId): ?array
    {
        if (!preg_match('/^[0-9a-f\-]{36}$/i', $relayId)) {
            return null;
        }
        $path = $this->webrtcRelayDir() . DIRECTORY_SEPARATOR . $relayId . '.json';
        if (!is_file($path)) {
            return null;
        }
        $raw = json_decode((string) file_get_contents($path), true);
        if (!is_array($raw)) {
            @unlink($path);

            return null;
        }
        if (($raw['expires_at'] ?? 0) < time()) {
            @unlink($path);

            return null;
        }

        return $raw;
    }


    public function uploadChunk(Request $request)
    {
        try {
            $request->validate([
                'stream_id' => 'required|integer',
                'chunk_data' => 'required|string',
                'timestamp' => 'required|integer'
            ]);

            $streamId = $request->input('stream_id');
            $chunkData = $request->input('chunk_data');
            $timestamp = $request->input('timestamp');


            $stream = Stream::where('id', $streamId)
                ->where('status', 'live')
                ->first();

            if (!$stream) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stream not found or unauthorized'
                ], 404);
            }


            $chunksDir = storage_path("app/streaming/chunks/{$streamId}");
            if (!file_exists($chunksDir)) {
                mkdir($chunksDir, 0755, true);
            }


            $chunkFile = $chunksDir . "/chunk_{$timestamp}.webm";
            $decodedData = base64_decode($chunkData);
            file_put_contents($chunkFile, $decodedData);


            $stream->update([
                'status' => 'live',
                'started_at' => $stream->started_at ?? now()
            ]);


            $this->generateSimpleHLSPlaylist($streamId);

            Log::info("Chunk received", [
                'stream_id' => $streamId,
                'timestamp' => $timestamp,
                'size' => strlen($decodedData)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Chunk uploaded successfully'
            ]);

        } catch (\Exception $e) {
            Log::error("Error uploading chunk", [
                'error' => $e->getMessage(),
                'stream_id' => $request->input('stream_id')
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error uploading chunk: ' . $e->getMessage()
            ], 500);
        }
    }


    private function generateSimpleHLSPlaylist($streamId)
    {
        try {
            $hlsDir = public_path("hls/webcam/{$streamId}");
            if (!file_exists($hlsDir)) {
                mkdir($hlsDir, 0755, true);
            }

            $playlistFile = $hlsDir . "/playlist.m3u8";
            $chunksDir = storage_path("app/streaming/chunks/{$streamId}");

            if (!file_exists($chunksDir)) {
                return;
            }


            $chunks = glob($chunksDir . "/chunk_*.webm");
            usort($chunks, function ($a, $b) {
                return filemtime($b) - filemtime($a);
            });


            $chunks = array_slice($chunks, 0, 10);


            $playlist = "#EXTM3U\n";
            $playlist .= "#EXT-X-VERSION:3\n";
            $playlist .= "#EXT-X-TARGETDURATION:3\n";
            $playlist .= "#EXT-X-MEDIA-SEQUENCE:0\n";

            foreach (array_reverse($chunks) as $chunk) {
                $chunkName = basename($chunk);
                $playlist .= "#EXTINF:3.0,\n";
                $playlist .= "chunks/{$chunkName}\n";
            }

            file_put_contents($playlistFile, $playlist);


            foreach ($chunks as $chunk) {
                $chunkName = basename($chunk);
                $publicChunk = $hlsDir . "/chunks/{$chunkName}";

                if (!file_exists(dirname($publicChunk))) {
                    mkdir(dirname($publicChunk), 0755, true);
                }

                copy($chunk, $publicChunk);
            }

        } catch (\Exception $e) {
            Log::error("Error generating HLS playlist", [
                'stream_id' => $streamId,
                'error' => $e->getMessage()
            ]);
        }
    }


    public function getHLSPlaylist(Request $request, $streamId)
    {
        try {
            Log::info("Solicitando HLS playlist para stream ID: {$streamId}");

            $stream = Stream::find($streamId);

            if (!$stream) {
                Log::warning("Stream {$streamId} no encontrado en base de datos");
                return response()->json([
                    'success' => false,
                    'message' => 'Stream not found'
                ], 404);
            }

            Log::info("Stream {$streamId} encontrado - Status: {$stream->status}, User: {$stream->user_id}");

            if ($stream->status !== 'live') {
                Log::info("Stream {$streamId} no está en vivo (status: {$stream->status})");
                return response()->json([
                    'success' => false,
                    'message' => 'Stream not live',
                    'current_status' => $stream->status
                ], 200);
            }

            $playlistFile = public_path("hls/webcam/{$streamId}/playlist.m3u8");
            Log::info("Buscando playlist en: {$playlistFile}");

            if (!file_exists($playlistFile)) {
                Log::warning("Playlist no encontrado en: {$playlistFile}");
                return response()->json([
                    'success' => false,
                    'message' => 'Playlist not found',
                    'expected_path' => $playlistFile
                ], 404);
            }

            Log::info("Playlist encontrado, enviando respuesta");
            return response()->json([
                'success' => true,
                'hls_url' => "/hls/webcam/{$streamId}/playlist.m3u8",
                'stream_info' => [
                    'id' => $stream->id,
                    'title' => $stream->title,
                    'status' => $stream->status,
                    'viewers_count' => $stream->viewers_count ?? 0
                ]
            ]);

        } catch (\Exception $e) {
            Log::error("Error getting HLS playlist", [
                'stream_id' => $streamId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error getting playlist: ' . $e->getMessage()
            ], 500);
        }
    }
}
