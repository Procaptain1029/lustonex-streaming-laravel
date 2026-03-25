<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Achievement;
use App\Models\Mission;
use App\Models\Withdrawal;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Conversation;

use App\Notifications\ModelVerifyEmail;
use Illuminate\Auth\Notifications\VerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        if ($this->role === 'model') {
            $this->notify(new ModelVerifyEmail);
        } else {
            $this->notify(new VerifyEmail);
        }
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'tokens',
        'locale',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function streams()
    {
        return $this->hasMany(Stream::class);
    }

    public function subscriptionsAsModel()
    {
        return $this->hasMany(Subscription::class, 'model_id');
    }

    public function subscriptionsAsFan()
    {
        return $this->hasMany(Subscription::class, 'fan_id');
    }


    public function subscriptions()
    {
        return $this->subscriptionsAsFan();
    }

    public function tipsReceived()
    {
        return $this->hasMany(Tip::class, 'model_id');
    }

    public function tipsSent()
    {
        return $this->hasMany(Tip::class, 'fan_id');
    }


    public function tips()
    {
        return $this->tipsSent();
    }


    public function tokenRecharges()
    {


        return $this->hasMany(static::class)->whereRaw('1 = 0');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentMethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('last_read_at')
            ->withTimestamps();
    }


    public function progress()
    {
        return $this->hasOne(UserProgress::class);
    }

    public function activeMissions()
    {
        return $this->missions()->where('is_active', true)->wherePivot('completed', false);
    }

    public function ranks()
    {
        return $this->hasMany(ModelRank::class);
    }


    public function isModel()
    {
        return $this->role === 'model';
    }

    public function isFan()
    {
        return $this->role === 'fan' || $this->role === 'user';
    }

    public function isUser()
    {
        return $this->role === 'user' || $this->role === 'fan';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasActiveSubscriptionTo($modelId)
    {
        return $this->subscriptionsAsFan()
            ->where('model_id', $modelId)
            ->where('status', 'active')
            ->where('expires_at', '>', now())
            ->exists();
    }




    public function isVIP()
    {
        if (!$this->isModel())
            return false;


        return $this->ranks()
            ->whereIn('period_type', ['WEEKLY', 'MONTHLY'])
            ->where('rank_position', '<=', 100)
            ->exists();
    }


    public function isNew()
    {
        if (!$this->isModel())
            return false;

        return $this->created_at->diffInDays(now()) <= 14;
    }


    public function hasBadge($badgeType)
    {

        return $this->ranks()
            ->where('badge_type', $badgeType)
            ->exists();
    }


    public function getLigaIcon()
    {
        if (!$this->progress || !$this->progress->currentLevel) {
            return asset('images/badges/liga-gris.png');
        }

        $level = $this->progress->currentLevel->level_number;

        if ($level == 0)
            return asset('images/badges/liga-gris.png');
        if ($level >= 1 && $level <= 5)
            return asset('images/badges/liga-verde.png');
        if ($level >= 6 && $level <= 10)
            return asset('images/badges/liga-bronce.png');
        if ($level >= 11 && $level <= 15)
            return asset('images/badges/liga-oro.png');
        if ($level >= 16 && $level <= 20)
            return asset('images/badges/liga-diamante.png');
        if ($level == 21)
            return asset('images/badges/liga-elite.png');

        return asset('images/badges/liga-gris.png');
    }


    public function getXPPercentage()
    {
        if (!$this->progress || !$this->progress->currentLevel)
            return 0;

        $currentLevel = $this->progress->currentLevel;
        $nextLevel = \App\Models\Level::where('level_number', $currentLevel->level_number + 1)->first();

        if (!$nextLevel)
            return 100;

        $currentXP = $this->progress->current_xp;
        $requiredXP = $nextLevel->xp_required;
        $baseXP = $currentLevel->xp_required;





        $range = $requiredXP - $baseXP;
        if ($range <= 0)
            return 100;

        $progressXP = $currentXP - $baseXP;

        return min(100, max(0, ($progressXP / $range) * 100));
    }


    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'user_id', 'model_id')
            ->withTimestamps();
    }


    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'model_id', 'user_id')
            ->withTimestamps();
    }


    public function hasFavorite($modelId)
    {
        return $this->favorites()->where('model_id', $modelId)->exists();
    }


    public function toggleFavorite($modelId)
    {
        $isFavorited = $this->hasFavorite($modelId);

        if ($isFavorited) {
            $this->favorites()->detach($modelId);
            return false;
        } else {
            $this->favorites()->attach($modelId);



            app(\App\Services\GamificationService::class)->awardXp($this, 50);
            app(\App\Services\GamificationService::class)->processMissionProgress($this, 'favorite_added', 1);

            return true;
        }
    }


    public function isFriend($modelId)
    {

        return false;
    }


    public function isSubscribedToClub($modelId)
    {
        return $this->hasActiveSubscriptionTo($modelId);
    }


    public function getClubTier($modelId)
    {
        $subscription = $this->subscriptionsAsFan()
            ->where('model_id', $modelId)
            ->where('status', 'active')
            ->first();

        return $subscription ? ($subscription->tier ?? 'Supporter') : null;
    }


    public function isModerator($modelId)
    {

        return false;
    }


    public function clubMembersCount()
    {
        if (!$this->isModel())
            return 0;

        return $this->subscriptionsAsModel()
            ->where('status', 'active')
            ->count();
    }


    public function totalShowTime()
    {
        if (!$this->isModel())
            return '0h';

        $totalMinutes = $this->streams()->sum('duration_minutes') ?? 0;
        $hours = floor($totalMinutes / 60);

        return $hours . 'h';
    }




    public function getXPFromTokens()
    {

        return $this->payments()
            ->where('status', 'completed')
            ->where('payment_type', 'tokens')
            ->sum('tokens_purchased');
    }


    public function getXPFromTips()
    {

        return $this->tipsSent()->where('status', 'completed')->sum('amount');
    }


    public function getXPFromSubscriptions()
    {
        return $this->subscriptionsAsFan()->count() * 100;
    }




    public function getActiveMissionsByType($type)
    {


        $missions = collect([]);

        if ($type === 'tokens') {
            $missions->push([
                'title' => __('admin.models.user.missions.tokens.title'),
                'current' => min($this->tokens ?? 0, 1000),
                'target' => 1000,
                'progress' => min(($this->tokens ?? 0) / 1000 * 100, 100),
                'reward' => __('admin.models.user.missions.tokens.reward')
            ]);
        } elseif ($type === 'subscription') {
            $subCount = $this->subscriptionsAsFan()->where('status', 'active')->count();
            $missions->push([
                'title' => __('admin.models.user.missions.subscription.title'),
                'current' => $subCount,
                'target' => 3,
                'progress' => min($subCount / 3 * 100, 100),
                'reward' => __('admin.models.user.missions.subscription.reward')
            ]);
        } elseif ($type === 'daily') {
            $missions->push([
                'id' => 1,
                'title' => __('admin.models.user.missions.daily_tip.title'),
                'description' => __('admin.models.user.missions.daily_tip.description'),
                'type' => 'daily',
                'current' => min($this->tipsSent()->whereDate('created_at', today())->count(), 5),
                'target' => 5,
                'progress' => min($this->tipsSent()->whereDate('created_at', today())->count() / 5 * 100, 100),
                'reward_xp' => 50,
                'reward_tickets' => 5,
                'expires_at' => now()->endOfDay(),
                'completed' => $this->tipsSent()->whereDate('created_at', today())->count() >= 5
            ]);
        } elseif ($type === 'weekly') {
            $missions->push([
                'id' => 2,
                'title' => __('admin.models.user.missions.weekly_login.title'),
                'description' => __('admin.models.user.missions.weekly_login.description'),
                'type' => 'weekly',
                'current' => rand(0, 3),
                'target' => 3,
                'progress' => rand(0, 100),
                'reward_xp' => 100,
                'reward_tickets' => 15,
                'expires_at' => now()->endOfWeek(),
                'completed' => false
            ]);
        } elseif ($type === 'monthly') {
            $missions->push([
                'id' => 3,
                'title' => __('admin.models.user.missions.monthly_spend.title'),
                'description' => __('admin.models.user.missions.monthly_spend.description'),
                'type' => 'monthly',
                'current' => min($this->tipsSent()->whereMonth('created_at', now()->month)->sum('amount'), 5000),
                'target' => 5000,
                'progress' => min($this->tipsSent()->whereMonth('created_at', now()->month)->sum('amount') / 5000 * 100, 100),
                'reward_xp' => 500,
                'reward_tickets' => 50,
                'expires_at' => now()->endOfMonth(),
                'completed' => $this->tipsSent()->whereMonth('created_at', now()->month)->sum('amount') >= 5000
            ]);
        } elseif ($type === 'obligatory') {
            $currentLevel = $this->progress ? $this->progress->currentLevel->level_number : 0;
            $nextLevel = $currentLevel + 1;
            $missions->push([
                'id' => 999,
                'title' => __('admin.models.user.missions.obligatory_level.title', ['xp' => ($this->progress ? $this->progress->currentLevel->xp_required : 1000)]),
                'description' => __('admin.models.user.missions.obligatory_level.description', ['level' => $nextLevel]),
                'type' => 'obligatory',
                'current' => $this->progress ? $this->progress->current_xp : 0,
                'target' => $this->progress ? $this->progress->currentLevel->xp_required : 1000,
                'progress' => $this->getXPPercentage(),
                'reward_xp' => 0,
                'reward_tickets' => 0,
                'reward_level' => $nextLevel,
                'expires_at' => null,
                'completed' => false
            ]);
        }

        return $missions;
    }




    public function getCashbackPercentage()
    {
        $level = ($this->progress && $this->progress->currentLevel) ? $this->progress->currentLevel->level_number : 0;

        if ($level >= 16)
            return 10;
        if ($level >= 6)
            return 5;

        return 0;
    }


    public function getSubscriptionDiscount()
    {
        $level = ($this->progress && $this->progress->currentLevel) ? $this->progress->currentLevel->level_number : 0;

        if ($level >= 21)
            return 20;
        if ($level >= 16)
            return 15;
        if ($level >= 11)
            return 10;
        if ($level >= 6)
            return 5;

        return 0;
    }


    public function getNextTokenBenefit()
    {
        $level = ($this->progress && $this->progress->currentLevel) ? $this->progress->currentLevel->level_number : 0;

        if ($level < 6) {
            return [
                'required_level' => 6,
                'description' => __('admin.models.user.token_benefits.level_6')
            ];
        }
        if ($level < 16) {
            return [
                'required_level' => 16,
                'description' => __('admin.models.user.token_benefits.level_16')
            ];
        }

        return null;
    }




    public function getRecommendedModels()
    {


        $subscribedIds = $this->subscriptionsAsFan()
            ->where('status', 'active')
            ->pluck('model_id')
            ->toArray();

        return User::where('role', 'model')
            ->whereNotIn('id', $subscribedIds)
            ->with('profile')
            ->inRandomOrder()
            ->take(6)
            ->get();
    }






    public function getActiveModelMissions()
    {

        return collect([
            [
                'id' => 1,
                'title' => __('admin.models.user.missions.model_weekly_photos.title'),
                'description' => __('admin.models.user.missions.model_weekly_photos.description'),
                'icon' => 'fa-camera',
                'current' => 2,
                'target' => 5,
                'xp_reward' => 100,
                'ticket_reward' => 2,
                'type' => 'weekly'
            ],
            [
                'id' => 2,
                'title' => __('admin.models.user.missions.model_monthly_streams.title'),
                'description' => __('admin.models.user.missions.model_monthly_streams.description'),
                'icon' => 'fa-video',
                'current' => 1,
                'target' => 3,
                'xp_reward' => 200,
                'ticket_reward' => 5,
                'type' => 'monthly'
            ],
            [
                'id' => 3,
                'title' => __('admin.models.user.missions.model_daily_tips.title'),
                'description' => __('admin.models.user.missions.model_daily_tips.description'),
                'icon' => 'fa-coins',
                'current' => 7,
                'target' => 10,
                'xp_reward' => 50,
                'ticket_reward' => 1,
                'type' => 'daily'
            ],
        ]);
    }


    public function getModelRank()
    {
        if (!$this->progress) {
            return 999;
        }

        $rank = User::where('role', 'model')
            ->join('user_progress', 'users.id', '=', 'user_progress.user_id')
            ->where('user_progress.total_xp', '>', $this->progress->total_xp)
            ->count();

        return $rank + 1;
    }


    public function getModelBenefits()
    {
        $level = ($this->progress && $this->progress->currentLevel) ? $this->progress->currentLevel->level_number : 0;
        $benefits = [];

        if ($level >= 5) {
            $benefits[] = [
                'name' => __('admin.models.user.benefits.reduced_commission.name'),
                'description' => __('admin.models.user.benefits.reduced_commission.description'),
                'icon' => 'fa-percentage',
                'level' => 5
            ];
        }

        if ($level >= 10) {
            $benefits[] = [
                'name' => __('admin.models.user.benefits.search_priority.name'),
                'description' => __('admin.models.user.benefits.search_priority.description'),
                'icon' => 'fa-search',
                'level' => 10
            ];
        }

        if ($level >= 15) {
            $benefits[] = [
                'name' => __('admin.models.user.benefits.vip_badge.name'),
                'description' => __('admin.models.user.benefits.vip_badge.description'),
                'icon' => 'fa-star',
                'level' => 15
            ];
        }

        if ($level >= 20) {
            $benefits[] = [
                'name' => __('admin.models.user.benefits.priority_support.name'),
                'description' => __('admin.models.user.benefits.priority_support.description'),
                'icon' => 'fa-headset',
                'level' => 20
            ];
        }

        return collect($benefits);
    }


    public function getNextModelBenefit()
    {
        $level = ($this->progress && $this->progress->currentLevel) ? $this->progress->currentLevel->level_number : 0;

        $allBenefits = [
            5 => [
                'name' => __('admin.models.user.benefits.reduced_commission.name'),
                'description' => __('admin.models.user.benefits.reduced_commission.description'),
                'icon' => 'fa-percentage',
                'level' => 5
            ],
            10 => [
                'name' => __('admin.models.user.benefits.search_priority.name'),
                'description' => __('admin.models.user.benefits.search_priority.description'),
                'icon' => 'fa-search',
                'level' => 10
            ],
            15 => [
                'name' => __('admin.models.user.benefits.vip_badge.name'),
                'description' => __('admin.models.user.benefits.vip_badge.description'),
                'icon' => 'fa-star',
                'level' => 15
            ],
            20 => [
                'name' => __('admin.models.user.benefits.priority_support.name'),
                'description' => __('admin.models.user.benefits.priority_support.description'),
                'icon' => 'fa-headset',
                'level' => 20
            ],
        ];

        foreach ($allBenefits as $requiredLevel => $benefit) {
            if ($level < $requiredLevel) {
                return $benefit;
            }
        }

        return null;
    }


    public function getCommissionRate()
    {
        $level = ($this->progress && $this->progress->currentLevel)
            ? $this->progress->currentLevel->level_number
            : 0;

        if ($level >= 20)
            return 10;
        if ($level >= 15)
            return 12;
        if ($level >= 10)
            return 15;
        if ($level >= 5)
            return 15;

        return 20;
    }






    public function specialBadges()
    {
        return $this->belongsToMany(SpecialBadge::class, 'user_badges', 'user_id', 'badge_id')
            ->withTimestamps()
            ->withPivot('earned_at');
    }


    public function getDisplayBadges()
    {
        return $this->specialBadges()
            ->orderBy('user_badges.earned_at', 'desc')
            ->take(3)
            ->get();
    }


    public function gamificationEvents()
    {
        return $this->belongsToMany(GamificationEvent::class, 'event_participants')
            ->withPivot('score', 'rank', 'progress')
            ->withTimestamps();
    }






    public function badges()
    {
        return $this->specialBadges();
    }


    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withTimestamps()
            ->withPivot('unlocked_at');
    }


    public function getAchievements()
    {
        $role = $this->role;
        $allAchievements = Achievement::forRole($role);
        $unlockedIds = $this->achievements->pluck('id')->toArray();

        return $allAchievements->map(function ($achievement) use ($unlockedIds) {
            return [
                'id' => $achievement->id,
                'name' => $achievement->name,
                'description' => $achievement->description,
                'icon' => $achievement->icon,
                'rarity' => $achievement->rarity,
                'category' => $achievement->category,
                'xp_reward' => $achievement->xp_reward,
                'ticket_reward' => $achievement->ticket_reward,
                'unlocked' => in_array($achievement->id, $unlockedIds),
                'unlocked_at' => in_array($achievement->id, $unlockedIds)
                    ? $this->achievements->find($achievement->id)->pivot->unlocked_at
                    : null,
            ];
        });
    }


    public function missions()
    {
        return $this->belongsToMany(Mission::class, 'user_missions')
            ->withPivot('progress', 'completed', 'completed_at')
            ->withTimestamps();
    }


    public function getActiveMissions()
    {
        return $this->missions()
            ->where('is_active', true)
            ->where('completed', false)
            ->get()
            ->map(function ($mission) {
                return [
                    'id' => $mission->id,
                    'title' => $mission->name,
                    'description' => $mission->description,
                    'icon' => $mission->icon ?? 'fa-star',
                    'type' => $mission->type,
                    'current' => $mission->pivot->progress,
                    'target' => $mission->goal_amount,
                    'xp_reward' => $mission->reward_xp,
                    'ticket_reward' => $mission->reward_tickets,
                    'completed' => (bool) $mission->pivot->completed,
                    'progress' => ($mission->goal_amount > 0) ? min(100, ($mission->pivot->progress / $mission->goal_amount) * 100) : 0,
                ];
            });
    }


    public function getCompletedMissionsCount()
    {
        return $this->missions()->wherePivot('completed', true)->count();
    }


    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
