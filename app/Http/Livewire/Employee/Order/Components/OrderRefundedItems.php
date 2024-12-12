<?php

namespace App\Http\Livewire\Employee\Order\Components;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;

class OrderRefundedItems extends Component
{
    public Order $order;

    public function getRefundedItemRowsProperty()
    {
        return OrderItem::query()
            ->with([
                'discount.orderItem',
                'variant.media',
                'variant.product.media',
                'variant.variantAttributes.option',
                'variant.variantAttributes.optionValue',
            ])
            ->withSum(['refundItems' => fn($query) => $query->where('is_shipped', false)], 'quantity')
            ->where('order_id', $this->order->id)
            ->whereHas('refundItems')
            ->get();
    }

    public function render()
    {
        return view('livewire.employee.order.components.order-refunded-items', [
            'refundedItems' => $this->refundedItemRows,
        ]);
    }
}
