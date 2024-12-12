<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

//Purpose: Yeh controller user ki email ko verify karta hai jab wo verification link par click karte hain.
//Steps:
//Check if the email is already verified: Agar email pehle se verified hai, toh user ko home page par redirect kar diya jaata hai.
//Mark Email as Verified: Agar email verify nahi hui hai, toh email ko verified mark kiya jaata hai aur Verified event fire hota hai.
//Redirect: Verification ke baad user ko home page par redirect kiya jaata hai with a verified=1 query parameter.
//Is controller ka basic flow hai:
//
//Check if email is verified.
//Verify email if needed.
//    Trigger Verified event.
//Redirect user.


class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     * Yeh method authenticated user ki email address ko verify karta hai.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        // Pehle check kiya jaata hai ki user ki email already verified hai ya nahi.
        // Agar email already verified hai, toh user ko directly home page par redirect kar diya jaata hai with a query parameter verified=1, jo indicate karta hai ki verification complete ho gayi hai.
        //
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

//        Agar email verify nahi hui hai, toh markEmailAsVerified() method ko call kiya jaata hai, jo user ki email ko verified mark kar dega.
//    Email verification ke baad Verified event trigger hota hai. Yeh event typically email verification ke baad additional actions (jaise welcome email, etc.) perform karne ke liye use kiya jaata hai.
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        // Finally, agar email successfully verify ho jaati hai, toh user ko home page par redirect kar diya jaata hai with the query parameter verified=1 to confirm successful verification.
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}
