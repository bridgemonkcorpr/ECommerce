<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
//Agar user ka email already verified hai, toh woh directly home page ya intended page pe redirect ho jaata hai.
//Agar email verify nahi hai, toh controller email verification link bhejta hai aur user ko notification ke saath page pe wapas le aata hai, taaki user ko pata chale ki link bhej diya gaya hai.
class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     * Is method ka kaam user ko email verification link bhejna hai agar unhone apna email verify nahi kiya hai.
     */
    public function store(Request $request): RedirectResponse
    {
//        Pehle yeh check kiya jaata hai ki user ka email already verified hai ya nahi. Agar email verified hai, toh user ko home page ya intended page par redirect kiya jata hai.
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }
//        Agar email verify nahi hai, toh sendEmailVerificationNotification() method ko call kiya jaata hai, jo user ko email verification link bhejta hai.
        $request->user()->sendEmailVerificationNotification();
//        Uske baad, user ko verification-link-sent status ke saath back (same page) redirect kiya jata hai, jo front-end par ek notification show karta hai ki verification link bheja gaya hai.
        return back()->with('status', 'verification-link-sent');
    }
}
