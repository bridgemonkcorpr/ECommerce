<?php

namespace App\Listeners;

use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateOrderPaymentStatus
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
    public function handle(object $event): void
    {
        $order = Order::query()->with(['payments', 'refunds'])->find($event->refund->order_id);

        $order->payment_status = $order->total_paid == $order->total_refunded
            ? PaymentStatus::REFUNDED
            : PaymentStatus::PARTIALLY_REFUNDED;

        $order->save();
    }
}
