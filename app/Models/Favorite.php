<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'model_id',
    ];

    
    public function fan()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function model()
    {
        return $this->belongsTo(User::class, 'model_id');
    }
}
