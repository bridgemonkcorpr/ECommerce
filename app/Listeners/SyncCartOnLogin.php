<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SyncCartOnLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        if ($user instanceof Customer) {
            $cart = $user->cart ?? $user->cart()->create(['customer_email' => $user->email]);

            $previousSessionId = session()->pull('previous_session_id');

            $previousCartInstance = Cart::query()->firstWhere('session_id', $previousSessionId);

            if ($previousCartInstance) {

                $cart->items()->saveMany($previousCartInstance->items);

                $previousCartInstance->delete();
            }
        }
    }
}
