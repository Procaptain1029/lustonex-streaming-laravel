<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications for the model.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user->isModel()) {
            return redirect()->route('home')->with('error', __('admin.flash.model.access_denied'));
        }

        // Get notifications paginated
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(10);

        // Calculate stats for the view
        $stats = [
            'total' => $user->notifications()->count(),
            'unread' => $user->unreadNotifications()->count(),
            'today' => $user->notifications()->whereDate('created_at', today())->count(),
        ];

        return view('model.notifications.index', compact('user', 'notifications', 'stats'));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->isModel()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.access_denied')], 403);
        }

        try {
            $notification = $user->notifications()->findOrFail($id);
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => __('admin.flash.model.notification_read')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.model.notification_read_error')
            ], 500);
        }
    }

    /**
     * Mark all notifications as read.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();

        if (!$user->isModel()) {
            return response()->json(['success' => false, 'message' => __('admin.flash.model.access_denied')], 403);
        }

        try {
            $user->unreadNotifications->markAsRead();

            return response()->json([
                'success' => true,
                'message' => __('admin.flash.model.notifications_all_read')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.model.notifications_read_error')
            ], 500);
        }
    }
}
