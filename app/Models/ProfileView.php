<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileView extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'viewer_id',
        'ip_address',
        'user_agent',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public $timestamps = false;

    
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    
    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewer_id');
    }

    
    public static function track($profileId)
    {
        return static::create([
            'profile_id' => $profileId,
            'viewer_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'viewed_at' => now(),
        ]);
    }

    
    public static function getUniqueViewsCount($profileId, $days = null)
    {
        $query = static::where('profile_id', $profileId)
            ->distinct('ip_address');

        if ($days) {
            $query->where('viewed_at', '>=', now()->subDays($days));
        }

        return $query->count('ip_address');
    }

    
    public static function getTotalViewsCount($profileId, $days = null)
    {
        $query = static::where('profile_id', $profileId);

        if ($days) {
            $query->where('viewed_at', '>=', now()->subDays($days));
        }

        return $query->count();
    }
}
