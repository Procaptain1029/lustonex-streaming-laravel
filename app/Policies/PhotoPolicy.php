<?php

namespace App\Policies;

use App\Models\Photo;
use App\Models\User;

class PhotoPolicy
{
    public function view(User $user, Photo $photo)
    {
        return $user->isAdmin() || 
               $user->id === $photo->user_id || 
               $photo->is_public ||
               $user->hasActiveSubscriptionTo($photo->user_id);
    }

    public function update(User $user, Photo $photo)
    {
        return $user->isAdmin() || $user->id === $photo->user_id;
    }

    public function delete(User $user, Photo $photo)
    {
        return $user->isAdmin() || $user->id === $photo->user_id;
    }
}
