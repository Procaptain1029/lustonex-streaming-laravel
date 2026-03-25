<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'fee',
        'net_amount',
        'status',
        'payment_method',
        'payment_details',
        'notes',
        'rejection_reason',
        'processed_by',
        'processed_at',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'processed_at' => 'datetime',
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    
    public function calculateFee()
    {
        $feePercentage = config('app.withdrawal_fee_percentage', 5); 
        $this->fee = $this->amount * ($feePercentage / 100);
        $this->net_amount = $this->amount - $this->fee;
    }

    
    public function approve($adminId)
    {
        $this->update([
            'status' => 'completed',
            'processed_by' => $adminId,
            'processed_at' => now(),
        ]);

        
        $this->user->decrement('pending_balance', $this->amount);
    }

    
    public function reject($adminId, $reason)
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'processed_by' => $adminId,
            'processed_at' => now(),
        ]);

        
        $this->user->decrement('pending_balance', $this->amount);
        $this->user->increment('balance', $this->amount);
    }
}
