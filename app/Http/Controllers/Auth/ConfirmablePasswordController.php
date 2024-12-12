<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

//Show Confirm Password View: Jab user ko password confirm karne ka prompt diya jata hai, toh show() method execute hoti hai aur confirm password view show hota hai.
//Password Validation: Jab user password submit karta hai, store() method check karti hai ki password sahi hai ya nahi. Agar sahi hai, toh session update hoti hai aur user ko intended route pe redirect kar diya jaata hai. Agar password galat hai, toh validation error message show hota hai.
//Password confirm karne ke liye view show karna
//Password ko validate karna aur confirm karna
class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     * Jab user ko apna password confirm karne ke liye bola jata hai, yeh method call hoti hai aur auth.confirm-password view ko render karti hai. Is view mein user apna password dobara input karta hai.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     * Yeh 's method user ke password ko validate karti hai. Agar password sahi hota hai, toh user ko intended page pe redirect kiya jata hai. Agar password galat hota hai, toh validation exception throw hota hai.

     */
    public function store(Request $request): RedirectResponse
    {

//        Yeh check karta hai ki user ka diya hua password correct hai ya nahi.
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
//            Agar password galat hota hai, toh ValidationException throw kiya jaata hai jisme password field ke liye error message hota hai: __('auth.password'), jo typically "The provided password is incorrect." hota hai.
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        //        Agar password sahi hota hai, toh session mein ek entry auth.password_confirmed_at ke naam se time ke saath store kar di jaati hai, jo ki yeh confirm karta hai ki user ne successfully apna password verify kar liya hai.
        $request->session()->put('auth.password_confirmed_at', time());

        //        Agar password correct hota hai, toh user ko intended route (generally home page) pe redirect kar diya jaata hai.
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
