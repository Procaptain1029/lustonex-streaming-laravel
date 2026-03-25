<?php

namespace App\Http\Controllers\Fan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return redirect()->route('home')->with('error', __('admin.flash.fan.access_denied'));
        }
        
        
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);
        
        
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
        ];
        
        return view('fan.notifications.index', compact('user', 'notifications', 'stats'));
    }
    
    
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        try {
            $notification = $user->notifications()->findOrFail($id);
            $notification->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => __('admin.flash.fan.notification_read')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.notification_read_error')
            ], 500);
        }
    }
    
    
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->isFan()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.fan.access_denied')], 403);
        }
        
        try {
            $user->unreadNotifications->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => __('admin.flash.fan.notifications_all_read')
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.fan.notifications_read_error')
            ], 500);
        }
    }
}
