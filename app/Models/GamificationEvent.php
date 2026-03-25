<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamificationEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'starts_at',
        'ends_at',
        'rules',
        'rewards',
        'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'rules' => 'array',
        'rewards' => 'array',
        'is_active' => 'boolean',
    ];

    
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_participants')
                    ->withPivot('score', 'rank', 'progress')
                    ->withTimestamps();
    }

    
    public function isActive()
    {
        return $this->is_active 
            && now()->between($this->starts_at, $this->ends_at);
    }

    
    public function hasParticipant($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }

    
    public function addParticipant($user)
    {
        if (!$this->hasParticipant($user->id)) {
            $this->participants()->attach($user->id, [
                'score' => 0,
                'rank' => null,
                'progress' => null,
            ]);
            
            return true;
        }
        
        return false;
    }

    
    public function updateScore($userId, $score, $progress = null)
    {
        $this->participants()->updateExistingPivot($userId, [
            'score' => $score,
            'progress' => $progress,
        ]);
        
        
        $this->recalculateRanks();
    }

    
    protected function recalculateRanks()
    {
        $participants = $this->participants()
                            ->orderBy('event_participants.score', 'desc')
                            ->get();
        
        foreach ($participants as $index => $participant) {
            $this->participants()->updateExistingPivot($participant->id, [
                'rank' => $index + 1,
            ]);
        }
    }

    
    public function getLeaderboard($limit = 10)
    {
        return $this->participants()
                    ->orderBy('event_participants.score', 'desc')
                    ->take($limit)
                    ->get();
    }
}
