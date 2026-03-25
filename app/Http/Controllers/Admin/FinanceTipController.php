<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tip;
use Illuminate\Http\Request;

class FinanceTipController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Tip::with(['sender', 'receiver']);
        
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }
        
        
        if ($request->filled('search')) {
            $query->whereHas('sender', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })->orWhereHas('receiver', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        $tips = $query->latest()->paginate(20);
        
        
        $stats = [
            'total' => Tip::count(),
            'completed' => Tip::where('status', 'completed')->count(),
            'pending' => Tip::where('status', 'pending')->count(),
            'failed' => Tip::where('status', 'failed')->count(),
            'total_tokens' => Tip::where('status', 'completed')->sum('amount'),
            'average_tokens' => Tip::where('status', 'completed')->avg('amount'),
            'monthly_tokens' => Tip::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
        ];
        
        return view('admin.finance.tips', compact('tips', 'stats'));
    }
}
