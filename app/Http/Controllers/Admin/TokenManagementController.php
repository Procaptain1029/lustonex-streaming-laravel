<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TokenTransaction;
use App\Models\User;
use Illuminate\Http\Request;

class TokenManagementController extends Controller
{
    
    public function index(Request $request)
    {
        $query = TokenTransaction::with(['user']);
        
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        $transactions = $query->latest()->paginate(20);
        
        
        $stats = [
            'total_transactions' => TokenTransaction::count(),
            'total_purchased' => TokenTransaction::where('type', 'purchase')->sum('amount'),
            'total_spent' => TokenTransaction::where('type', 'spent')->sum('amount'),
            'total_earned' => TokenTransaction::where('type', 'earned')->sum('amount'),
            'active_users' => User::where('tokens', '>', 0)->count(),
        ];
        
        
        $topUsers = User::orderBy('tokens', 'desc')
                       ->take(10)
                       ->get();
        
        
        $users = User::select('id', 'name', 'email')->get();
        
        return view('admin.tokens.index', compact('transactions', 'stats', 'topUsers', 'users'));
    }
}
