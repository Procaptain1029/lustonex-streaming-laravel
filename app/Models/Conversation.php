<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'last_message_at', 'is_unlocked', 'unlocked_until'];
    
    protected $casts = [
        'last_message_at' => 'datetime',
        'is_unlocked' => 'boolean',
        'unlocked_until' => 'datetime',
    ];

    public function participants()
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_participants')
                    ->withPivot('last_read_at')
                    ->withTimestamps();
    }

    public function getOtherParticipant($userId)
    {
        return $this->users()->where('user_id', '!=', $userId)->first();
    }

    public function getUnreadCount($userId)
    {
        $participant = $this->participants()
                           ->where('user_id', $userId)
                           ->first();
        
        if (!$participant || !$participant->last_read_at) {
            return $this->messages()->count();
        }
        
        return $this->messages()
                    ->where('created_at', '>', $participant->last_read_at)
                    ->where('user_id', '!=', $userId)
                    ->count();
    }
}
