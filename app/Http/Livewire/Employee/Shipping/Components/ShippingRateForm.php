<?php

namespace App\Http\Livewire\Employee\Shipping\Components;

use App\Models\ShippingZone;
use App\Models\ShippingZoneRate;
use Livewire\Component;

class ShippingRateForm extends Component
{
    public ShippingZoneRate $shippingRate;

    public $hasConditions = false;

    public $isShown = false;

    protected $listeners = ['create', 'edit', 'delete'];

    protected $rules = [
        'shippingRate.shipping_zone_id' => 'required|exists:shipping_zones,id',
        'shippingRate.name' => 'required|string',
        'shippingRate.price' => 'required|numeric|min:0',
        'shippingRate.description' => 'nullable|string',
        'shippingRate.based_on' => 'sometimes|nullable|in:weight,price',
        'shippingRate.min_value' => 'sometimes|nullable|numeric|min:0|required_with:shippingRate.based_on',
        'shippingRate.max_value' => 'sometimes|nullable|numeric|gt:shippingRate.min_value',
    ];

    public function mount()
    {
        $this->shippingRate = new ShippingZoneRate();
    }

    public function create(ShippingZone $shippingZone)
    {
        $this->hasConditions = false;

        $this->shippingRate = new ShippingZoneRate();

        $this->shippingRate->zone()->associate($shippingZone);

        $this->isShown = true;
    }

    public function edit(ShippingZoneRate $shippingRate)
    {
        $this->shippingRate = $shippingRate;

        $this->hasConditions = $shippingRate->hasConditions;

        $this->isShown = true;
    }

    public function save()
    {
        $this->validate();

        $this->shippingRate->save();

        $this->isShown = false;

        $this->emit('refresh');
    }

    public function addConditions()
    {
        $this->shippingRate->based_on = 'weight';
    }

    public function removeConditions()
    {
        $this->shippingRate->based_on = null;

        $this->shippingRate->min_value = null;

        $this->shippingRate->max_value = null;

        $this->hasConditions = false;
    }

    public function updatedShippingRateMinValue($value)
    {
        $this->shippingRate->min_value = $value == 0 ? null : str_replace(',', '', $value);
    }

    public function updatedShippingRateMaxValue($value)
    {
        $this->shippingRate->max_value = $value == 0 ? null : str_replace(',', '', $value);
    }

    public function render()
    {
        return view('livewire.employee.shipping.components.shipping-rate-form');
    }
}
