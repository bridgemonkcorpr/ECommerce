<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
//Agar user ka email already verified hai, toh woh home page ya intended page par redirect ho jaata hai.
//Agar email verify nahi hai, toh auth.verify-email view ko display kiya jaata hai, jahan user apna email verify karne ke liye instructions dekh sakta hai.
class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     * Is method ka kaam user ko email verification prompt dikhana hai ya agar email already verified hai toh unhe home page par redirect karna hai.
     */
    public function __invoke(Request $request): RedirectResponse|View
    {
        return $request->user()->hasVerifiedEmail() //Sabse pehle, yeh check kiya jaata hai ki user ka email verified hai ya nahi.
                    ? redirect()->intended(RouteServiceProvider::HOME) //Agar user ka email verify ho chuka hai ($request->user()->hasVerifiedEmail()), toh user ko RouteServiceProvider::HOME (home page) par redirect kar diya jata hai.
                    : view('auth.verify-email'); //Agar email verify nahi hai, toh view('auth.verify-email') se email verification prompt dikhaya jaata hai, jisme user ko apne email ko verify karne ke liye ek prompt diya jaata hai.
    }
}
