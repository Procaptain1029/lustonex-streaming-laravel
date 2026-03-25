<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'role',
        'level_id',
        'achievement_id',
        'badge_id',
        'target_action',
        'goal_amount',
        'reward_xp',
        'reward_tickets',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }

    public function badge()
    {
        return $this->belongsTo(SpecialBadge::class, 'badge_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_missions')
                    ->withPivot('progress', 'completed', 'completed_at', 'expires_at')
                    ->withTimestamps();
    }

    public function scopeForRole($query, $role)
    {
        return $query->whereIn('role', [$role, 'both']);
    }

    public function scopeForLevel($query, $levelId)
    {
        return $query->where('level_id', $levelId);
    }

    public function assignTo($user)
    {
        if (!$this->users()->where('user_id', $user->id)->exists()) {
            $this->users()->attach($user->id, [
                'progress'   => 0,
                'completed'  => false,
                'completed_at' => null,
                'expires_at' => null,
            ]);
            return true;
        }
        return false;
    }

    public function updateProgress($userId, $amount)
    {
        $userMission = $this->users()->where('user_id', $userId)->first();

        if (!$userMission) {
            return false;
        }

        $newProgress = min($userMission->pivot->progress + $amount, $this->goal_amount);

        $this->users()->updateExistingPivot($userId, [
            'progress' => $newProgress,
        ]);

        if ($newProgress >= $this->goal_amount && !$userMission->pivot->completed) {
            $this->complete($userId);
        }

        return true;
    }

    public function complete($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return false;
        }

        $this->users()->updateExistingPivot($userId, [
            'completed'    => true,
            'completed_at' => now(),
        ]);

        if ($this->reward_xp > 0 && $user->progress) {
            $user->progress->addXP($this->reward_xp);
        }

        if ($this->reward_tickets > 0 && $user->progress) {
            $user->progress->increment('tickets_balance', $this->reward_tickets);
        }

        // Otorgar logro vinculado
        if ($this->achievement_id) {
            try {
                $achievement = Achievement::find($this->achievement_id);
                if ($achievement) {
                    $achievement->unlockFor($user);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mission: failed to unlock achievement: ' . $e->getMessage());
            }
        }

        // Otorgar insignia vinculada
        if ($this->badge_id) {
            try {
                $badge = SpecialBadge::find($this->badge_id);
                if ($badge) {
                    $badge->awardTo($user);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Mission: failed to award badge: ' . $e->getMessage());
            }
        }

        return true;
    }

    public static function active()
    {
        return static::where('is_active', true)->get();
    }
}
