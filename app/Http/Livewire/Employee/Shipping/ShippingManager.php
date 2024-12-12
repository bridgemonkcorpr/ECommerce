<?php

namespace App\Http\Livewire\Employee\Shipping;

use App\Models\ShippingZone;
use App\Models\ShippingZoneRate;
use Livewire\Component;

class ShippingManager extends Component
{
    public $confirmingShippingZoneDeletion = false;

    public $shippingZoneBeingDeleted;

    public $confirmingShippingRateDeletion = false;

    public $shippingRateBeingDeleted;

    protected $listeners = ['refresh' => '$refresh'];

    public function confirmShippingZoneDeletion($shippingZoneId)
    {
        $this->confirmingShippingZoneDeletion = true;

        $this->shippingZoneBeingDeleted = $shippingZoneId;
    }

    public function deleteShippingZone()
    {
        $this->shippingZones->where('id', $this->shippingZoneBeingDeleted)->first()->delete();

        $this->emitSelf('refresh');

        $this->confirmingShippingZoneDeletion = false;
    }

    public function confirmShippingRateDeletion($shippingRateId)
    {
        $this->confirmingShippingRateDeletion = true;

        $this->shippingRateBeingDeleted = $shippingRateId;
    }

    public function deleteShippingRate()
    {
        ShippingZoneRate::query()->where('id', $this->shippingRateBeingDeleted)->delete();

        $this->emitSelf('refresh');

        $this->confirmingShippingRateDeletion = false;
    }

    public function getShippingZonesProperty()
    {
        return ShippingZone::with('countries.country', 'rates')->get();
    }

    public function render()
    {
        return view('livewire.employee.shipping.shipping-manager')->layout('layouts.admin');
    }
}
