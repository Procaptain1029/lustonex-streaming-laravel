<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Obtener conteo de streams en vivo
Route::get('/streams/active-count', [App\Http\Controllers\Api\StreamController::class, 'getActiveStreamsCount']);

// Profile status API
Route::get('/profile/{model}/status', [App\Http\Controllers\Api\ProfileStatusController::class, 'show']);

// Streaming API
Route::middleware('auth')->group(function () {
    Route::get('/stream/{stream}/info', [App\Http\Controllers\StreamingController::class, 'getStreamInfo']);
    Route::get('/stream/chat/{stream}/new', [App\Http\Controllers\StreamingController::class, 'getNewChatMessages']);
    Route::post('/stream/{stream}/start-broadcast', [App\Http\Controllers\StreamingController::class, 'startBroadcast']);
    Route::post('/stream/{stream}/stop-broadcast', [App\Http\Controllers\StreamingController::class, 'stopBroadcast']);
    Route::post('/stream/{stream}/join-viewer', [App\Http\Controllers\StreamingController::class, 'joinAsViewer']);
    Route::post('/stream/{stream}/leave-viewer', [App\Http\Controllers\StreamingController::class, 'leaveAsViewer']);
});

// RTMP API (sin autenticación para callbacks de Nginx)
Route::prefix('rtmp')->group(function () {
    Route::post('/auth', [App\Http\Controllers\RTMPController::class, 'auth']);
    Route::post('/publish-done', [App\Http\Controllers\RTMPController::class, 'publishDone']);
    Route::post('/play', [App\Http\Controllers\RTMPController::class, 'play']);
    Route::post('/play-done', [App\Http\Controllers\RTMPController::class, 'playDone']);
    Route::post('/record-done', [App\Http\Controllers\RTMPController::class, 'recordDone']);
    Route::get('/stats', [App\Http\Controllers\RTMPController::class, 'stats']);
    Route::get('/check-signal/{streamKey}', [App\Http\Controllers\RTMPController::class, 'checkSignal']);
});

// RTMP API con autenticación web
Route::middleware('auth:web')->prefix('rtmp')->group(function () {
    Route::post('/generate-key', [App\Http\Controllers\RTMPController::class, 'generateStreamKey']);
    Route::get('/stream/{streamKey}', [App\Http\Controllers\RTMPController::class, 'getStreamInfo']);
    
    // Ruta de prueba para verificar autenticación
    Route::get('/test-auth', function(Request $request) {
        $user = auth('web')->user();
        return response()->json([
            'authenticated' => !!$user,
            'user_id' => $user ? $user->id : null,
            'user_role' => $user ? $user->role : null,
            'is_model' => $user ? $user->isModel() : false,
            'session_id' => $request->session()->getId()
        ]);
    });
});

// Rutas públicas para streaming (sin autenticación por ahora)
Route::post('/stream/upload-chunk', [App\Http\Controllers\StreamingController::class, 'uploadChunk']);
Route::get('/stream/{stream}/hls-playlist', [App\Http\Controllers\StreamingController::class, 'getHLSPlaylist']);
Route::get('/stream/{stream}/info', [App\Http\Controllers\StreamingController::class, 'getStreamInfo']);
Route::post('/stream/{stream}/join-viewer', [App\Http\Controllers\StreamingController::class, 'joinAsViewer']);

// SSE Streaming Routes
Route::post('/stream/{stream}/sse-chunk', [App\Http\Controllers\StreamSSEController::class, 'receiveChunk']);
Route::get('/stream/{stream}/sse', [App\Http\Controllers\StreamSSEController::class, 'streamSSE']);
Route::get('/stream/{stream}/sse-info', [App\Http\Controllers\StreamSSEController::class, 'getStreamInfo']);
