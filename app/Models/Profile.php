<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'display_name',
        'bio',
        'avatar',
        'cover_image',
        'subscription_price',
        'is_online',
        'is_streaming',
        
        'country',
        'languages',
        'age',
        'interested_in',
        'body_type',
        'specific_details',
        'ethnicity',
        'hair_color',
        'eye_color',
        'subculture',
        'interests',
        'social_networks',
        'profile_completed',
        'last_profile_update',
        
        'verification_status',
        'legal_name',
        'date_of_birth',
        'id_document_front',
        'id_document_back',
        'id_document_selfie',
        'id_document_type',
        'admin_notes',
        'rejection_reason',
        'verified_at',
        'verified_by',
        'step1_completed',
        'step2_completed',
        'step3_completed',
        'onboarding_completed_at',
        'terms_accepted',
        'age_verified',
        
        'stream_key',
        'obs_connected',
        'last_obs_connection',
        'pause_image',
        'pause_video',
        'pause_mode',
        'chat_unlock_price',
        'chat_unlock_duration',
    ];

    protected $casts = [
        'subscription_price' => 'decimal:2',
        'is_online' => 'boolean',
        'is_streaming' => 'boolean',
        'languages' => 'array',
        'specific_details' => 'array',
        'interests' => 'array',
        'social_networks' => 'array',
        'profile_completed' => 'boolean',
        'last_profile_update' => 'datetime',
        'date_of_birth' => 'date',
        
        'verified_at' => 'datetime',
        'onboarding_completed_at' => 'datetime',
        'step1_completed' => 'boolean',
        'step2_completed' => 'boolean',
        'step3_completed' => 'boolean',
        'terms_accepted' => 'boolean',
        'age_verified' => 'boolean',
        
        'obs_connected' => 'boolean',
        'last_obs_connection' => 'datetime',
        'chat_unlock_price' => 'integer',
        'chat_unlock_duration' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->hasMany(ProfileView::class);
    }

    public function getAvatarUrlAttribute()
    {
        if (!$this->avatar) {
            return asset('avatar.jpg'); 
        }
        
        
        if (str_starts_with($this->avatar, 'avatars/')) {
            return asset('storage/' . $this->avatar);
        }
        
        
        if (str_starts_with($this->avatar, 'avatar/')) {
            return asset($this->avatar);
        }
        
        
        return asset('storage/avatars/' . $this->avatar);
    }

    public function getCoverImageUrlAttribute()
    {
        if (!$this->cover_image) {
            return null;
        }
        
        if (str_starts_with($this->cover_image, 'images/')) {
            return asset($this->cover_image);
        }

        
        if (str_starts_with($this->cover_image, 'avatar/')) {
            return asset($this->cover_image);
        }
        
        
        if (str_starts_with($this->cover_image, 'covers/')) {
            return asset('storage/' . $this->cover_image);
        }
        
        
        return asset('storage/covers/' . $this->cover_image);
    }

    
    public function getLanguagesListAttribute()
    {
        if (!$this->languages) return __('admin.models.profile.not_specified');
        
        $languages = is_string($this->languages) ? json_decode($this->languages, true) : $this->languages;
        return is_array($languages) ? implode(', ', $languages) : __('admin.models.profile.not_specified');
    }

    public function getSpecificDetailsListAttribute()
    {
        if (!$this->specific_details) return __('admin.models.profile.not_specified');
        
        $details = is_string($this->specific_details) ? json_decode($this->specific_details, true) : $this->specific_details;
        if (!is_array($details)) return __('admin.models.profile.not_specified');
        
        $formatted = [];
        foreach ($details as $key => $value) {
            
            $keyTranslations = [
                'altura' => __('admin.models.profile.height'),
                'peso' => __('admin.models.profile.weight'), 
                'medidas' => __('admin.models.profile.measurements'),
                'height' => __('admin.models.profile.height'),
                'weight' => __('admin.models.profile.weight'),
                'measurements' => __('admin.models.profile.measurements')
            ];
            
            $displayKey = $keyTranslations[$key] ?? ucfirst($key);
            $formatted[] = $displayKey . ': ' . $value;
        }
        return implode(' • ', $formatted);
    }

    public function getInterestsListAttribute()
    {
        if (!$this->interests) return __('admin.models.profile.not_specified');
        
        $interests = is_string($this->interests) ? json_decode($this->interests, true) : $this->interests;
        return is_array($interests) ? implode(', ', $interests) : __('admin.models.profile.not_specified');
    }

    public function getSocialNetworksListAttribute()
    {
        if (!$this->social_networks) return __('admin.models.profile.not_specified');
        
        $networks = is_string($this->social_networks) ? json_decode($this->social_networks, true) : $this->social_networks;
        if (!is_array($networks)) return __('admin.models.profile.not_specified');
        
        $formatted = [];
        $platformIcons = [
            'instagram' => '📷',
            'twitter' => '🐦',
            'tiktok' => '🎵',
            'facebook' => '📘',
            'youtube' => '📺',
            'onlyfans' => '🔥'
        ];
        
        foreach ($networks as $platform => $username) {
            $icon = $platformIcons[strtolower($platform)] ?? '🌐';
            $label = __('admin.models.profile.social_networks.' . strtolower($platform)) ?? ucfirst($platform);
            $formatted[] = $icon . ' ' . $label . ': ' . $username;
        }
        return implode(' • ', $formatted);
    }

    public function getAgeDisplayAttribute()
    {
        return $this->age ? $this->age . ' ' . __('admin.models.profile.years_old') : __('admin.models.profile.not_specified');
    }

    public function getBodyTypeDisplayAttribute()
    {
        $bodyTypes = [
            'Delgado' => __('admin.models.profile.body_types.Delgado'),
            'Atlético' => __('admin.models.profile.body_types.Atlético'), 
            'Talla mediana' => __('admin.models.profile.body_types.Talla mediana'),
            'Con curvas' => __('admin.models.profile.body_types.Con curvas'),
            'BBW' => __('admin.models.profile.body_types.BBW')
        ];
        
        return $bodyTypes[$this->body_type] ?? $this->body_type ?? __('admin.models.profile.not_specified');
    }

    public function getEthnicityDisplayAttribute()
    {
        $ethnicities = [
            'Blanca' => __('admin.models.profile.ethnicities.Blanca'),
            'Latina' => __('admin.models.profile.ethnicities.Latina'),
            'Asiática' => __('admin.models.profile.ethnicities.Asiática'),
            'Árabe' => __('admin.models.profile.ethnicities.Árabe'),
            'Negra' => __('admin.models.profile.ethnicities.Negra'),
            'India' => __('admin.models.profile.ethnicities.India'),
            'Multiétnica' => __('admin.models.profile.ethnicities.Multiétnica')
        ];
        
        return $ethnicities[$this->ethnicity] ?? $this->ethnicity ?? __('admin.models.profile.not_specified');
    }

    public function getHairColorDisplayAttribute()
    {
        $hairColors = [
            'Rubio' => __('admin.models.profile.hair_colors.Rubio'),
            'Moreno' => __('admin.models.profile.hair_colors.Moreno'),
            'Pelo Negro' => __('admin.models.profile.hair_colors.Pelo Negro'),
            'Colorido' => __('admin.models.profile.hair_colors.Colorido'),
            'Pelirroja' => __('admin.models.profile.hair_colors.Pelirroja')
        ];
        
        return $hairColors[$this->hair_color] ?? $this->hair_color ?? __('admin.models.profile.not_specified');
    }

    public function getCountryFlagAttribute()
    {
        $flags = [
            'Colombia' => '🇨🇴',
            'Argentina' => '🇦🇷',
            'México' => '🇲🇽',
            'España' => '🇪🇸',
            'Brasil' => '🇧🇷',
            'Chile' => '🇨🇱',
            'Perú' => '🇵🇪',
            'Venezuela' => '🇻🇪',
            'Ecuador' => '🇪🇨',
            'Uruguay' => '🇺🇾',
            'Estados Unidos' => '🇺🇸',
            'Canadá' => '🇨🇦',
            'Francia' => '🇫🇷',
            'Italia' => '🇮🇹',
            'Alemania' => '🇩🇪',
            'Reino Unido' => '🇬🇧',
            'Rusia' => '🇷🇺',
            'Ucrania' => '🇺🇦',
            'Polonia' => '🇵🇱',
            'República Checa' => '🇨🇿'
        ];
        
        return $flags[$this->country] ?? '🌍';
    }

    public function getCountryDisplayAttribute()
    {
        return $this->country_flag . ' ' . ($this->country ?? __('admin.models.profile.not_specified'));
    }

    public function isProfileComplete()
    {
        return $this->profile_completed && 
               !empty($this->display_name) && 
               !empty($this->bio) && 
               !empty($this->country) && 
               !empty($this->age);
    }

    public function updateProfileCompleteness()
    {
        $this->profile_completed = $this->isProfileComplete();
        $this->last_profile_update = now();
        $this->save();
    }

    
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    
    public function isPending()
    {
        return $this->verification_status === 'pending';
    }

    public function isUnderReview()
    {
        return $this->verification_status === 'under_review';
    }

    public function isApproved()
    {
        return $this->verification_status === 'approved';
    }

    public function isRejected()
    {
        return $this->verification_status === 'rejected';
    }

    public function canBeDisplayed()
    {
        return $this->isApproved() && $this->profile_completed;
    }

    
    public function getOnboardingProgress()
    {
        $completed = 0;
        if ($this->step1_completed) $completed++;
        if ($this->step2_completed) $completed++;
        if ($this->step3_completed) $completed++;
        
        return [
            'completed_steps' => $completed,
            'total_steps' => 3,
            'percentage' => round(($completed / 3) * 100)
        ];
    }

    public function isOnboardingComplete()
    {
        return $this->step1_completed && $this->step2_completed && $this->step3_completed;
    }

    public function getNextStep()
    {
        if (!$this->step1_completed) return 1;
        if (!$this->step2_completed) return 2;
        if (!$this->step3_completed) return 3;
        return null; 
    }

    
    public function hasDocuments()
    {
        return !empty($this->id_document_front) && !empty($this->id_document_back);
    }

    public function getDocumentFrontUrlAttribute()
    {
        return $this->id_document_front ? asset('storage/' . $this->id_document_front) : null;
    }

    public function getDocumentBackUrlAttribute()
    {
        return $this->id_document_back ? asset('storage/' . $this->id_document_back) : null;
    }

    
    public function scopePendingVerification($query)
    {
        return $query->where('verification_status', 'pending');
    }

    public function scopeUnderReview($query)
    {
        return $query->where('verification_status', 'under_review');
    }

    public function scopeApproved($query)
    {
        return $query->where('verification_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('verification_status', 'rejected');
    }

    public function scopeReadyForDisplay($query)
    {
        return $query->where('verification_status', 'approved')
                    ->where('profile_completed', true);
    }

    
    public function generateStreamKey($force = false)
    {
        if (!$this->stream_key || $force) {
            $this->stream_key = \Illuminate\Support\Str::random(32);
            $this->save();
        }
        return $this->stream_key;
    }

    public function hasStreamKey()
    {
        return !empty($this->stream_key);
    }

    public function markObsConnected()
    {
        $this->obs_connected = true;
        $this->last_obs_connection = now();
        $this->save();
    }

    public function markObsDisconnected()
    {
        $this->obs_connected = false;
        $this->save();
    }

    public function isObsConnected()
    {
        return $this->obs_connected;
    }

    public function getStreamUrl()
    {
        return "rtmp://127.0.0.1:1935/live/{$this->stream_key}";
    }

    public function getHlsUrl()
    {
        return "/hls/{$this->stream_key}.m3u8";
    }
}
