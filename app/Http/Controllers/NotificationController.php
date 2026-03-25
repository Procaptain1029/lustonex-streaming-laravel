<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        $unreadCount = $this->notificationService->getUnreadCount(auth()->user());

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    
    public function markAsRead($id)
    {
        $this->notificationService->markAsRead(auth()->user(), $id);

        return response()->json(['success' => true]);
    }

    
    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(auth()->user());

        return redirect()->back()->with('success', __('admin.flash.notification.all_read'));
    }

    
    public function destroy($id)
    {
        $this->notificationService->deleteNotification(auth()->user(), $id);

        return response()->json(['success' => true]);
    }

    
    public function destroyAll()
    {
        $this->notificationService->deleteAllNotifications(auth()->user());

        return redirect()->back()->with('success', __('admin.flash.notification.all_deleted'));
    }

    
    public function unreadCount()
    {
        $count = $this->notificationService->getUnreadCount(auth()->user());

        return response()->json(['count' => $count]);
    }
}
