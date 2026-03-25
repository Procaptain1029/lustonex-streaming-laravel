<?php

namespace App\Http\Controllers;

use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StreamSSEController extends Controller
{
    
    private static $streamChunks = [];
    
    
    public function receiveChunk(Request $request, $streamId)
    {
        try {
            $stream = Stream::where('id', $streamId)
                           ->where('status', 'live')
                           ->first();
            
            if (!$stream) {
                return response()->json(['error' => 'Stream not found or not live'], 404);
            }
            
            $chunkData = $request->input('chunk_data');
            $timestamp = $request->input('timestamp', time());
            
            if (!$chunkData) {
                return response()->json(['error' => 'No chunk data provided'], 400);
            }
            
            
            $chunkInfo = [
                'data' => $chunkData,
                'timestamp' => $timestamp,
                'stream_id' => $streamId,
                'chunk_id' => uniqid()
            ];
            
            
            if (!isset(self::$streamChunks[$streamId])) {
                self::$streamChunks[$streamId] = [];
            }
            
            self::$streamChunks[$streamId][] = $chunkInfo;
            
            
            if (count(self::$streamChunks[$streamId]) > 10) {
                array_shift(self::$streamChunks[$streamId]);
            }
            
            \Log::info("Chunk recibido para stream {$streamId}: " . strlen($chunkData) . " caracteres");
            
            return response()->json([
                'success' => true,
                'message' => 'Chunk received successfully',
                'chunk_id' => $chunkInfo['chunk_id']
            ]);
            
        } catch (\Exception $e) {
            \Log::error("Error receiving chunk: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    
    
    public function streamSSE(Request $request, $streamId)
    {
        $stream = Stream::where('id', $streamId)
                       ->where('status', 'live')
                       ->first();
        
        if (!$stream) {
            return response('Stream not found', 404);
        }
        
        return response()->stream(function () use ($streamId) {
            
            echo "data: " . json_encode(['type' => 'connected', 'stream_id' => $streamId]) . "\n\n";
            ob_flush();
            flush();
            
            $lastChunkIndex = 0;
            $startTime = time();
            $maxDuration = 3600; 
            
            while (time() - $startTime < $maxDuration) {
                
                if (isset(self::$streamChunks[$streamId])) {
                    $chunks = self::$streamChunks[$streamId];
                    $totalChunks = count($chunks);
                    
                    
                    if ($totalChunks > $lastChunkIndex) {
                        for ($i = $lastChunkIndex; $i < $totalChunks; $i++) {
                            $chunk = $chunks[$i];
                            
                            $data = [
                                'type' => 'video_chunk',
                                'chunk_id' => $chunk['chunk_id'],
                                'data' => $chunk['data'],
                                'timestamp' => $chunk['timestamp']
                            ];
                            
                            echo "data: " . json_encode($data) . "\n\n";
                            ob_flush();
                            flush();
                        }
                        
                        $lastChunkIndex = $totalChunks;
                    }
                }
                
                
                if (time() % 30 === 0) {
                    echo "data: " . json_encode(['type' => 'heartbeat', 'timestamp' => time()]) . "\n\n";
                    ob_flush();
                    flush();
                }
                
                
                $stream = Stream::find($streamId);
                if (!$stream || $stream->status !== 'live') {
                    echo "data: " . json_encode(['type' => 'stream_ended']) . "\n\n";
                    ob_flush();
                    flush();
                    break;
                }
                
                
                usleep(100000);
            }
            
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Headers' => 'Cache-Control'
        ]);
    }
    
    
    public function getStreamInfo($streamId)
    {
        $stream = Stream::find($streamId);
        
        if (!$stream) {
            return response()->json(['error' => 'Stream not found'], 404);
        }
        
        $hasChunks = isset(self::$streamChunks[$streamId]) && count(self::$streamChunks[$streamId]) > 0;
        
        return response()->json([
            'stream_id' => $streamId,
            'status' => $stream->status,
            'title' => $stream->title,
            'model_name' => $stream->user->name,
            'viewers_count' => $stream->viewers_count,
            'has_chunks' => $hasChunks,
            'chunk_count' => $hasChunks ? count(self::$streamChunks[$streamId]) : 0
        ]);
    }
}
