<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tokens',
        'price',
        'bonus',
        'is_limited_time',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'is_limited_time' => 'boolean',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'price' => 'decimal:2',
    ];
}
