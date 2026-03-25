<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ModelVerificationApproved;
use App\Mail\ModelVerificationRejected;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }


    public function index(Request $request)
    {

        $models = User::where('role', 'model')
            ->where(function ($q) {
                $q->whereNull('email_verified_at')
                    ->orWhereHas('profile', function ($q2) {
                        $q2->where('verification_status', '!=', 'approved');
                    });
            })
            ->with('profile')
            ->paginate(15);

        return view('admin.verification.index', compact('models'));
    }


    public function show(Profile $profile)
    {
        $profile->load('user', 'verifiedBy');

        return view('admin.verification.show', compact('profile'));
    }


    public function approve(Request $request, Profile $profile)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($profile->verification_status === 'approved') {
            return back()->with('info', __('admin.flash.verification.already_approved'));
        }


        $profile->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'admin_notes' => $request->admin_notes,
            'rejection_reason' => null,
        ]);


        $mission = \App\Models\Mission::where('name', 'Verificar Identidad')->first();
        if ($mission) {
            $userMission = $profile->user->missions()->where('mission_id', $mission->id)->first();
            if ($userMission && !$userMission->pivot->completed) {
                $profile->user->missions()->updateExistingPivot($mission->id, [
                    'completed' => true,
                    'completed_at' => now(),
                    'progress' => $mission->target ?? 1,
                ]);
            }
        }

        // Send Approved Email
        try {
            Mail::to($profile->user)->send(new ModelVerificationApproved($profile->user));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de aprobación: ' . $e->getMessage());
        }

        return redirect()->route('admin.verification.index')
            ->with('success', __('admin.flash.verification.profile_approved', ['name' => $profile->user->name]));
    }


    public function reject(Request $request, Profile $profile)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($profile->verification_status === 'approved') {
            return back()->with('info', __('admin.flash.verification.already_approved'));
        }


        $profile->update([
            'verification_status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'admin_notes' => $request->admin_notes,
            'rejection_reason' => $request->rejection_reason,

            'step1_completed' => false,
            'step2_completed' => false,
            'step3_completed' => false,
            'onboarding_completed_at' => null,
        ]);

        // Send Rejected Email
        try {
            Mail::to($profile->user)->send(new ModelVerificationRejected($profile->user, $request->rejection_reason));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de rechazo: ' . $e->getMessage());
        }

        return redirect()->route('admin.verification.index')
            ->with('success', __('admin.flash.verification.profile_rejected', ['name' => $profile->user->name]));
    }


    public function review(Request $request, Profile $profile)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $profile->update([
            'verification_status' => 'under_review',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->route('admin.verification.index')
            ->with('success', __('admin.flash.verification.profile_in_review', ['name' => $profile->user->name]));
    }


    public function stats()
    {
        $stats = [
            'total_models' => User::where('role', 'model')->count(),
            'pending_verification' => Profile::where('verification_status', 'pending')->count(),
            'under_review' => Profile::where('verification_status', 'under_review')->count(),
            'approved' => Profile::where('verification_status', 'approved')->count(),
            'rejected' => Profile::where('verification_status', 'rejected')->count(),
            'recent_verifications' => Profile::with('user', 'verifiedBy')
                ->whereNotNull('verified_at')
                ->orderBy('verified_at', 'desc')
                ->take(10)
                ->get(),
        ];

        return view('admin.verification.stats', compact('stats'));
    }
}
