<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Stream;
use App\Models\Photo;
use App\Models\Video;
use App\Models\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_models' => User::where('role', 'model')->count(),
            'total_fans' => User::where('role', 'fan')->count(),
            'active_streams' => Stream::where('status', 'live')->count(),
            'total_subscriptions' => Subscription::where('status', 'active')->count(),
            'pending_photos' => Photo::where('status', 'pending')->count(),
            'pending_videos' => Video::where('status', 'pending')->count(),
            'total_revenue' => Subscription::where('status', 'active')->sum('amount'),
        ];

        $recentStreams = Stream::with('user.profile')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStreams'));
    }
}
