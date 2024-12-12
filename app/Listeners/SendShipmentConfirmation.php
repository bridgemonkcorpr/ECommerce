<?php

namespace App\Listeners;

use App\Events\ShipmentCreated;
use App\Mail\DigitalShipmentConfirmed;
use App\Mail\PhysicalShipmentConfirmed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendShipmentConfirmation
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
     * @param  \App\Events\ShipmentCreated  $event
     * @return void
     */
    public function handle(ShipmentCreated $event)
    {
        if ($event->shipment->is_physical) {
            Mail::to($event->shipment->order->customer_email)->send(new PhysicalShipmentConfirmed($event->shipment));
        } else {
            Mail::to($event->shipment->order->customer_email)->send(new DigitalShipmentConfirmed($event->shipment));
        }
    }
}
