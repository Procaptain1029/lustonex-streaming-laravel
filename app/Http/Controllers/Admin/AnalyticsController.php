<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Stream;
use App\Models\Subscription;
use App\Models\Tip;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    
    public function index(Request $request)
    {
        
        $userGrowth = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $userGrowth[] = [
                'date' => $date->format('M d'),
                'fans' => User::where('role', 'fan')->whereDate('created_at', $date)->count(),
                'models' => User::where('role', 'model')->whereDate('created_at', $date)->count(),
            ];
        }
        
        
        $revenueTrends = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $tips = Tip::where('status', 'completed')
                      ->whereYear('created_at', $month->year)
                      ->whereMonth('created_at', $month->month)
                      ->sum('amount');
            $subs = Subscription::where('status', 'active')
                               ->whereYear('created_at', $month->year)
                               ->whereMonth('created_at', $month->month)
                               ->sum('amount');
            
            $revenueTrends[] = [
                'month' => $month->format('M Y'),
                'revenue' => $tips + $subs
            ];
        }
        
        
        $contentStats = [
            'total_photos' => Photo::count(),
            'total_videos' => Video::count(),
            'total_streams' => Stream::count(),
            'pending_photos' => Photo::where('status', 'pending')->count(),
            'pending_videos' => Video::where('status', 'pending')->count(),
        ];
        
        
        
        $avgDuration = Stream::where('status', 'ended')
            ->whereNotNull('started_at')
            ->whereNotNull('ended_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, started_at, ended_at)) as avg_duration')
            ->value('avg_duration') ?? 0;
            
        $engagementMetrics = [
            'avg_stream_duration' => $avgDuration,
            'avg_viewers' => Stream::where('status', 'live')->avg('viewers_count') ?? 0,
            'total_tips' => Tip::where('status', 'completed')->count(),
            'total_subscriptions' => Subscription::where('status', 'active')->count(),
        ];
        
        
        $topModels = User::where('role', 'model')
                        ->with('profile')
                        ->orderBy('tokens', 'desc')
                        ->take(10)
                        ->get();
        
        // Dynamic growth calculations (this month vs last month)
        $thisMonthStart = now()->startOfMonth();
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();
        
        $usersThisMonth = User::where('created_at', '>=', $thisMonthStart)->count();
        $usersLastMonth = User::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $usersGrowth = $usersLastMonth > 0 ? round((($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100, 1) : 0;
        
        $fansThisMonth = User::where('role', 'fan')->where('created_at', '>=', $thisMonthStart)->count();
        $fansLastMonth = User::where('role', 'fan')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $fansGrowth = $fansLastMonth > 0 ? round((($fansThisMonth - $fansLastMonth) / $fansLastMonth) * 100, 1) : 0;
        
        $modelsThisMonth = User::where('role', 'model')->where('created_at', '>=', $thisMonthStart)->count();
        $modelsLastMonth = User::where('role', 'model')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $modelsGrowth = $modelsLastMonth > 0 ? round((($modelsThisMonth - $modelsLastMonth) / $modelsLastMonth) * 100, 1) : 0;
        
        $tokensThisMonth = Tip::where('status', 'completed')->where('created_at', '>=', $thisMonthStart)->sum('amount') +
                           Subscription::where('status', 'active')->where('created_at', '>=', $thisMonthStart)->sum('amount');
        $tokensLastMonth = Tip::where('status', 'completed')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('amount') +
                           Subscription::where('status', 'active')->whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('amount');
        $tokensGrowth = $tokensLastMonth > 0 ? round((($tokensThisMonth - $tokensLastMonth) / $tokensLastMonth) * 100, 1) : 0;
        
        $overview = [
            'total_users' => User::count(),
            'total_fans' => User::where('role', 'fan')->count(),
            'total_models' => User::where('role', 'model')->count(),
            'total_tokens' => Tip::where('status', 'completed')->sum('amount') + 
                              Subscription::where('status', 'active')->sum('amount'),
            'active_streams' => Stream::where('status', 'live')->count(),
            // Growth percentages
            'users_growth' => $usersGrowth,
            'fans_growth' => $fansGrowth,
            'models_growth' => $modelsGrowth,
            'tokens_growth' => $tokensGrowth,
        ];
        
        return view('admin.analytics.index', compact(
            'userGrowth',
            'revenueTrends',
            'contentStats',
            'engagementMetrics',
            'topModels',
            'overview'
        ));
    }
}
