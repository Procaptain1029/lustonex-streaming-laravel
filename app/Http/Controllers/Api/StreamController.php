<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use Illuminate\Http\Request;

class StreamController extends Controller
{
    
    public function getActiveStreamsCount()
    {
        $count = Stream::where('status', 'live')->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
