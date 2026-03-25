<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();

        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }

        
        $userProgress = $user->progress;
        $currentLevel = $userProgress ? $userProgress->currentLevel : null;

        
        if ($currentLevel) {
            $nextLevel = \App\Models\Level::where('level_number', $currentLevel->level_number + 1)->first();
        } else {
            $nextLevel = \App\Models\Level::orderBy('level_number', 'asc')->first();
        }

        
        $currentXP = $userProgress ? $userProgress->current_xp : 0;
        $requiredXP = $nextLevel ? $nextLevel->xp_required : ($currentLevel ? $currentLevel->xp_required : 0);

        
        
        $xpPercentage = $user->getXPPercentage();

        
        $allActiveMissions = $user->getActiveMissions();
        $obligatoryMission = $allActiveMissions->where('type', 'LEVEL_UP')->first();
        if ($obligatoryMission) {
            
            $obligatoryMission['next_level'] = ($currentLevel ? $currentLevel->level_number : 0) + 1;
            
            $obligatoryMission = (object) $obligatoryMission;
        }

        $weeklyMissions = $allActiveMissions->where('type', 'WEEKLY')->take(3)->values()->map(function ($m) {
            return (object) $m;
        });

        
        $activeSubscriptions = $user->subscriptionsAsFan()->where('status', 'active')->count();
        $totalTipsSent = $user->tipsSent()->count();
        $tipsThisWeek = $user->tipsSent()->where('created_at', '>=', now()->subWeek())->count();
        $ticketsBalance = $userProgress ? $userProgress->tickets_balance : 0;

        $stats = [
            'tokens' => $user->tokens ?? 0,
            'subscriptions_count' => $activeSubscriptions,
            'tips_sent' => $totalTipsSent,
            'tips_this_week' => $tipsThisWeek,
            'tickets_balance' => $ticketsBalance,
        ];

        
        $favorites = $user->favorites()
            ->with(['profile'])
            ->get();

        
        // Actividad Reciente unificada desde TokenTransaction
        $recentActivity = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get()
            ->map(function($t) {
                return (object) [
                    'id' => $t->id,
                    'type' => $t->type === 'purchase' ? 'recharge' : 'spent',
                    'main_line' => $t->description,
                    'amount' => ($t->type === 'spent' ? '-' : '+') . number_format($t->amount) . ' Tk',
                    'created_at' => $t->created_at,
                    'amount_class' => $t->type === 'spent' ? 'amount-negative' : 'amount-positive'
                ];
            });

        $recentSubscriptions = $user->subscriptionsAsFan()
            ->with(['model.profile'])
            ->latest()
            ->take(3)
            ->get();

        // Active Missions
        $activeMissions = $user->getActiveMissions()->take(3);

        // Benefits logic
        $levelNumber = $currentLevel ? $currentLevel->level_number : 0;
        $unlockedBenefits = $this->getUnlockedBenefits($levelNumber);
        $nextBenefit = $this->getNextBenefit($levelNumber);

        return view('fan.dashboard', compact(
            'user',
            'stats',
            'userProgress',
            'currentLevel',
            'nextLevel',
            'xpPercentage',
            'currentXP',
            'requiredXP',
            'activeMissions',
            'obligatoryMission',
            'weeklyMissions',
            'favorites',
            'recentActivity', // Usar esta variable en lugar de recentTips
            'recentSubscriptions',
            'unlockedBenefits',
            'nextBenefit'
        ));
    }

    
    private function getUnlockedBenefits($levelNumber)
    {
        $benefits = [];

        if ($levelNumber >= 1) {
            $benefits[] = ['icon' => 'fa-comments', 'name' => __('admin.flash.benefits.chat')];
        }
        if ($levelNumber >= 6) {
            $benefits[] = ['icon' => 'fa-percent', 'name' => __('admin.flash.benefits.cashback_5')];
        }
        if ($levelNumber >= 11) {
            $benefits[] = ['icon' => 'fa-user-secret', 'name' => __('admin.flash.benefits.invisible')];
        }
        if ($levelNumber >= 16) {
            $benefits[] = ['icon' => 'fa-crown', 'name' => __('admin.flash.benefits.vip')];
        }
        if ($levelNumber >= 21) {
            $benefits[] = ['icon' => 'fa-star', 'name' => __('admin.flash.benefits.elite')];
        }

        return $benefits;
    }

    
    private function getNextBenefit($levelNumber)
    {
        if ($levelNumber < 1) {
            return ['level' => 1,  'name' => __('admin.flash.benefits.chat')];
        }
        if ($levelNumber < 6) {
            return ['level' => 6,  'name' => __('admin.flash.benefits.cashback_5')];
        }
        if ($levelNumber < 11) {
            return ['level' => 11, 'name' => __('admin.flash.benefits.invisible')];
        }
        if ($levelNumber < 16) {
            return ['level' => 16, 'name' => __('admin.flash.benefits.vip')];
        }
        if ($levelNumber < 21) {
            return ['level' => 21, 'name' => __('admin.flash.benefits.elite')];
        }

        return null; 
    }
}
