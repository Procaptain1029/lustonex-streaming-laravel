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

    if (!$stream || !in_array($stream->status, ['live', 'paused'], true)) {
        return false;
    }

    // Keep owner/admin access, but also allow authenticated fans to receive live stream events.
    return $user->isAdmin() || $user->id === $stream->user_id || $user->isFan();
});

Broadcast::channel('presence-stream.{streamId}', function ($user, $streamId) {
    $stream = \App\Models\Stream::find($streamId);
    if (! $stream) {
        return false;
    }

    if ($stream->status === 'pending') {
        return $user->isAdmin() || (int) $user->id === (int) $stream->user_id;
    }

    if (! in_array($stream->status, ['live', 'paused'], true)) {
        return false;
    }

    // WebRTC signaling channel: allow authenticated fans to join while stream is active.
    if (! $user->isAdmin() && $user->id !== $stream->user_id && ! $user->isFan()) {
        return false;
    }

    return [
        'id' => $user->id,
        'name' => $user->name,
    ];
});
