<?php

namespace App\Http\Controllers;

use App\Events\StreamStarted;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RTMPController extends Controller
{
    
    public function auth(Request $request)
    {
        $streamKey = $request->input('name');
        $clientIp = $request->ip();
        
        Log::info("RTMP Auth attempt", [
            'stream_key' => $streamKey,
            'ip' => $clientIp,
            'user_agent' => $request->userAgent()
        ]);
        
        
        $profile = \App\Models\Profile::where('stream_key', $streamKey)->first();
        
        if (!$profile) {
            Log::warning("RTMP Auth failed: Stream key not found in profiles", ['stream_key' => $streamKey]);
            return response('', 403);
        }
        
        
        
        $stream = $profile->user->streams()
            ->whereIn('status', ['pending', 'live'])
            ->orderByDesc('id')
            ->first();

        if ($stream) {
            $wasPending = $stream->status === 'pending';

            $updates = [
                'status' => 'live',
                'rtmp_url' => config('streaming.rtmp_public_url_base')."/{$streamKey}",
                'hls_url' => "/hls/live/{$streamKey}/index.m3u8",
            ];
            if (! $stream->started_at) {
                $updates['started_at'] = now();
            }
            $stream->update($updates);

            if ($wasPending) {
                event(new StreamStarted($stream));
            }

            Log::info("RTMP Auth successful: Stream record updated", ['stream_id' => $stream->id]);
        } else {
            Log::info("RTMP Auth successful: Profile valid, but no active stream record yet (Test Signal mode)", ['user_id' => $profile->user_id]);
        }
        
        
        $profile->user->profile()->update(['is_streaming' => true]);
        
        Log::info("RTMP Auth successful", [
            'user_id' => $profile->user_id,
            'stream_key' => $streamKey,
            'has_active_stream' => !!$stream
        ]);
        
        return response('', 200); 
    }
    
    
    public function publishDone(Request $request)
    {
        $streamKey = $request->input('name');
        
        Log::info("RTMP Publish done", ['stream_key' => $streamKey]);
        
        $stream = Stream::where('stream_key', $streamKey)->first();
        
        if ($stream) {
            
            $stream->update([
                'status' => 'ended',
                'ended_at' => now()
            ]);
            
            
            $stream->user->profile()->update(['is_streaming' => false]);
            
            Log::info("Stream ended", [
                'stream_id' => $stream->id,
                'duration' => $stream->started_at ? 
                    $stream->started_at->diffInMinutes($stream->ended_at) : 0
            ]);
        }
        
        return response('', 200);
    }
    
    
    public function play(Request $request)
    {
        $streamKey = $request->input('name');
        $clientIp = $request->ip();
        
        Log::info("RTMP Play started", [
            'stream_key' => $streamKey,
            'ip' => $clientIp
        ]);
        
        $stream = Stream::where('stream_key', $streamKey)->first();
        
        if ($stream) {
            
            $stream->increment('viewers_count');
            
            Log::info("Viewer joined", [
                'stream_id' => $stream->id,
                'viewers_count' => $stream->viewers_count
            ]);
        }
        
        return response('', 200);
    }
    
    
    public function playDone(Request $request)
    {
        $streamKey = $request->input('name');
        $clientIp = $request->ip();
        
        Log::info("RTMP Play ended", [
            'stream_key' => $streamKey,
            'ip' => $clientIp
        ]);
        
        $stream = Stream::where('stream_key', $streamKey)->first();
        
        if ($stream && $stream->viewers_count > 0) {
            
            $stream->decrement('viewers_count');
            
            Log::info("Viewer left", [
                'stream_id' => $stream->id,
                'viewers_count' => $stream->viewers_count
            ]);
        }
        
        return response('', 200);
    }
    
    
    public function recordDone(Request $request)
    {
        $streamKey = $request->input('name');
        $recordPath = $request->input('path');
        
        Log::info("RTMP Recording done", [
            'stream_key' => $streamKey,
            'path' => $recordPath
        ]);
        
        $stream = Stream::where('stream_key', $streamKey)->first();
        
        if ($stream && $recordPath) {
            
            $stream->update([
                'recording_path' => $recordPath,
                'has_recording' => true
            ]);
            
            
            
            
            Log::info("Recording saved", [
                'stream_id' => $stream->id,
                'recording_path' => $recordPath
            ]);
        }
        
        return response('', 200);
    }
    
    
    public function stats()
    {
        try {
            
            $rtmpStats = file_get_contents('http://localhost:8080/stat');
            
            return response($rtmpStats)
                ->header('Content-Type', 'application/xml')
                ->header('Access-Control-Allow-Origin', '*');
                
        } catch (\Exception $e) {
            Log::error("Error getting RTMP stats", ['error' => $e->getMessage()]);
            
            return response()->json([
                'error' => 'RTMP server not available',
                'message' => $e->getMessage()
            ], 503);
        }
    }
    
    
    public function generateStreamKey(Request $request)
    {
        
        $user = auth()->user();
        
        Log::info("Generate stream key request", [
            'user_id' => $user ? $user->id : null,
            'user_role' => $user ? $user->role : null,
            'is_model' => $user ? $user->isModel() : false
        ]);
        
        if (!$user) {
            Log::warning("No authenticated user found");
            return response()->json(['success' => false, 'message' => 'No authenticated user. Please login.'], 401);
        }
        
        if (!$user->isModel()) {
            Log::warning("Unauthorized stream key generation attempt", [
                'user_id' => $user->id,
                'user_role' => $user->role
            ]);
            return response()->json(['success' => false, 'message' => 'Unauthorized - Only models can generate stream keys'], 403);
        }
        
        $profile = $user->profile;
        
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Profile not found'], 404);
        }
        
        
        if ($profile->is_streaming) {
            return response()->json([
                'success' => false, 
                'message' => __('admin.flash.rtmp.key_live_error')
            ], 422);
        }
        
        
        $streamKey = $profile->generateStreamKey(true);
        
        Log::info("Stream key generated for profile", [
            'user_id' => $user->id,
            'profile_id' => $profile->id,
            'stream_key' => $streamKey
        ]);
        
        return response()->json([
            'success' => true,
            'stream_key' => $streamKey,
            'rtmp_url' => config('streaming.rtmp_public_url_base'),
            'hls_url' => "/hls/live/{$streamKey}/index.m3u8",
            'message' => __('admin.flash.rtmp.key_generated')
        ]);
    }
    
    
    public function getStreamInfo($streamKey)
    {
        $stream = Stream::where('stream_key', $streamKey)
                       ->where('status', 'live')
                       ->with('user.profile')
                       ->first();
        
        if (!$stream) {
            return response()->json(['error' => 'Stream not found or not live'], 404);
        }
        
        return response()->json([
            'stream_id' => $stream->id,
            'stream_key' => $streamKey,
            'title' => $stream->title,
            'status' => $stream->status,
            'viewers_count' => $stream->viewers_count,
            'started_at' => $stream->started_at,
            'model' => [
                'id' => $stream->user->id,
                'name' => $stream->user->name,
                'display_name' => $stream->user->profile->display_name ?? $stream->user->name,
                'avatar' => $stream->user->profile->avatar ?? null
            ],
            'hls_url' => "/hls/live/{$streamKey}/index.m3u8",
            'qualities' => [
                '720p' => "/hls/live/{$streamKey}/720p/index.m3u8",
                '480p' => "/hls/live/{$streamKey}/480p/index.m3u8",
                '360p' => "/hls/live/{$streamKey}/360p/index.m3u8"
            ]
        ]);
    }

    
    public function checkSignal($streamKey)
    {
        $hlsPath = public_path("hls/live/{$streamKey}/index.m3u8");
        $isActive = file_exists($hlsPath);
        
        return response()->json([
            'success' => true,
            'active' => $isActive,
            'stream_key' => $streamKey,
            'url' => $isActive ? asset("hls/live/{$streamKey}/index.m3u8") : null,
            'check_at' => now()->toIso8601String()
        ]);
    }
}
