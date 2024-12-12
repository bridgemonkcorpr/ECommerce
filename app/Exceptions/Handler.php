<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *Aap is class ko customize karke apni application mein specific exceptions ko handle kar sakte ho. Jaise:

     * Agar koi user invalid request bhejta hai to aap usko specific error message de sakte ho.
    * Agar koi sensitive data error ke case mein flash ho raha hai to aap usse rok sakte ho.
    * Yeh 's exception handling system Laravel mein application errors ko efficiently handle karne ke liye built-in hai aur aap apni requirements ke hisaab se isko customize kar sakte ho.
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     *     Is property mein aap specify karte hain ki kaunse exception types ko kaunse log level pe log kiya jaayega. Agar aap chahte hain ki kuch exceptions ko specific log level pe record kiya jaaye (jaise emergency, alert, etc.), to aap unhe yahan define kar sakte hain.
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     *      Is property mein aap un exception types ko list karte hain jinhein aap log nahi karna chahte. Agar koi exception is list mein ho, to woh exception log nahi hoga, par system usko handle kar lega.

      * Example: Agar aapko chahte ho ki validation exceptions ko log na kiya jaaye, to unhein yahan add kar sakte hain.
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     *     Is property mein aap un input fields ko define karte hain jo validation exceptions mein session mein flash nahi kiye jaayenge. Yeh sensitive data ko session mein store hone se rokne ke liye use hota hai, jaise password fields.

     * Example: current_password, password, password_confirmation ko yahan add karke aap ensure karte ho ki ye fields session mein flash na ho.
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     * register(): Is method ka use application mein exception handling callbacks ko register karne ke liye hota hai.
     * $this->reportable(function (Throwable $e) {...}): Is function ka use aap apni custom exception handling logic ko implement karne ke liye kar sakte hain. Jab koi exception trigger hota hai, aap is callback ke andar us exception ko process kar sakte hain, jaise ki custom logging, notifications, etc.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
