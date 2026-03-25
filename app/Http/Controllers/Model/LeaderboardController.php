<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\RankingService;

class LeaderboardController extends Controller
{
    protected $rankingService;

    public function __construct(RankingService $rankingService)
    {
        $this->rankingService = $rankingService;
    }

    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;

        
        if (!$profile || !$profile->isApproved()) {
            return redirect()->route('model.dashboard')
                ->with('error', __('admin.flash.model.leaderboard_required'));
        }

        
        $models = User::where('role', 'model')
            ->whereHas('progress')
            ->whereHas('profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->with(['progress.currentLevel', 'profile'])
            ->get();

        
        $modelsWithScore = $models->map(function ($model) use ($user) {
            $erank = $this->rankingService->calculateScore($model, 'WEEKLY');
            $currentLevel = $model->progress->currentLevel ?? null;

            return [
                'id' => $model->id,
                'name' => $model->name,
                'avatar' => $model->profile->avatar_url ?? '/images/default-avatar.png',
                'level' => $currentLevel ? $currentLevel->level_number : 0,
                'erank' => $erank,
                'created_at' => $model->created_at,
                'is_current_user' => $model->id === $user->id,
            ];
        });

        
        $topModels = $modelsWithScore->sortBy([
            ['erank', 'desc'],
            ['created_at', 'asc'],
            ['level', 'desc'],
        ])->values()->take(50)->map(function ($model, $index) {
            $model['rank'] = $index + 1;
            return $model;
        });

        
        $userRank = $topModels->search(function ($model) use ($user) {
            return $model['id'] === $user->id;
        });
        $userRank = $userRank !== false ? $userRank + 1 : 999;

        $userErank = $this->rankingService->calculateScore($user, 'WEEKLY');

        
        $totalModels = User::where('role', 'model')
            ->whereHas('profile', function ($query) {
                $query->where('verification_status', 'approved');
            })
            ->count();

        $topPercentage = $totalModels > 0 ? round(($userRank / $totalModels) * 100, 1) : 0;

        $stats = [
            'your_rank' => $userRank,
            'your_erank' => $userErank,
            'total_models' => $totalModels,
            'top_percentage' => $topPercentage,
        ];

        return view('model.leaderboard.index', compact('stats', 'topModels'));
    }
}
