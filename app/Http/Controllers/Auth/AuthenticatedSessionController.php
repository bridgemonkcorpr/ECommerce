<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

//Login page dikhana
//Login request ko authenticate karna
//Logout karna


//Login Process: Jab user login form submit karta hai, system uske credentials authenticate karta hai, session regenerate karta hai, aur user ko home page pe redirect kar deta hai.
//Logout Process: Jab user logout karta hai, session ko invalidate kiya jaata hai, CSRF token regenerate hota hai, aur user ko home page pe redirect kiya jaata hai.
class AuthenticatedSessionController extends Controller
{


    /**
     * Display the login view.
     * Jab user login page pe jaana chahta hai, yeh method call hoti hai aur login form ko render karne ke liye auth.login view dikhata hai.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     * Yeh 's method login request ko handle karti hai. Jab user login karne ka try karta hai, yeh method execute hoti hai.
     *
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //Is line se, current session ID ko previous_session_id ke naam se store kar liya jaata hai.
        session()->put('previous_session_id', session()->getId());
         // Yeh method check karti hai ki user ne jo credentials diye hain, woh sahi hain ya nahi. Agar sahi hain to login ho jaata hai.
        $request->authenticate();

        // Yeh ensure karta hai ke session ID regenerate ho jaye, taaki security purposes ke liye session hijacking se bacha ja sake.
        $request->session()->regenerate();
        // Agar login successful hota hai, to user ko intended page (home page) pe redirect kiya jaata hai.
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     * Yeh method logout ko handle karti hai jab user apna session end karna chahta hai.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Yeh line specific guard (customer) ka use karke user ko logout kar deti hai.
        Auth::guard('customer')->logout();

        //  Yeh line session ko invalidate kar deti hai, taaki koi bhi session hijacking na ho.
        $request->session()->invalidate();


         // Yeh CSRF token ko regenerate karne ke liye use hoti hai, taaki security ensure ho sake.
        $request->session()->regenerateToken();

        //  Logout ke baad user ko home page pe redirect kar diya jaata hai.
        return redirect('/');
    }
}
