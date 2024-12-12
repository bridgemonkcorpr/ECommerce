<?php

namespace App\Mail;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class DigitalShipmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $shipment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Shipment $shipment)
    {
        $this->shipment = $shipment;

        $this->shipment->load([
            'shipmentItems.orderItem.product:id,name,slug',
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('Your downloads from order #:id are ready', [
                'id' => $this->shipment->order_id,
            ]))
            ->markdown('emails.shipments.digital-confirmed', [
                'url' => URL::signedRoute('guest.orders.detail', $this->shipment->order_id),
            ]);
    }
}
