<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user']);
        
        
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        
        
        if ($request->filled('action')) {
            $query->where('action', $request->action);
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
        
        $logs = $query->latest()->paginate(30);
        
        
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'this_week' => ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
        
        
        $actionTypes = ActivityLog::distinct()->pluck('action')->filter()->sort()->values();
        
        
        $users = User::select('id', 'name', 'email')->get();
        
        return view('admin.logs.index', compact('logs', 'stats', 'actionTypes', 'users'));
    }
}
