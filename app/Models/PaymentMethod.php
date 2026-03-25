<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'method_type',
        'method_details',
        'is_default',
    ];

    protected $casts = [
        'method_details' => 'encrypted:array',
        'is_default' => 'boolean',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function setAsDefault()
    {
        
        static::where('user_id', $this->user_id)
              ->where('id', '!=', $this->id)
              ->update(['is_default' => false]);
        
        $this->update(['is_default' => true]);
    }
}
