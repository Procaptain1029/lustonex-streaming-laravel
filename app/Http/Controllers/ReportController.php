<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the user's reports.
     */
    public function index()
    {
        $reports = Report::where('reporter_id', Auth::id())
            ->with(['reported', 'reportable'])
            ->latest()
            ->paginate(10);

        return view('reports.index', compact('reports'));
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reported_id' => 'required|exists:users,id',
            'reportable_id' => 'required',
            'reportable_type' => 'required|string',
            'reason' => 'required|string|max:1000',
        ]);

        // Evitar que un usuario se reporte a sí mismo
        if (Auth::id() == $request->reported_id) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.report.no_self_report')
            ], 400);
        }

        try {
            Report::create([
                'reporter_id' => Auth::id(),
                'reported_id' => $request->reported_id,
                'reportable_id' => $request->reportable_id,
                'reportable_type' => $request->reportable_type,
                'reason' => $request->reason,
                'status' => 'pending',
            ]);

            return response()->json([
                'success' => true,
                'message' => __('admin.flash.report.sent')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => __('admin.flash.report.error')
            ], 500);
        }
    }
}
