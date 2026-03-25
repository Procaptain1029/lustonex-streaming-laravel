<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    use HasFactory;

    protected $table = 'user_progress';

    protected $fillable = [
        'user_id',
        'current_xp',
        'total_xp',
        'current_level_id',
        'tickets_balance',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currentLevel()
    {
        return $this->belongsTo(Level::class, 'current_level_id');
    }

    
    public function addXP(int $amount)
    {
        $this->current_xp += $amount;
        $this->total_xp += $amount;
        $this->save();

        
        app(\App\Services\GamificationService::class)->awardXp($this->user, 0); 
    }
}
