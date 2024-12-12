<?php

namespace App\Http\Livewire\Employee\Order\Components;

use App\Enums\ShippingCarrier;
use App\Events\ShipmentDeleted;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rules\Enum;
use Livewire\Component;

class OrderShipments extends Component
{
    public Order $order;

    public $isEditingShipment = false;

    public $shipmentBeingUpdated;

    protected $listeners = ['refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'shipmentBeingUpdated.shipping_carrier' => ['required', new Enum(ShippingCarrier::class)],
            'shipmentBeingUpdated.tracking_number' => 'required|string',
            'shipmentBeingUpdated.tracking_url' => 'nullable|string',
        ];
    }

    public function edit(Shipment $shipment)
    {
        $this->shipmentBeingUpdated = $shipment;

        $this->shipmentBeingUpdated->shipping_carrier = ShippingCarrier::OTHER->value;

        $this->isEditingShipment = true;
    }

    public function update()
    {
        $this->validate();

        $this->shipmentBeingUpdated->save();

        $this->isEditingShipment = false;

        $this->emit('refresh')->self();

        $this->notify(trans('Tracking information updated.'));
    }

    public function delete(Shipment $shipment)
    {
        $shipment->delete();

        $this->emit('refresh')->self();

        $this->emit('refresh')->to('employee.order.order-detail');

        $this->emit('refresh')->to('employee.order.components.order-items');

        $this->notify(trans('Shipment removed.'));
    }

    public function getShipmentRowsProperty()
    {
        return Shipment::query()
            ->with([
                'shipmentItems.orderItem.variant.media',
                'shipmentItems.orderItem.variant.product.media',
                'shipmentItems.orderItem.variant.variantAttributes.option',
                'shipmentItems.orderItem.variant.variantAttributes.optionValue',
            ])
            ->where('order_id', $this->order->id)
            ->get();
    }

    public function render()
    {
        return view('livewire.employee.order.components.order-shipments', [
            'shipments' => $this->shipmentRows,
            'shippingCarriers' => ShippingCarrier::cases(),
        ]);
    }
}
