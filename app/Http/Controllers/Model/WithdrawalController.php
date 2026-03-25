<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\TokenTransaction;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    
    public function index()
    {
        $withdrawals = auth()->user()->withdrawals()
                            ->latest()
                            ->paginate(20);
        
        $user = auth()->user();
        
        $stats = [
            'available_balance' => $user->tokens ?? 0, 
            'pending_balance' => $user->withdrawals()->where('status', 'pending')->sum('amount'),
            'total_withdrawn' => $user->withdrawals()
                                    ->where('status', 'completed')
                                    ->sum('amount'),
            'token_usd_rate' => \App\Models\Setting::get('token_usd_rate', 0.10), 
            'commission_rate' => $user->getCommissionRate(),
            'minimum_withdrawal' => config('app.min_withdrawal_amount', 50),
        ];
        
        return view('model.withdrawals.index', compact('withdrawals', 'stats'));
    }

    
    public function create()
    {
        $minWithdrawal = config('app.min_withdrawal_amount', 50);
        $availableBalance = auth()->user()->tokens;
        $tokenUsdRate = \App\Models\Setting::get('token_usd_rate', 0.10);
        
        return view('model.withdrawals.create', compact('minWithdrawal', 'availableBalance', 'tokenUsdRate'));
    }

    
    public function store(Request $request)
    {
        $user = auth()->user();
        $minWithdrawal = config('app.min_withdrawal_amount', 50);
        
        $validated = $request->validate([
            'amount' => "required|numeric|min:{$minWithdrawal}|max:{$user->tokens}",
            'payment_method' => 'required|in:bank_transfer,paypal,stripe,crypto',
            'payment_details' => 'required|array',
            'notes' => 'nullable|string|max:500',
        ]);
        
        
        $withdrawal = new Withdrawal($validated);
        $withdrawal->user_id = $user->id;
        $withdrawal->calculateFee();
        $withdrawal->save();
        
        
        $user->decrement('tokens', $validated['amount']);
        $user->increment('pending_balance', $validated['amount']);
        
        
        TokenTransaction::create([
            'user_id' => $user->id,
            'type' => 'withdrawal',
            'amount' => $validated['amount'],
            'description' => __('admin.flash.withdrawal.tx_description', ['method' => $validated['payment_method']]),
            'balance_after' => $user->fresh()->tokens,
        ]);
        
        return redirect()->route('model.withdrawals.index')
                        ->with('success', __('admin.flash.withdrawal.request_sent'));
    }

    
    public function cancel(Withdrawal $withdrawal)
    {
        if ($withdrawal->user_id !== auth()->id()) {
            abort(403);
        }
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', __('admin.flash.withdrawal.cancel_error'));
        }
        
        $withdrawal->update(['status' => 'cancelled']);
        
        
        $withdrawal->user->decrement('pending_balance', $withdrawal->amount);
        $withdrawal->user->increment('tokens', $withdrawal->amount);
        
        return back()->with('success', __('admin.flash.withdrawal.cancelled'));
    }

    public function export()
    {
        $withdrawals = auth()->user()->withdrawals()->latest()->get();
        $filename = "withdrawals_" . date('Ymd') . ".csv";
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Fecha', 'Monto', 'Método', 'Estado', 'Comisión', 'Neto'];

        $callback = function() use($withdrawals, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($withdrawals as $withdrawal) {
                $row['ID'] = $withdrawal->id;
                $row['Fecha'] = $withdrawal->created_at->format('d/m/Y H:i');
                $row['Monto'] = $withdrawal->amount;
                $row['Método'] = $withdrawal->payment_method;
                $row['Estado'] = $withdrawal->status;
                $row['Comisión'] = $withdrawal->fee;
                $row['Neto'] = $withdrawal->amount - $withdrawal->fee;

                fputcsv($file, [$row['ID'], $row['Fecha'], $row['Monto'], $row['Método'], $row['Estado'], $row['Comisión'], $row['Neto']]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
