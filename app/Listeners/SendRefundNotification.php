<?php

namespace App\Listeners;

use App\Events\RefundCreated;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRefundNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RefundCreated $event): void
    {
        $refund = $event->refund;

        $order = Order::find($refund->order_id);

        \Mail::to($order->customer_email)->send(new \App\Mail\RefundCreated($refund, $order));
    }
}
