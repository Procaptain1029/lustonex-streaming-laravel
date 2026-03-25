<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'rarity',
        'category',
        'role',
        'requirements',
        'xp_reward',
        'ticket_reward',
        'is_active',
    ];

    protected $casts = [
        'requirements' => 'array',
        'is_active' => 'boolean',
    ];

    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withTimestamps()
                    ->withPivot('unlocked_at');
    }

    
    public function hasUser($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    
    public function unlockFor($user)
    {
        if (!$this->hasUser($user->id)) {
            $this->users()->attach($user->id, [
                'unlocked_at' => now(),
            ]);
            
            
            if ($this->xp_reward > 0) {
                $user->progress->addXP($this->xp_reward);
            }
            
            if ($this->ticket_reward > 0 && $user->progress) {
                $user->progress->increment('tickets_balance', $this->ticket_reward);
            }
            
            
            try {
                $user->notify(new \App\Notifications\Gamification\AchievementUnlocked($this));
            } catch (\Exception $e) {
                
                \Illuminate\Support\Facades\Log::error('Failed to send achievement notification: ' . $e->getMessage());
            }
            
            return true;
        }
        
        return false;
    }

    
    public static function forRole($role)
    {
        return static::where('is_active', true)
                    ->where(function($query) use ($role) {
                        $query->where('role', $role)
                              ->orWhere('role', 'both');
                    })
                    ->get();
    }

    
    public static function byRarity($rarity)
    {
        return static::where('is_active', true)
                    ->where('rarity', $rarity)
                    ->get();
    }
}
