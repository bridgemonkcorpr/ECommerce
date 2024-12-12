<?php

namespace App\Http\Livewire\Employee\Shipping\Components;

use App\Models\Country;
use App\Models\ShippingZone;
use App\Models\ShippingZoneCountry;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ShippingZoneForm extends Component
{
    public ShippingZone $shippingZone;

    public array $countries = [];

    public array $selectedCountries = [];

    public bool $isShown = false;

    public $search = '';

    protected $listeners = ['create', 'edit', 'delete'];

    protected $rules = [
        'shippingZone.name' => 'required|string',
        'selectedCountries' => 'array|min:1|exists:countries,id|unique:App\Models\ShippingZoneCountry,country_id',
    ];

    protected $messages = [
        'selectedCountries.min' => 'Select at least :min country or region.',
    ];

    public function mount()
    {
        $this->shippingZone = new ShippingZone();
    }

    public function updatedSearch($value)
    {
        $value ? $this->filterCountries() : $this->loadCountries();
    }

    public function loadCountries()
    {
        $this->countries = Country::query()->select('id', 'name')->orderBy('name')->get()->toArray();
    }

    public function filterCountries()
    {
        $this->countries = collect($this->countries)->filter(function ($country) {
            return str_contains(strtolower($country['name']), strtolower($this->search));
        })->values()->toArray();
    }

    public function create()
    {
        $this->reset('selectedCountries');

        $this->resetErrorBag();

        $this->shippingZone = new ShippingZone();

        $this->loadCountries();

        $this->isShown = true;
    }

    public function edit(ShippingZone $shippingZone)
    {
        $this->reset('selectedCountries');

        $this->resetErrorBag();

        $this->shippingZone = $shippingZone;

        $this->shippingZone->loadMissing('countries');

        $this->loadCountries();

        $this->selectedCountries = $shippingZone->countries->pluck('country_id')->toArray();

        $this->isShown = true;
    }

    public function save()
    {
        $this->shippingZone->exists ? $this->update() : $this->store();
    }

    public function store()
    {
        $this->validate();

        $this->shippingZone->save();

        $this->shippingZone->countries()->createMany(
            collect($this->selectedCountries)->map(fn($countryId) => ['shipping_zone_id' => $this->shippingZone->id, 'country_id' => $countryId])->toArray()
        );

        $this->isShown = false;

        $this->emit('refresh')->up();
    }

    public function update()
    {
        $this->validate([
            'shippingZone.name' => 'required|string',
            'selectedCountries' => [
                'array',
                'min:1',
                Rule::unique('App\Models\ShippingZoneCountry', 'country_id')->ignore($this->shippingZone->id, 'shipping_zone_id'),
            ],
        ]);

        $this->shippingZone->save();

        $this->shippingZone->countries()->delete();

        $this->shippingZone->countries()->createMany(
            collect($this->selectedCountries)->map(fn($countryId) => ['shipping_zone_id' => $this->shippingZone->id, 'country_id' => $countryId])->toArray()
        );

        $this->isShown = false;

        $this->emit('refresh')->up();
    }
    
    public function getCountriesInAnotherZonesProperty(): array
    {
        return ShippingZoneCountry::query()->pluck('country_id')->toArray();
    }

    public function render()
    {
        return view('livewire.employee.shipping.components.shipping-zone-form');
    }
}
