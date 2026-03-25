<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'fan_id',
        'model_id',
        'status',
        'starts_at',
        'expires_at',
        'amount',
        'tier',
        'payment_method',
        'transaction_id',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function fan()
    {
        return $this->belongsTo(User::class, 'fan_id');
    }

    public function model()
    {
        return $this->belongsTo(User::class, 'model_id');
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->expires_at > now();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                     ->where('expires_at', '>', now());
    }
}
