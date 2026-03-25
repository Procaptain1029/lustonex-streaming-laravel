<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;
        
        
        if (!$profile || !$profile->isApproved()) {
            return redirect()->route('model.dashboard')
                           ->with('error', __('admin.flash.model.earnings_required'));
        }
        
        
        $totalEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->sum('amount');
        
        
        $thisMonthEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        
        
        $thisWeekEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('amount');
        
        
        $stats = [
            'total_earnings' => $totalEarnings,
            'this_month' => $thisMonthEarnings,
            'this_week' => $thisWeekEarnings,
            'commission_rate' => $user->getCommissionRate(),
            'net_earnings' => $totalEarnings * (1 - $user->getCommissionRate() / 100),
        ];
        
        
        $tipEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->where('description', 'like', '%Propina%')
            ->sum('amount');
            
        $subscriptionEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->where('description', 'like', '%Suscripción%')
            ->sum('amount');
            
        $rouletteEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->where('description', 'like', '%Ruleta%')
            ->sum('amount');
            
        $otherEarnings = $totalEarnings - ($tipEarnings + $subscriptionEarnings + $rouletteEarnings);
        
        $breakdown = [
            'tips' => $tipEarnings,
            'subscriptions' => $subscriptionEarnings,
            'roulette' => $rouletteEarnings,
            'other' => $otherEarnings,
        ];
        
        
        $recentTransactions = \App\Models\TokenTransaction::where('user_id', $user->id)
            ->where('type', 'earned')
            ->latest()
            ->take(10)
            ->get()
            ->map(function($transaction) {
                
                $type = 'other';
                if (str_contains($transaction->description, 'Propina')) {
                    $type = 'tip';
                } elseif (str_contains($transaction->description, 'Suscripción')) {
                    $type = 'subscription';
                } elseif (str_contains($transaction->description, 'Ruleta')) {
                    $type = 'roulette';
                }
                
                return [
                    'type' => $type,
                    'amount' => $transaction->amount,
                    'from' => $transaction->description,
                    'date' => $transaction->created_at,
                ];
            })
            ->take(5);

        
        $dailyEarnings = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dayEarnings = \App\Models\TokenTransaction::where('user_id', $user->id)
                ->where('type', 'earned')
                ->whereDate('created_at', $date)
                ->sum('amount');
            
            $dailyEarnings[] = [
                'date' => $date->format('D'),
                'amount' => $dayEarnings
            ];
        }
        
        
        $xpFromEarnings = floor($totalEarnings / 10); 
        
        return view('model.earnings.index', compact(
            'stats',
            'breakdown',
            'recentTransactions',
            'xpFromEarnings',
            'dailyEarnings'
        ));
    }
}
