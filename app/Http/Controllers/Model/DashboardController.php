<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $rankingService;

    public function __construct(\App\Services\RankingService $rankingService)
    {
        $this->rankingService = $rankingService;
    }

    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;


        
        if ($profile->isRejected()) {
            session()->flash('error', __('admin.flash.model.rejected_flash', ['reason' => $profile->rejection_reason]));
        }

        
        if ($profile->isUnderReview()) {
            session()->flash('info', __('admin.flash.model.under_review_flash'));
        }

        
        if (!$profile->isApproved()) {
            $stats = [
                'verification_status' => $profile->verification_status,
                'total_subscribers' => 0,
                'total_tips' => 0,
                'total_photos' => 0,
                'total_videos' => 0,
                'total_streams' => 0,
                'recent_tips' => collect(),
                'recent_subscribers' => collect(),
            ];
        } else {
            $stats = [
                'verification_status' => $profile->verification_status,
                'total_subscribers' => $user->subscriptionsAsModel()->where('status', 'active')->count(),
                'total_subscription_earnings' => $user->subscriptionsAsModel()
                    ->where('status', 'active')
                    ->sum('amount'),
                'total_tips' => $user->tipsReceived()->where('status', 'completed')->sum('amount'),
                'total_photos' => $user->photos()->count(),
                'total_videos' => $user->videos()->count(),
                'total_streams' => $user->streams()->count(),
                'total_earnings' => \App\Models\TokenTransaction::where('user_id', $user->id)
                    ->where('type', 'earned')
                    ->sum('amount'),
                'total_tips' => \App\Models\TokenTransaction::where('user_id', $user->id)
                    ->where('type', 'earned')
                    ->where('description', 'not like', 'Suscripción%')
                    ->sum('amount'),
                'recent_tips' => $user->tipsReceived()->with('fan')->latest()->take(10)->get(),
                'recent_subscribers' => $user->subscriptionsAsModel()
                    ->where('status', 'active')
                    ->with('fan')
                    ->latest()
                    ->take(10)
                    ->get(),
            ];
        }

        
        if ($profile->isApproved()) {
            $userProgress = $user->progress;
            $currentLevel = $userProgress ? $userProgress->currentLevel : null;
            $nextLevel = ($currentLevel && $currentLevel->level_number !== null) ? \App\Models\Level::where('level_number', $currentLevel->level_number + 1)->first() : null;

            $currentXP = $userProgress ? $userProgress->current_xp : 0;
            $requiredXP = $currentLevel ? $currentLevel->xp_required : 100;
            $xpPercentage = $requiredXP > 0 ? ($currentXP / $requiredXP) * 100 : 0;

            
            $activeMissions = $user->getActiveMissions()->take(3);

            
            
            $models = \App\Models\User::where('role', 'model')
                ->whereHas('progress')
                ->whereHas('profile', function ($query) {
                    $query->where('verification_status', 'approved');
                })
                ->with(['progress.currentLevel', 'profile'])
                ->get();

            
            $modelsWithScore = $models->map(function ($model) {
                $erank = $this->rankingService->calculateScore($model, 'WEEKLY');
                $model->erank = $erank; 
                return $model;
            });

            
            $sortedModels = $modelsWithScore->sortBy([
                ['erank', 'desc'],
                ['created_at', 'asc'],
                ['progress.currentLevel.level_number', 'desc'],
            ])->values();

            $topModels = $sortedModels->take(5);

            
            $userRankIndex = $sortedModels->search(function ($model) use ($user) {
                return $model->id === $user->id;
            });
            $userRank = $userRankIndex !== false ? $userRankIndex + 1 : 999;

            
            $unlockedBenefits = $user->getModelBenefits();
            $nextBenefit = $user->getNextModelBenefit();

            
            
            $xpFromTipsToday = $user->tipsReceived()
                ->where('status', 'completed')
                ->whereDate('created_at', now())
                ->sum('amount');

            $xpEarnedToday = $xpFromTipsToday; 

            $missionsCompleted = $user->getCompletedMissionsCount();
            
            $totalMissions = $user->missions()->count();
        } else {
            
            $userProgress = null;
            $currentLevel = null;
            $nextLevel = null;
            $currentXP = 0;
            $requiredXP = 100;
            $xpPercentage = 0;
            $activeMissions = collect();
            $userRank = 999;
            $topModels = collect();
            $unlockedBenefits = collect();
            $nextBenefit = null;
            $xpEarnedToday = 0;
            $missionsCompleted = 0;
            $totalMissions = 0;
        }

        return view('model.dashboard', compact(
            'stats',
            'profile',
            'userProgress',
            'currentLevel',
            'nextLevel',
            'currentXP',
            'requiredXP',
            'xpPercentage',
            'activeMissions',
            'userRank',
            'topModels',
            'unlockedBenefits',
            'nextBenefit',
            'xpEarnedToday',
            'missionsCompleted',
            'totalMissions'
        ));
    }
}
