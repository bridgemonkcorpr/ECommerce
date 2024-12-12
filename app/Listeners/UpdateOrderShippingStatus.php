<?php

namespace App\Listeners;

use App\Enums\ShippingStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class UpdateOrderShippingStatus
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
     * @param $event
     * @return void
     */
    public function handle($event)
    {
        $order = Order::query()->with('shipments')->find($event->shipment->order_id);

        $orderItems = OrderItem::query()->withSum('shipmentItems', 'quantity')->where('order_id', $order->id)->get();

        if ($order->shipments->count() >= 1) {
            if ($this->isAllOrderItemShipped($orderItems)) {
                $order->shipping_status = ShippingStatus::SHIPPED->value;
            } else {
                $order->shipping_status = ShippingStatus::PARTIALLY_SHIPPED->value;
            }
        } else {
            $order->shipping_status = ShippingStatus::UNSHIPPED->value;
        }

        $order->save();
    }

    protected function isAllOrderItemShipped(Collection $orderItems)
    {
        return $orderItems->every(function ($item) {
            return $item->quantity == $item->shipment_items_sum_quantity;
        });
    }
}
