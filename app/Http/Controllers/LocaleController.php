<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Update the user's locale preference.
     */
    public function update(Request $request)
    {
        $request->validate([
            'locale' => 'required|string|in:es,en,pt_BR',
        ]);

        $locale = $request->input('locale');

        // Apply locale to current runtime and session
        App::setLocale($locale);
        Session::put('locale', $locale);

        // Save preference if user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $user->locale = $locale;
            $user->save();
        }

        return redirect()->back();
    }
}
