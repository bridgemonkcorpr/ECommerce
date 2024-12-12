<?php

namespace App\Http\Livewire\Employee\Order\Components;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;

class OrderItems extends Component
{
    public Order $order;

    protected $listeners = ['refresh' => '$refresh'];

    public function getDigitalRowsProperty()
    {
        return OrderItem::query()
            ->with([
                'discount.orderItem',
                'variant.media',
                'variant.product.media',
                'variant.variantAttributes.option',
                'variant.variantAttributes.optionValue',
            ])
            ->withSum([
                'shipmentItems',
                'refundItems as total_unshipped_refunded' => fn($query) => $query->where('is_shipped', false),
                'refundItems as total_shipped_refunded' => fn($query) => $query->where('is_shipped', true)
            ], 'quantity')
            ->where('order_id', $this->order->id)
            ->whereHas('variant', function ($query) {
                return $query->where('shipping_type', 'digital');
            })
            ->get()
            ->reject(function ($item) {
                return $item->shipment_items_sum_quantity != null && $item->shipment_items_sum_quantity + $item->refund_items_sum_quantity >= $item->quantity;
            });
    }

    public function getPhysicalRowsProperty()
    {
        return OrderItem::query()
            ->with([
                'discount.orderItem',
                'variant.media',
                'variant.product.media',
                'variant.variantAttributes.option',
                'variant.variantAttributes.optionValue',
            ])
            ->withSum([
                'shipmentItems as total_shipped',
                'refundItems as total_removed' => fn($query) => $query->where('is_shipped', false),
                'refundItems as total_shipped_refunded' => fn($query) => $query->where('is_shipped', true)
            ], 'quantity')
            ->where('order_id', $this->order->id)
            ->whereHas('variant', function ($query) {
                return $query->where('shipping_type', 'physical');
            })
            ->get()
            ->reject(function ($item) {
                return $item->total_shipped > $item->quantity || $item->total_shipped + $item->total_removed >= $item->quantity;
            });
    }

    public function render()
    {
        return view('livewire.employee.order.components.order-items', [
            'digitalItems' => $this->digitalRows,
            'physicalItems' => $this->physicalRows,
        ]);
    }
}
