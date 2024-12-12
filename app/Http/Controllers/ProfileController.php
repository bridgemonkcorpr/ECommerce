<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     * User ka profile edit karne ka form dikhata hai.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(), // Authenticated user ka data, view me pass hota hai
        ]);
    }

    /**
     * Update the user's profile information.
     * User ke profile information ko update karne ka kaam karta hai.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated()); // // Validated data se user profile ko update karte hain

        if ($request->user()->isDirty('email')) {  //  Agar email change hota hai
            $request->user()->email_verified_at = null;  // Email verification ke liye email_verified_at ko null set karte hain
        }

        $request->user()->save();  // Changes ko save karte hain

        return Redirect::route('profile.edit')->with('status', 'profile-updated'); // Success message ke saath redirect karte hain
    }

    /**
     * Delete the user's account.
     *  User ka account delete karne ka kaam karta hai.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],  //  Current password validate karte hain
        ]);

        $user = $request->user();  // // Authenticated user ko get karte hain

        Auth::logout();  // User ko logout karte hain

        $user->delete(); // User ka account delete karte hain

        $request->session()->invalidate();   // Session invalidate karte hain
        $request->session()->regenerateToken();  // CSRF token regenerate karte hain

        return Redirect::to('/');  // Homepage par redirect karte hain
    }
}
