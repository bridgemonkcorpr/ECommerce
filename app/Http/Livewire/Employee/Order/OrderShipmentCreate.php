<?php

namespace App\Http\Livewire\Employee\Order;

use App\Enums\ShippingCarrier;
use App\Enums\ShippingStatus;
use App\Events\ShipmentCreated;
use App\Models\Order;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class OrderShipmentCreate extends Component
{
    public Order $order;

    public Shipment $shipment;

    public Collection $shipmentItems;

    public $type = 'physical';

    protected $queryString = ['type'];

    protected function rules()
    {
        return [
            'shipment.order_id' => 'required',
            'shipment.shipping_carrier' => ['nullable', new Enum(ShippingCarrier::class)],
            'shipment.tracking_number' => 'nullable|string',
            'shipment.tracking_url' => 'nullable|string',
            'shipment.is_physical' => 'required|boolean',
            'shipmentItems.*.order_id' => 'required|integer',
            'shipmentItems.*.order_item_id' => 'required|integer',
            'shipmentItems.*.quantity' => 'required|integer',
        ];
    }

    public function mount()
    {
        abort_if(! in_array($this->type, ['physical', 'digital']), 500);

        abort_if($this->order->shipping_status->value == ShippingStatus::SHIPPED->value, 404);

        $this->order->load('shippingAddress.country:id,name');

        $this->makeBlankShipment();
    }

    public function save()
    {
        $this->validate();

        $this->shipmentItems = $this->shipmentItems->reject(fn($item) => $item->quantity < 1);

        if ($this->shipmentItems->isEmpty()) {
            $this->makeBlankShipment();

            return $this->addError('shipmentItems', __('Please select at least one item to ship'));
        }

        $this->shipment->save();

        $this->shipment->shipmentItems()->saveMany($this->shipmentItems);

        foreach ($this->shipmentItems as $item) {
            $item->orderItem->variant->decrement('stock_value', $item->quantity);

            $item->orderItem->variant->save();
        }

        ShipmentCreated::dispatch($this->shipment);

        return redirect()->route('employee.orders.detail', $this->order);
    }

    public function getUnshippedItemsProperty()
    {
        $this->loadOrderItems();

        return $this->order->orderItems->filter(function ($item) {
            return $item->shipmentItems->sum('quantity') < $item->quantity;
        });
    }

    protected function makeBlankShipment()
    {
        $this->loadOrderItems();

        $this->shipment = new Shipment([
            'shipping_carrier' => ShippingCarrier::OTHER->value,
            'is_physical' => $this->type == 'physical',
        ]);

        $this->shipment->order()->associate($this->order);

        $this->shipmentItems = new Collection();

        foreach ($this->order->orderItems as $item) {
            if ($item->shipmentItems->sum('quantity') < $item->quantity) {
                $this->shipmentItems->push(new ShipmentItem([
                    'order_id' => $this->order->id,
                    'order_item_id' => $item->id,
                    'quantity' => $item->quantity - ($item->shipmentItems->sum('quantity') + $item->refundItems->sum('quantity')),
                ]));
            }
        }
    }

    protected function loadOrderItems(): Order
    {
        return $this->order->load([
            'orderItems' => function ($query) {
                return $query->whereHas('variant', function ($q) {
                    return $q->where('shipping_type', $this->type);
                });
            },
            'orderItems.variant.media',
            'orderItems.variant.product.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
            'orderItems.shipmentItems',
            'orderItems.refundItems' => fn($query) => $query->where('is_shipped', false),
        ]);
    }

    public function render()
    {
        return view('livewire.employee.order.order-shipment-create', [
            'shippingCarriers' => ShippingCarrier::cases(),
        ])->layout('layouts.admin');
    }
}
