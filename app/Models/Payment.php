<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'payment_type',
        'status',
        'transaction_id',
        'payment_details',
        'tokens_purchased',
        'subscription_id',
        'error_message',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'amount' => 'decimal:2',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    
    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
        ]);
    }
}
