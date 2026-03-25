<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\ModelRank;
use App\Services\RankingService;
use Illuminate\Support\Facades\DB;

class UpdateRankings extends Command
{
    protected $signature = 'app:update-ranks';
    protected $description = 'Update model rankings for all periods (DAILY, WEEKLY, MONTHLY)';

    public function handle(RankingService $rankingService)
    {
        $this->info('Starting ranking update...');

        $periods = ['DAILY', 'WEEKLY', 'MONTHLY'];
        $models = User::where('role', 'model')
            ->whereHas('profile', function($q) {
                $q->where('verification_status', 'approved');
            })
            ->get();

        foreach ($periods as $period) {
            $this->info("Processing period: {$period}");
            $scores = [];

            foreach ($models as $model) {
                $score = $rankingService->calculateScore($model, $period);
                $scores[] = [
                    'user_id' => $model->id,
                    'score' => $score,
                    'period_type' => $period,
                    'period_date' => now()->toDateString(),
                ];
            }

            // Sort scores descending
            usort($scores, fn($a, $b) => $b['score'] <=> $a['score']);

            DB::beginTransaction();
            try {
                // Clear existing ranks for today/period or update
                // For simplicity in this logic, we update or create
                foreach ($scores as $index => $data) {
                    ModelRank::updateOrCreate(
                        [
                            'user_id' => $data['user_id'],
                            'period_type' => $data['period_type'],
                            // We keep only the latest rank per period type for exposure
                            // If history is needed, include period_date in the unique key
                        ],
                        [
                            'score' => $data['score'],
                            'rank_position' => $index + 1,
                            'period_date' => $data['period_date'],
                        ]
                    );
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Error updating {$period} ranks: " . $e->getMessage());
            }
        }

        $this->info('Ranking update completed successfully!');
    }
}
