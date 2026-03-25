<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'stream_id',
        'model_id',
        'user_id',
        'message',
        'is_hidden',
        'is_pinned',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
        'is_pinned' => 'boolean',
    ];

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_hidden', false);
    }
}
