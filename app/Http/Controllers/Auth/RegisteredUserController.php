<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\LegalAcceptance;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    
    public function create(Request $request): View
    {
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        }
        return view('auth.register');
    }

    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:fan,model'],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));

        LegalAcceptance::create([
            'user_id' => $user->id,
            'acceptance_type' => 'registration',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'accepted_at' => Carbon::now(),
        ]);

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    
    public function storeModel(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms_accepted' => ['required', 'accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'model',
        ]);

        
        Profile::create([
            'user_id'              => $user->id,
            'display_name'         => $request->name,
            'bio'                  => __('admin.flash.auth.default_bio'),
            'subscription_price'   => 19.99,
            'is_online'            => false,
            'is_streaming'         => false,
            'profile_completed'    => false,
        ]);

        event(new Registered($user));

        LegalAcceptance::create([
            'user_id' => $user->id,
            'acceptance_type' => 'registration',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'accepted_at' => Carbon::now(),
        ]);

        Auth::login($user);

        
        return redirect()->route('verification.notice')->with('success', __('admin.flash.auth.register_model_success'));
    }
}
