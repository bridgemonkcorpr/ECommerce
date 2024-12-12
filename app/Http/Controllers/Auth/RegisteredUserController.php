<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
//  create() method:
//  Registration form view ko display karta hai.
//  store() method:
//  User ke input (name, email, password) ko validate karta hai.
//  Agar validation pass ho jata hai, toh user ko database mein store karta hai aur password ko hash karta hai.
//  Registration ke baad user ko login kar diya jaata hai.
//  Successful registration par user ko home page ya intended route par redirect karta hai.
//  Flow:
//  User apna registration form fill karta hai.
//  Validation hoti hai (name, email, password).
//  Agar sab kuch sahi hai, toh user create hota hai aur login kar diya jaata hai.
//  Event Registered fire hota hai.
//  User ko redirect kar diya jaata hai.
//  Is controller ka basic flow simple hai: Validation → User Creation → Event Trigger → Login → Redirect.
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * Yeh 's method registration form view ko display karta hai.
     */
    public function create(): View
    {
        return view('auth.register'); // Yeh method auth.register view ko return karta hai, jahan user apna naam, email aur password enter karta hai.
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     * Yeh method registration request ko handle karta hai. Isme user ki details ko validate kiya jaata hai, aur agar sab kuch sahi hota hai, toh user ko database mein store kiya jaata hai aur login bhi kiya jaata hai.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . Customer::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
// Agar validation pass ho jaata hai, toh Customer::create() se new customer record create kiya jaata hai.
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // password ko hash kiya jaata hai Hash::make() se, taaki security ensure ho sake.
        ]);

        event(new Registered($customer));  // Registration complete hone par Registered event trigger hota hai, jo typically welcome email ya verification link bhejne ke liye use hota hai.

        Auth::login($customer); // Customer ko turant login kar diya jaata hai.

        return redirect(RouteServiceProvider::HOME); // Agar registration successful hota hai, toh user ko home page ya desired route par redirect kiya jaata hai.
    }
}
