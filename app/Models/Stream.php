<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'stream_key',
        'rtmp_url',
        'playback_url',
        'viewers_count',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'viewers_count' => 'integer',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($stream) {
            if (!$stream->stream_key) {
                $stream->stream_key = Str::random(32);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tips()
    {
        return $this->hasMany(Tip::class);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function isLive()
    {
        return $this->status === 'live';
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function incrementViewers()
    {
        $this->increment('viewers_count');
    }

    public function decrementViewers()
    {
        if ($this->viewers_count > 0) {
            $this->decrement('viewers_count');
        }
    }

    public function getFormattedDurationAttribute()
    {
        if (!$this->started_at) return '00:00:00';
        
        $end = $this->ended_at ?? now();
        $diff = $this->started_at->diff($end);
        
        return sprintf('%02d:%02d:%02d', 
            ($diff->days * 24) + $diff->h, 
            $diff->i, 
            $diff->s
        );
    }

    public function getTotalEarningsAttribute()
    {
        return $this->tips()->sum('amount');
    }
}
