<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelRank extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'score',
        'period_type', 
        'period_date',
        'rank_position',
    ];

    protected $casts = [
        'score' => 'decimal:4',
        'period_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
