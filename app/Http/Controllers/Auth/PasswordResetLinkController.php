<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
//create() method:
//
//Password reset request form ko display karta hai.
//store() method:
//
//User ke input ko validate karta hai (email).
//Agar validation pass ho jata hai, toh password reset link ko user ke email par bhejta hai.
//Agar reset link bhejna successful hota hai, toh success message ke saath waapas redirect karta hai. Agar fail hota hai, toh error message ke saath form ko return karta hai.
//Flow:
//User email input karta hai.
//Validation hoti hai.
//Password reset link bheji jaati hai.
//Result ke hisaab se user ko success ya error message ke saath waapas redirect karte hain.
//
//
//
//
//

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     * //Yeh method password reset request view ko display karta hai, jahan user apna email address de sakta hai.
     */
    public function create(): View
    {
        //Yeh method auth.forgot-password view ko return karta hai, jo typically ek form hota hai jisme user apna email address input karta hai.
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * Yeh 's method password reset link request ko handle karta hai.
     */
    public function store(Request $request): RedirectResponse
    {
//        Pehle email field ko validate kiya jaata hai, jisme yeh check kiya jaata hai ki email address valid format mein ho.
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
//        Password::sendResetLink() method ko use karke, password reset link us email par bheja jaata hai jo user ne input kiya hai.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT //Agar reset link successfully bhej diya gaya hai, toh user ko ek success message ke saath form par redirect kar diya jaata hai.
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email')) //Agar kuch galat hota hai (jaise invalid email), toh user ko error message ke saath form par waapas bheja jaata hai.
                            ->withErrors(['email' => __($status)]);
    }
}
