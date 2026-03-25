<?php

namespace App\Policies;

use App\Models\Stream;
use App\Models\User;

class StreamPolicy
{
    public function view(User $user, Stream $stream)
    {
        return $user->isAdmin() || 
               $user->id === $stream->user_id || 
               $user->hasActiveSubscriptionTo($stream->user_id);
    }

    public function update(User $user, Stream $stream)
    {
        return $user->isAdmin() || $user->id === $stream->user_id;
    }

    public function delete(User $user, Stream $stream)
    {
        return $user->isAdmin() || $user->id === $stream->user_id;
    }
}
