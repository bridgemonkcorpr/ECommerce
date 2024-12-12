<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

//update method: Yeh method user ke current password ko validate karta hai, naya password update karta hai, aur successful update hone par user ko page par redirect karta hai with a success status.
//Validation: current_password aur password fields validate hote hain, jisme confirmed rule ensure karta hai ki naya password aur uska confirmation match karein.
class PasswordController extends Controller
{
    /**
     * Update the user's password.
     * Yeh method user ke current password ko verify karne ke baad unka password update karta hai.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'], //Yeh field user ke current password ko validate karta hai. current_password rule ensure karta hai ki jo password user ne diya hai wo unka current password hai. Iske liye Laravel ko custom validation rule ki zarurat hoti hai, jo typically current_password rule ke through implement hota hai.
            'password' => ['required', Password::defaults(), 'confirmed'], //Yeh field user ke naya password ko validate karta hai. Password ko Password::defaults() rule ke through validate kiya jaata hai, jo default password policies ko enforce karta hai (jaise ki minimum length, character mix, etc.). Aur confirmed rule ensure karta hai ki password aur password_confirmation fields match karte hain.
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']), // Agar validation pass ho jaata hai, toh user ka password update kiya jaata hai. Hash::make() function user ke naya password ko hash karne ke liye use kiya jaata hai, taaki password securely store ho sake.
        ]);
// Password successfully update hone ke baad, user ko current page par redirect kiya jaata hai (typically password change page), aur ek success message (password-updated) ke saath.
        return back()->with('status', 'password-updated');
    }
}
