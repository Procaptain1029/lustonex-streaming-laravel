<?php

namespace App\Policies;

use App\Models\Video;
use App\Models\User;

class VideoPolicy
{
    public function view(User $user, Video $video)
    {
        return $user->isAdmin() || 
               $user->id === $video->user_id || 
               $video->is_public ||
               $user->hasActiveSubscriptionTo($video->user_id);
    }

    public function update(User $user, Video $video)
    {
        return $user->isAdmin() || $user->id === $video->user_id;
    }

    public function delete(User $user, Video $video)
    {
        return $user->isAdmin() || $user->id === $video->user_id;
    }
}
