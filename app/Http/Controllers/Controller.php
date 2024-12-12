<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests
    // Is trait ko use karke aap authorization rules ko easily implement kar sakte hain.
//        Yeh trait authorization-related functionalities provide karta hai. Agar aapko kisi specific action ke liye user ke permissions check karne ki zarurat ho, toh yeh trait us functionality ko easily provide karta hai. Iske through aap authorize() method ko use kar ke kisi bhi action ki permission check kar sakte hain.
        , ValidatesRequests;
    // Form validation handle karne ke liye use hota hai.
//        Yeh trait form validation handle karta hai. Aap validation rules define kar sakte hain jo user inputs ko validate karte hain. Is trait ki madad se, aap request data ko easily validate kar sakte hain using methods like $request->validate().
}
