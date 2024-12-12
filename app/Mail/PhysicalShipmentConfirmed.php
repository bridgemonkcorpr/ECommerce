<?php

namespace App\Mail;

use App\Models\Shipment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class PhysicalShipmentConfirmed extends Mailable
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
            ->subject(trans('A shipment from order #:id is on the way', [
                'id' => $this->shipment->order_id,
            ]))
            ->markdown('emails.shipments.physical-confirmed', [
                'url' => URL::signedRoute('guest.orders.detail', $this->shipment->order_id),
            ]);
    }
}
