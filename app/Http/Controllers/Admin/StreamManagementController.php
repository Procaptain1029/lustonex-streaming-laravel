<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use Illuminate\Http\Request;

class StreamManagementController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Stream::with(['user.profile']);
        
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        
        if ($request->filled('model_id')) {
            $query->where('user_id', $request->model_id);
        }
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        $streams = $query->latest()->paginate(20);
        
        
        $stats = [
            'total' => Stream::count(),
            'active' => Stream::where('status', 'live')->count(),
            'ended' => Stream::where('status', 'ended')->count(),
            'total_viewers' => Stream::where('status', 'live')->sum('viewers_count'),
            'total_duration' => 0, 
        ];
        
        
        $models = \App\Models\User::where('role', 'model')
                                  ->with('profile')
                                  ->get();
        
        return view('admin.streams.index', compact('streams', 'stats', 'models'));
    }

    
    public function moderate()
    {
        $activeStreams = Stream::whereIn('status', ['live', 'paused'])
            ->with(['user.profile'])
            ->latest()
            ->get();

        return view('admin.streams.moderate', compact('activeStreams'));
    }
    
    
    public function end(Stream $stream)
    {
        if ($stream->status === 'live') {
            $stream->update([
                'status' => 'ended',
                'ended_at' => now(),
            ]);
            
            return back()->with('success', __('admin.flash.streams.ended'));
        }
        
        return back()->with('error', __('admin.flash.streams.not_active'));
    }
}
