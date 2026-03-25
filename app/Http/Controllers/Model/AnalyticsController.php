<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\ProfileView;
use App\Models\Tip;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        
        if (!$profile || !$profile->isApproved()) {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.model.analytics_required'));
        }
        
        $profileId = $profile->id;
        
        
        $profileViews = [
            'total' => ProfileView::getTotalViewsCount($profileId),
            'last_30_days' => ProfileView::getTotalViewsCount($profileId, 30),
            'last_7_days' => ProfileView::getTotalViewsCount($profileId, 7),
            'today' => ProfileView::where('profile_id', $profileId)
                ->whereDate('viewed_at', today())
                ->count(),
            'chart_data' => $this->generateRealViewsChartData($profileId),
        ];
        
        
        $popularPhotos = $user->photos()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get()
            ->map(function($photo) {
                return [
                    'id' => $photo->id,
                    'thumbnail' => $photo->thumbnail ?? $photo->url,
                    'views' => $photo->views ?? 0, 
                    'likes' => 0, 
                ];
            });
            
        $popularVideos = $user->videos()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get()
            ->map(function($video) {
                return [
                    'id' => $video->id,
                    'thumbnail' => $video->thumbnail ?? '/images/video-placeholder.jpg',
                    'views' => $video->views ?? 0, 
                    'likes' => 0, 
                ];
            });
        
        
        $peakHours = $this->getPeakHours($profileId);
        
        
        $demographics = [
            'countries' => $this->getTopCountries($profileId),
            'top_fans' => $this->getTopFans($user),
        ];
        
        
        $currentSubscribers = $user->subscriptionsAsModel()->where('status', 'active')->count();
        $lastMonthSubscribers = $user->subscriptionsAsModel()
            ->where('status', 'active')
            ->where('created_at', '<', now()->subMonth())
            ->count();
        
        $currentEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->sum('amount');
        $lastMonthEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->where('created_at', '<', now()->subMonth())
            ->sum('amount');
        
        $currentContent = $user->photos()->count() + $user->videos()->count();
        $lastMonthContent = $user->photos()->where('created_at', '<', now()->subMonth())->count() + 
                           $user->videos()->where('created_at', '<', now()->subMonth())->count();
        
        $growthTrends = [
            'subscribers' => [
                'current' => $currentSubscribers,
                'last_month' => $lastMonthSubscribers,
                'growth_percentage' => $lastMonthSubscribers > 0 
                    ? round((($currentSubscribers - $lastMonthSubscribers) / $lastMonthSubscribers) * 100, 1)
                    : 0,
            ],
            'earnings' => [
                'current' => $currentEarnings,
                'last_month' => $lastMonthEarnings,
                'growth_percentage' => $lastMonthEarnings > 0 
                    ? round((($currentEarnings - $lastMonthEarnings) / $lastMonthEarnings) * 100, 1)
                    : 0,
            ],
            'content' => [
                'current' => $currentContent,
                'last_month' => $lastMonthContent,
                'growth_percentage' => $lastMonthContent > 0 
                    ? round((($currentContent - $lastMonthContent) / $lastMonthContent) * 100, 1)
                    : 0,
            ],
        ];
        
        
        $userProgress = UserProgress::where('user_id', $user->id)->first();
        $xpByPeriod = [
            'today' => $this->getXPForPeriod($user->id, 'today'),
            'this_week' => $this->getXPForPeriod($user->id, 'week'),
            'this_month' => $this->getXPForPeriod($user->id, 'month'),
        ];
        
        return view('model.analytics.index', compact(
            'profileViews',
            'popularPhotos',
            'popularVideos',
            'peakHours',
            'demographics',
            'growthTrends',
            'xpByPeriod'
        ));
    }
    
    
    private function generateRealViewsChartData($profileId)
    {
        $data = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'views' => ProfileView::where('profile_id', $profileId)
                    ->whereDate('viewed_at', $date)
                    ->count(),
            ];
        }
        return $data;
    }
    
    
    private function getPeakHours($profileId)
    {
        $hourlyData = ProfileView::where('profile_id', $profileId)
            ->where('viewed_at', '>=', now()->subDays(30))
            ->select(DB::raw('HOUR(viewed_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get();
        
        
        $peakHours = [];
        for ($h = 0; $h < 24; $h += 3) {
            $hourData = $hourlyData->firstWhere('hour', $h);
            $peakHours[] = [
                'hour' => sprintf('%02d:00', $h),
                'activity' => $hourData ? $hourData->count : 0,
            ];
        }
        
        return $peakHours;
    }
    
    
    private function getTopCountries($profileId)
    {
        
        
        return [
            ['name' => 'No disponible', 'percentage' => 100, 'flag' => null],
        ];
    }
    
    
    private function getTopFans($user)
    {
        // En lugar de usar Tip::where('model_id', $user->id), necesitamos ver quién envía el dinero. 
        // Como TokenTransaction de tipo 'earned' no tiene el fan guardado de forma relacional fácil,
        // (tiene el user_id de la modelo, pero no de quién vino)
        // se puede mantener la consulta de top fans a las interacciones explícitas de TokenTransactions.
        // Dado el esquema, Tips son la mejor forma de saber los "Top Fans". Mantendremos Tips para top fans,
        // pero podemos mejorarla si hay una forma directa. Para este proyecto, sumamos Tips y Suscripciones.
        
        $tipsFans = Tip::where('model_id', $user->id)
            ->where('status', 'completed')
            ->select('fan_id', DB::raw('SUM(amount) as total_tips'), DB::raw('COUNT(*) as interactions'))
            ->groupBy('fan_id')
            ->get();
            
        return $tipsFans->sortByDesc('total_tips')
            ->take(10)
            ->values()
            ->map(function($tip) {
                // Para mantener compatibilidad si no hay relación fan pre-cargada
                $fan = \App\Models\User::find($tip->fan_id);
                return [
                    'name'         => $fan->name ?? __('admin.flash.model.default_fan_name'),
                    'avatar' => ($fan && $fan->profile) ? $fan->profile->avatar_url : '/images/default-avatar.png',
                    'total_tips' => $tip->total_tips,
                    'interactions' => $tip->interactions,
                ];
            });
    }
    
    
    private function getXPForPeriod($userId, $period)
    {
        
        
        return 0;
    }

    public function export()
    {
        $user = auth()->user();
        $profile = $user->profile;

        if (!$profile) {
            return back()->with('error', 'No profile found.');
        }

        $profileId = $profile->id;
        $data = $this->generateRealViewsChartData($profileId);
        
        $filename = "analytics_" . date('Ymd') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Fecha', 'Visitas'];

        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $row) {
                fputcsv($file, [$row['date'], $row['views']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
