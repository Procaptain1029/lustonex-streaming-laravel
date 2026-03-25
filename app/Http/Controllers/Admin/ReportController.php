<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Report::with(['reporter', 'reported', 'reportable']);
        
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        
        if ($request->filled('type')) {
            $query->where('reportable_type', $request->type);
        }
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('reporter', function($subQ) use ($request) {
                    $subQ->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('reported', function($subQ) use ($request) {
                    $subQ->where('name', 'like', '%' . $request->search . '%');
                });
            });
        }
        
        $reports = $query->latest()->paginate(20);
        
        
        $stats = [
            'total' => Report::count(),
            'pending' => Report::where('status', 'pending')->count(),
            'resolved' => Report::where('status', 'resolved')->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
        ];
        
        return view('admin.reports.index', compact('reports', 'stats'));
    }
    
    
    public function resolve(Report $report)
    {
        $report->update([
            'status' => 'resolved',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);
        
        return back()->with('success', __('admin.flash.reports.resolved'));
    }
    
    
    public function dismiss(Report $report)
    {
        $report->update([
            'status' => 'dismissed',
            'resolved_at' => now(),
            'resolved_by' => auth()->id(),
        ]);
        
        return back()->with('success', __('admin.flash.reports.dismissed'));
    }
}
