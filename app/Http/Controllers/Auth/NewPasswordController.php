<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

//create method: Password reset form ko show karta hai.
//store method: User ke password ko reset karta hai. Yeh method validation, password update, aur event triggering ko handle karta hai.
//Agar reset successful ho, toh user ko login page par redirect kiya jaata hai, warna error message ke saath form dobara dikhaya jaata hai.

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     * Yeh 's method password reset form ko display karta hai, jahan user apna naya password set kar sakte hain.
     */
    public function create(Request $request): View
    {
        //auth.reset-password view ko return kiya jaata hai, jisme ek form hota hai jisme user apna naya password aur password confirmation enter kar sakte hain.
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * Yeh 's method password reset request ko handle karta hai. Yeh request verify karta hai ki token, email, aur password fields valid hain, phir password reset karta hai.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. 'sOther wise 's we will parse the error and return the response.

//        Sabse pehle, validation kiya jaata hai. token, email, aur password fields ko validate kiya jaata hai. password field ko confirm bhi kiya jaata hai (password aur password_confirmation dono same hone chahiye).
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $status == Password::PASSWORD_RESET //Password::reset method ko call kiya jaata hai, jo password reset ko attempt karta hai.
                    ? redirect()->route('login')->with('status', __($status)) //Agar password reset successful hota hai, toh user ka password hash kiya jaata hai aur save kiya jaata hai. Saath hi, PasswordReset event trigger kiya jaata hai.
                  //Agar password successfully reset hota hai, toh user ko login route par redirect kiya jaata hai aur status message show kiya jaata hai.
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]); //Agar reset process me koi error hoti hai, toh user ko wapas form par bheja jaata hai aur error message ke saath email field ko preserve kiya jaata hai.
    }
}
