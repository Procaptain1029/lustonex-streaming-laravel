<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageModerationController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Message::with(['sender', 'receiver']);
        
        
        if ($request->filled('flagged')) {
            $query->where('is_flagged', $request->flagged === '1');
        }
        
        
        if ($request->filled('user_id')) {
            $query->where(function($q) use ($request) {
                $q->where('sender_id', $request->user_id)
                  ->orWhere('receiver_id', $request->user_id);
            });
        }
        
        
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        
        if ($request->filled('search')) {
            $query->where('content', 'like', '%' . $request->search . '%');
        }
        
        $messages = $query->latest()->paginate(20);
        
        
        $stats = [
            'total' => Message::count(),
            'flagged' => Message::where('is_flagged', true)->count(),
            'today' => Message::whereDate('created_at', today())->count(),
        ];
        
        
        $users = User::select('id', 'name', 'email')->get();
        
        return view('admin.messages.index', compact('messages', 'stats', 'users'));
    }
    
    
    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success', __('admin.flash.messages.deleted'));
    }
    
    
    public function toggleFlag(Message $message)
    {
        $message->update(['is_flagged' => !$message->is_flagged]);
        return back()->with('success', __('admin.flash.messages.flag_updated'));
    }
}
