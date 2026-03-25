<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('profile')
            ->where('role', 'Fan');


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }


        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function index_model(Request $request)
    {
        $query = User::with('profile')
            ->where('role', 'Model');


        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            $query->whereHas('profile', function ($q) use ($status) {
                $q->where('verification_status', $status);
            });
        }


        $users = $query->latest()->paginate(10);

        return view('admin.model.index', compact('users'));
    }

    public function approveEmail(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return back()->with('success', __('admin.flash.users.email_approved'));
    }

    public function resendVerification(User $user)
    {
        if (!$user->hasVerifiedEmail()) {
            try {

                $user->sendEmailVerificationNotification();

                return back()->with('success', __('admin.flash.users.verification_sent'));
            } catch (\Exception $e) {

                return back()->with('info', __('admin.flash.users.verification_testing'));
            }
        }

        return back()->with('info', __('admin.flash.users.already_verified'));
    }



    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:model,fan,admin',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);


        if ($user->isModel()) {
            $user->profile()->create([]);
        }

        ActivityLog::log('user_created', 'Usuario creado: ' . $user->name, $user);

        return redirect()->route('admin.users.index')->with('success', __('admin.flash.users.created'));
    }

    public function show(User $user)
    {
        $user->load(['profile', 'progress.currentLevel', 'missions']);
        return view('admin.users.show', compact('user'));
    }

    public function showModel(User $user)
    {

        $user->load(['profile', 'photos', 'videos', 'streams']);


        $stats = [
            'subscribers' => $user->subscriptionsAsModel()->where('status', 'active')->count(),
            'total_earnings' => $user->tipsReceived()->sum('amount') ?? 0,
            'total_content' => $user->photos()->count() + $user->videos()->count(),
            'photos_count' => $user->photos()->count(),
            'videos_count' => $user->videos()->count(),
            'streams_count' => $user->streams()->count(),
            'tips_count' => $user->tipsReceived()->count(),
        ];


        $model = $user;

        return view('admin.model.show', compact('model', 'stats'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:model,fan,admin',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        ActivityLog::log('user_updated', 'Usuario actualizado: ' . $user->name, $user);

        return redirect()->route('admin.users.index')->with('success', __('admin.flash.users.updated'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', __('admin.flash.users.cannot_delete_self'));
        }

        $userName = $user->name;
        $user->delete();

        ActivityLog::log('user_deleted', 'Usuario eliminado: ' . $userName);

        return redirect()->route('admin.users.index')->with('success', __('admin.flash.users.deleted'));
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        ActivityLog::log('user_status_changed', 'Estado de usuario cambiado: ' . $user->name, $user);

        return back()->with('success', __('admin.flash.users.status_updated'));
    }
}
