<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use App\Models\ActivityLog;
use App\Events\NewChatMessage;
use App\Events\StreamEnded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StreamController extends Controller
{
    public function index(Request $request)
    {
        $query = auth()->user()->streams()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $streams = $query->paginate(20)->withQueryString();
        $activeStream = auth()->user()->streams()
            ->whereIn('status', ['live', 'paused', 'pending'])
            ->orderByRaw("CASE WHEN status = 'live' THEN 0 WHEN status = 'paused' THEN 1 ELSE 2 END")
            ->orderByDesc('id')
            ->first();

        return view('model.streams.index', compact('streams', 'activeStream'));
    }

    public function goLive()
    {
        return view('model.streams.choose-live-mode', $this->streamSetupContext());
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $liveMode = $request->query('mode', 'browser');
        if (! in_array($liveMode, ['browser', 'obs'], true)) {
            $liveMode = 'browser';
        }

        return view('model.streams.create', array_merge($this->streamSetupContext(), compact('liveMode')));
    }

    /**
     * @return array{warningMessage: ?string, profile: \App\Models\Profile}
     */
    private function streamSetupContext(): array
    {
        $profile = auth()->user()->profile;

        if (! $profile) {
            $profile = auth()->user()->profile()->create([
                'display_name' => auth()->user()->name,
                'verification_status' => 'pending',
            ]);
        }

        if (! $profile->stream_key) {
            $profile->generateStreamKey();
        }

        $activeStreams = auth()->user()->streams()->whereIn('status', ['live', 'paused', 'pending'])->get();

        $warningMessage = null;
        if ($activeStreams->count() > 0) {
            $titles = $activeStreams->pluck('title')->join(', ');
            $warningMessage = __('admin.flash.stream.active_warning', ['count' => $activeStreams->count(), 'titles' => $titles]);
        }

        return compact('warningMessage', 'profile');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        
        $activeStreams = auth()->user()->streams()->whereIn('status', ['live', 'paused', 'pending'])->get();

        foreach ($activeStreams as $activeStream) {
            $activeStream->update([
                'status' => 'ended',
                'ended_at' => now(),
            ]);

            
            event(new StreamEnded($activeStream));

            ActivityLog::log('stream_auto_ended', 'Stream finalizado automáticamente para crear nuevo: ' . $activeStream->title, $activeStream);
        }

        
        $profile = auth()->user()->profile;
        $streamKey = $profile->stream_key ?? $profile->generateStreamKey();

        $stream = auth()->user()->streams()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => 'pending',
            'stream_key' => $streamKey,
            'rtmp_url' => config('streaming.rtmp_public_url_base')."/{$streamKey}",
            'playback_url' => "/hls/live/{$streamKey}/index.m3u8",
            'started_at' => null,
        ]);

        ActivityLog::log('stream_created', 'Stream creado (pendiente de señal): '.$stream->title, $stream);

        return redirect()->route('model.streams.admin', $stream)
            ->with('success', __('admin.flash.stream.started'));
    }

    public function show(Stream $stream)
    {
        if ($stream->user_id !== auth()->id()) {
            abort(403);
        }

        // Si el stream ya terminó, cargamos TODO el historial para el modo detalle
        if ($stream->status === 'ended') {
            $stream->load([
                'chatMessages' => function($q) { $q->with('user')->oldest(); }, 
                'tips' => function($q) { $q->with('fan')->latest(); }
            ]);
        } else {
            // Para streams activos/pendientes, carga limitada (se actualiza por JS/Livewire si aplica)
            $stream->load(['chatMessages.user', 'tips.fan']);
        }

        return view('model.streams.show', compact('stream'));
    }

    public function admin(Stream $stream)
    {
        
        if ($stream->user_id !== auth()->id()) {
            abort(403);
        }

        $stream->load(['chatMessages.user', 'tips.fan']);

        
        $pendingActions = $stream->tips()
            ->with('fan')
            ->where('completed', false)
            ->whereNotNull('message')
            ->latest()
            ->limit(3)
            ->get();

        $completedActions = $stream->tips()
            ->with('fan')
            ->where('completed', true)
            ->whereNotNull('completed_at')
            ->orderBy('completed_at', 'desc')
            ->limit(3)
            ->get();

        
        $sessionEarnings = $stream->tips()->sum('amount');

        return view('model.streams.admin', compact('stream', 'pendingActions', 'completedActions', 'sessionEarnings'));
    }

    public function getActions(Stream $stream)
    {
        
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.not_authorized')], 403);
        }

        
        $pendingActions = $stream->tips()
            ->with('fan')
            ->where('completed', false)
            ->whereNotNull('message')
            ->latest()
            ->limit(3)
            ->get();

        
        $sessionEarnings = $stream->tips()->sum('amount');

        
        $html = view('model.streams.partials.actions-list', compact('pendingActions', 'stream'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'sessionEarnings' => $sessionEarnings
        ]);
    }

    public function live(Stream $stream)
    {
        
        if ($stream->user_id !== auth()->id()) {
            abort(403);
        }

        
        if ($stream->status !== 'live') {
            return redirect()->route('model.streams.show', $stream)
                ->with('error', __('admin.flash.stream.not_live'));
        }

        return view('model.streams.live', compact('stream'));
    }

    public function pause(Stream $stream)
    {
        $this->authorize('update', $stream);

        $stream->update(['status' => 'paused']);

        ActivityLog::log('stream_paused', 'Stream pausado: ' . $stream->title, $stream);

        return back()->with('success', __('admin.flash.stream.paused'));
    }

    public function resume(Stream $stream)
    {
        $this->authorize('update', $stream);

        $stream->update(['status' => 'live']);

        ActivityLog::log('stream_resumed', 'Stream reanudado: ' . $stream->title, $stream);

        return back()->with('success', __('admin.flash.stream.resumed'));
    }

    public function end(Stream $stream)
    {
        $this->authorize('update', $stream);

        $stream->update([
            'status' => 'ended',
            'ended_at' => now(),
        ]);

        
        auth()->user()->profile()->update(['is_streaming' => false]);

        
        event(new StreamEnded($stream));

        ActivityLog::log('stream_ended', 'Stream finalizado: ' . $stream->title, $stream);

        return redirect()->route('model.streams.index')
            ->with('success', __('admin.flash.stream.ended'));
    }

    public function destroy(Stream $stream)
    {
        $this->authorize('delete', $stream);

        
        if (in_array($stream->status, ['live', 'paused', 'pending'], true)) {
            $stream->update([
                'status' => 'ended',
                'ended_at' => now(),
            ]);

            $stream->user->profile()->update(['is_streaming' => false]);

            event(new StreamEnded($stream));
        }

        $streamTitle = $stream->title;

        
        $stream->delete();

        ActivityLog::log('stream_deleted', 'Stream eliminado: ' . $streamTitle);

        return redirect()->route('model.streams.index')
            ->with('success', __('admin.flash.stream.deleted'));
    }

    public function settings()
    {
        $profile = auth()->user()->profile;
        return view('model.streams.settings', compact('profile'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'pause_mode' => 'required|in:image,video,none',
            'pause_image' => 'nullable|image|max:2048',
            'pause_video' => 'nullable|mimes:mp4,webm,ogg|max:10240',
        ]);

        $profile = auth()->user()->profile;
        $data = ['pause_mode' => $validated['pause_mode']];

        if ($request->hasFile('pause_image')) {
            $path = $request->file('pause_image')->store('stream/pause', 'public');
            $data['pause_image'] = $path;
        }

        if ($request->hasFile('pause_video')) {
            $path = $request->file('pause_video')->store('stream/pause', 'public');
            $data['pause_video'] = $path;
        }

        $profile->update($data);

        return back()->with('success', __('admin.flash.stream.settings_updated'));
    }

    public function completeAction(Request $request, Stream $stream, $tipId)
    {
        
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.not_authorized')], 403);
        }

        $tip = \App\Models\Tip::findOrFail($tipId);

        
        if ($tip->model_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.not_authorized')], 403);
        }

        $tip->markAsCompleted();

        return response()->json([
            'success' => true,
            'message' => __('admin.flash.stream.action_completed'),
            'completed_at' => $tip->completed_at->format('H:i')
        ]);
    }

    public function sendChatReply(Request $request, Stream $stream)
    {
        
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.not_authorized')], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:500'
        ]);

        
        $message = $stream->chatMessages()->create([
            'user_id' => auth()->id(),
            'model_id' => $stream->user_id,
            'message' => $validated['message'],
            'is_hidden' => false,
        ]);

        $message->load('user');
        try {
            event(new NewChatMessage($message));
        } catch (\Throwable $e) {
            Log::warning('Stream chat broadcast failed (message saved)', [
                'message_id' => $message->id,
                'stream_id' => $stream->id,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('admin.flash.stream.message_sent'),
            'chat_message' => [
                'id' => $message->id,
                'user' => [
                    'id' => $message->user->id,
                    'name' => $message->user->name,
                    'is_model' => true,
                ],
                'message' => $message->message,
                'created_at' => $message->created_at->toISOString(),
            ],
        ]);
    }

    public function getNewChatMessages(Request $request, Stream $stream)
    {
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

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

    public function pinMessage(Request $request, Stream $stream, \App\Models\ChatMessage $message)
    {
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.not_authorized')], 403);
        }

        if ($message->stream_id !== $stream->id) {
            return response()->json(['success' => false, 'message' => 'Invalido'], 400);
        }

        // Si ya está fijado, y haces clic, lo desfija
        if ($message->is_pinned) {
            $message->update(['is_pinned' => false]);
            return response()->json(['success' => true, 'is_pinned' => false]);
        }

        // Desfijar los restantes
        $stream->chatMessages()->where('is_pinned', true)->update(['is_pinned' => false]);
        
        $message->update(['is_pinned' => true]);

        return response()->json([
            'success' => true,
            'is_pinned' => true,
            'message' => [
                'id' => $message->id,
                'content' => $message->message,
                'user_name' => $message->user->name
            ]
        ]);
    }
    public function unpinAllMessages(Request $request, Stream $stream)
    {
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 403);
        }

        $stream->chatMessages()->where('is_pinned', true)->update(['is_pinned' => false]);

        return response()->json(['success' => true]);
    }

    public function streamActivityFeed(Request $request, Stream $stream)
    {
        if ($stream->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.not_authorized')], 403);
        }

        $tips = $stream->tips()->with('fan')->latest()->limit(50)->get();
        $feed = collect();
        
        foreach($tips as $tip) {
            $feed->push([
                'id' => 'tip_'.$tip->id,
                'type' => $tip->action_type ?? 'tip',
                'fan_name' => $tip->fan ? $tip->fan->name : 'Usuario',
                'amount' => $tip->amount,
                'message' => $tip->message,
                'completed' => (bool)$tip->completed,
                'raw_id' => $tip->id,
                'created_at' => $tip->created_at,
                'timestamp' => $tip->created_at->isoFormat('h:mm A'),
            ]);
        }
        
        $transactions = \App\Models\TokenTransaction::where('user_id', $stream->user_id)
            ->where('type', 'earned')
            ->where('created_at', '>=', $stream->created_at)
            ->where('description', 'LIKE', '%chat privado%')
            ->latest()
            ->limit(20)
            ->get();
            
        foreach($transactions as $trx) {
            $fanName = 'Usuario';
            if (preg_match('/de (.*?) \(/', $trx->description, $matches)) {
                $fanName = $matches[1];
            }
            
            $feed->push([
                'id' => 'trx_'.$trx->id,
                'type' => 'chat',
                'fan_name' => $fanName,
                'amount' => $trx->amount,
                'message'   => __('admin.flash.stream.private_chat_label'),
                'completed' => true,
                'raw_id' => $trx->id,
                'created_at' => $trx->created_at,
                'timestamp' => $trx->created_at->isoFormat('h:mm A'),
            ]);
        }
        
        $sortedFeed = $feed->sortBy('created_at')->values();

        return response()->json([
            'success' => true,
            'feed' => $sortedFeed
        ]);
    }
}

