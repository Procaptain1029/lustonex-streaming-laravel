<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'type',
        'requirements',
        'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active'    => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges', 'badge_id', 'user_id')
                    ->withTimestamps()
                    ->withPivot('earned_at');
    }

    public function hasUser($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    public function awardTo($user): bool
    {
        if (!$this->hasUser($user->id)) {
            $this->users()->attach($user->id, ['earned_at' => now()]);

            // Enviar notificación
            try {
                $user->notify(new \App\Notifications\BadgeEarnedNotification($this));
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Badge notification error: ' . $e->getMessage());
            }

            return true;
        }

        return false;
    }
}
