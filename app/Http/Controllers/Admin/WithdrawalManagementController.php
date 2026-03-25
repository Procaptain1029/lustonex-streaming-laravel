<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class WithdrawalManagementController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    
    public function index(Request $request)
    {
        $query = Withdrawal::with(['user', 'processor']);
        
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $withdrawals = $query->latest()->paginate(20);
        
        
        $stats = [
            'pending' => Withdrawal::where('status', 'pending')->count(),
            'pending_amount' => Withdrawal::where('status', 'pending')->sum('amount'),
            'completed_today' => Withdrawal::where('status', 'completed')
                                          ->whereDate('processed_at', today())
                                          ->count(),
            'total_processed' => Withdrawal::where('status', 'completed')->sum('amount'),
        ];
        
        return view('admin.withdrawals.index', compact('withdrawals', 'stats'));
    }

    
    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['user.profile', 'processor']);
        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    
    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', __('admin.flash.withdrawals.only_pending_approve'));
        }
        
        $withdrawal->approve(auth()->id());
        
        
        $this->notificationService->notifyWithdrawalProcessed($withdrawal->user, $withdrawal, true);
        
        
        
        
        return back()->with('success', __('admin.flash.withdrawals.approved'));
    }

    
    public function reject(Request $request, Withdrawal $withdrawal)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', __('admin.flash.withdrawals.only_pending_reject'));
        }
        
        $withdrawal->reject(auth()->id(), $validated['rejection_reason']);
        
        
        $this->notificationService->notifyWithdrawalProcessed($withdrawal->user, $withdrawal, false);
        
        return back()->with('success', __('admin.flash.withdrawals.rejected'));
    }
}
