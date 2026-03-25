<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Tip;
use App\Models\TokenTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    
    public function index(Request $request)
    {
        $tokenValue = \App\Models\Setting::get('token_usd_rate', 0.10);
        
        // ── Income: Token purchases (real USD entering the platform) ──
        $tokensSold = TokenTransaction::where('type', 'purchase')->sum('amount');
        $totalIncomeUsd = $tokensSold * $tokenValue;
        
        $thisMonthTokensSold = TokenTransaction::where('type', 'purchase')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');
        $thisMonthIncomeUsd = $thisMonthTokensSold * $tokenValue;
        
        $todayTokensSold = TokenTransaction::where('type', 'purchase')
            ->whereDate('created_at', today())
            ->sum('amount');
        $todayIncomeUsd = $todayTokensSold * $tokenValue;
        
        // ── Expenses: Withdrawals paid to models ──
        $totalPayoutsTokens = Withdrawal::where('status', 'completed')->sum('net_amount');
        $totalPayoutsUsd = $totalPayoutsTokens * $tokenValue;
        
        $thisMonthPayoutsTokens = Withdrawal::where('status', 'completed')
            ->whereMonth('processed_at', now()->month)
            ->whereYear('processed_at', now()->year)
            ->sum('net_amount');
        $thisMonthPayoutsUsd = $thisMonthPayoutsTokens * $tokenValue;
        
        // ── Net profit ──
        $netProfitUsd = $totalIncomeUsd - $totalPayoutsUsd;
        $thisMonthNetUsd = $thisMonthIncomeUsd - $thisMonthPayoutsUsd;
        
        // ── Token circulation ──
        $tokensInCirculation = DB::table('users')->sum('tokens');
        $circulationValueUsd = $tokensInCirculation * $tokenValue;
        
        // ── Operational stats ──
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
        $pendingWithdrawalsAmount = Withdrawal::where('status', 'pending')->sum('amount');
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $totalTips = Tip::where('status', 'completed')->count();
        
        // ── Recent activity ──
        $recentTips = Tip::with(['sender', 'receiver'])
            ->latest()
            ->take(8)
            ->get();
        
        $recentSubscriptions = Subscription::with(['fan', 'model'])
            ->latest()
            ->take(8)
            ->get();
        
        $recentWithdrawals = Withdrawal::with(['user'])
            ->where('status', 'completed')
            ->latest('processed_at')
            ->take(5)
            ->get();
        
        $stats = [
            // Balance general
            'tokens_sold' => $tokensSold,
            'total_income_usd' => $totalIncomeUsd,
            'total_payouts_usd' => $totalPayoutsUsd,
            'net_profit_usd' => $netProfitUsd,
            // This month
            'this_month_income_usd' => $thisMonthIncomeUsd,
            'this_month_payouts_usd' => $thisMonthPayoutsUsd,
            'this_month_net_usd' => $thisMonthNetUsd,
            'today_income_usd' => $todayIncomeUsd,
            // Circulation
            'tokens_in_circulation' => $tokensInCirculation,
            'circulation_value_usd' => $circulationValueUsd,
            // Operations
            'pending_withdrawals' => $pendingWithdrawals,
            'pending_withdrawals_amount' => $pendingWithdrawalsAmount,
            'active_subscriptions' => $activeSubscriptions,
            'total_tips' => $totalTips,
            // Config
            'token_value' => $tokenValue,
        ];
        
        return view('admin.finance.index', compact(
            'stats',
            'recentTips',
            'recentSubscriptions',
            'recentWithdrawals'
        ));
    }
}
