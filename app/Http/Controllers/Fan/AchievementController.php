<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $userProgress = $user->progress;
        $currentLevel = ($userProgress && $userProgress->currentLevel) ? $userProgress->currentLevel->level_number : 0;
        
        
        
        $achievements = collect([
            [
                'id'          => 1,
                'name'        => __('admin.flash.achievements.first_tip_name'),
                'description' => __('admin.flash.achievements.first_tip_desc'),
                'icon'        => 'fa-heart',
                'category'    => 'tips',
                'unlocked'    => $user->tipsSent()->count() > 0,
                'progress'    => min($user->tipsSent()->count(), 1),
                'target'      => 1,
                'rarity'      => 'common'
            ],
            [
                'id'          => 2,
                'name'        => __('admin.flash.achievements.generous_name'),
                'description' => __('admin.flash.achievements.generous_desc'),
                'icon'        => 'fa-coins',
                'category'    => 'tips',
                'unlocked'    => $user->tipsSent()->count() >= 100,
                'progress'    => min($user->tipsSent()->count(), 100),
                'target'      => 100,
                'rarity'      => 'rare'
            ],
            [
                'id'          => 3,
                'name'        => __('admin.flash.achievements.vip_subscriber_name'),
                'description' => __('admin.flash.achievements.vip_subscriber_desc'),
                'icon'        => 'fa-crown',
                'category'    => 'subscriptions',
                'unlocked'    => $user->subscriptionsAsFan()->where('status', 'active')->count() >= 5,
                'progress'    => min($user->subscriptionsAsFan()->where('status', 'active')->count(), 5),
                'target'      => 5,
                'rarity'      => 'epic'
            ],
            [
                'id'          => 4,
                'name'        => __('admin.flash.achievements.climber_name'),
                'description' => __('admin.flash.achievements.climber_desc'),
                'icon'        => 'fa-mountain',
                'category'    => 'levels',
                'unlocked'    => $currentLevel >= 10,
                'progress'    => min($currentLevel, 10),
                'target'      => 10,
                'rarity'      => 'rare'
            ],
            [
                'id'          => 5,
                'name'        => __('admin.flash.achievements.legend_name'),
                'description' => __('admin.flash.achievements.legend_desc'),
                'icon'        => 'fa-trophy',
                'category'    => 'levels',
                'unlocked'    => $currentLevel >= 21,
                'progress'    => min($currentLevel, 21),
                'target'      => 21,
                'rarity'      => 'legendary'
            ],
        ]);
        
        
        $stats = [
            'total' => $achievements->count(),
            'unlocked' => $achievements->where('unlocked', true)->count(),
            'completion_percentage' => round(($achievements->where('unlocked', true)->count() / $achievements->count()) * 100),
        ];
        
        return view('fan.achievements.index', compact('user', 'achievements', 'stats'));
    }
}
