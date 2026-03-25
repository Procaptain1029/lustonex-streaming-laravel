<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;

    protected $fillable = [
        'fan_id',
        'model_id',
        'stream_id',
        'amount',
        'message',
        'transaction_id',
        'status',
        'completed',
        'completed_at',
        'action_type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function fan()
    {
        return $this->belongsTo(User::class, 'fan_id');
    }

    public function model()
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    
    public function sender()
    {
        return $this->fan();
    }

    
    public function receiver()
    {
        return $this->model();
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('completed', false);
    }

    public function scopeActionCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function isRoulette()
    {
        return $this->action_type === 'roulette' || str_contains($this->message ?? '', '🎲 Gira Ruleta');
    }

    public function isMenu()
    {
        return $this->action_type === 'menu' || (
            !$this->isRoulette() &&
            $this->message &&
            !str_starts_with($this->message, 'Propina')
        );
    }

    public function markAsCompleted()
    {
        $this->update([
            'completed' => true,
            'completed_at' => now(),
        ]);
    }
}
