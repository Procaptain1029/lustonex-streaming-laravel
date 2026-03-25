<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'path',
        'thumbnail',
        'is_public',
        'status',
        'views',
        'file_size',
        'mime_type',
        'original_name',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute()
    {
        if (str_starts_with($this->path, 'avatar/')) {
            return asset($this->path);
        }
        return asset('storage/' . $this->path);
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? asset('storage/' . $this->thumbnail) : $this->url;
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function getFileSizeHumanAttribute()
    {
        if (!$this->file_size) return 'N/A';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getImageDimensions()
    {
        $path = storage_path('app/public/' . $this->path);
        
        if (file_exists($path)) {
            $imageInfo = getimagesize($path);
            return [
                'width' => $imageInfo[0] ?? null,
                'height' => $imageInfo[1] ?? null,
            ];
        }
        
        return ['width' => null, 'height' => null];
    }

    public function isImage()
    {
        return $this->mime_type && str_starts_with($this->mime_type, 'image/');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
