<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;

class DashboardControllerSimple extends Controller
{
    public function index()
    {
        return view('model.dashboard', [
            'stats' => [
                'total_subscribers' => 0,
                'total_tips' => 0,
                'total_photos' => 0,
                'total_videos' => 0,
                'total_streams' => 0,
                'recent_tips' => collect([]),
                'recent_subscribers' => collect([]),
            ]
        ]);
    }
}
