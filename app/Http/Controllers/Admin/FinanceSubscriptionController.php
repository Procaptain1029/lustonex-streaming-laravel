<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class FinanceSubscriptionController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Subscription::with(['fan', 'model']);
        
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('search')) {
            $query->whereHas('fan', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('model', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $subscriptions = $query->latest()->paginate(20);
        
        
        $stats = [
            'total' => Subscription::count(),
            'active' => Subscription::where('status', 'active')->count(),
            'cancelled' => Subscription::where('status', 'cancelled')->count(),
            'expired' => Subscription::where('status', 'expired')->count(),
            'total_tokens' => Subscription::sum('amount'),
            'active_tokens' => Subscription::where('status', 'active')->sum('amount'),
            'monthly_tokens' => Subscription::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
        ];
        
        return view('admin.finance.subscriptions', compact('subscriptions', 'stats'));
    }
}
