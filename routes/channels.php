<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Canal público para notificaciones de streams
Broadcast::channel('streams', function () {
    return true;
});

// Canal específico para cada stream (chat y tips)
Broadcast::channel('stream.{streamId}', function ($user, $streamId) {
    $stream = \App\Models\Stream::find($streamId);
    
    if (!$stream || $stream->status !== 'live') {
        return false;
    }
    
    // Verificar acceso al stream
    return $user->isAdmin() || 
           $user->id === $stream->user_id || 
           $user->hasActiveSubscriptionTo($stream->user_id);
});
