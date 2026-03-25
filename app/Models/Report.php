<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reported_id',
        'reportable_type',
        'reportable_id',
        'reason',
        'status',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    
    public function reported()
    {
        return $this->belongsTo(User::class, 'reported_id');
    }

    
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }

    
    public function reportable()
    {
        return $this->morphTo();
    }
}
