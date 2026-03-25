<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level_number',
        'xp_required',
        'rewards_json',
        'role',
        'image',
        'achievement_ids',
        'badge_ids',
    ];

    protected $casts = [
        'rewards_json'    => 'array',
        'achievement_ids' => 'array',
        'badge_ids'       => 'array',
    ];
}
