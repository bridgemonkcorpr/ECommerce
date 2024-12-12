<?php

namespace App\Http\Livewire\Employee\Taxation\Components;

use App\Models\Country;
use App\Models\TaxZone;
use App\Models\TaxZoneCountry;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TaxZoneForm extends Component
{
    public TaxZone $taxZone;

    public array $countries = [];

    public array $selectedCountries = [];

    public bool $isShown = false;

    public $search = '';

    protected $listeners = ['create', 'edit', 'delete'];

    protected $rules = [
        'taxZone.name' => 'required|string',
        'selectedCountries' => 'array|min:1|exists:countries,id|unique:App\Models\TaxZoneCountry,country_id',
    ];

    protected $messages = [
        'selectedCountries.min' => 'Select at least :min country or region.',
    ];

    public function mount()
    {
        $this->taxZone = new TaxZone();
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
        $this->countries = Country::query()->select('id', 'name')->where('name', 'like', '%' . $this->search . '%')->orderBy('name')->get()->toArray();
    }

    public function create()
    {
        $this->reset('selectedCountries');

        $this->resetErrorBag();

        $this->taxZone = new TaxZone();

        $this->loadCountries();

        $this->isShown = true;
    }

    public function edit(TaxZone $taxZone)
    {
        $this->reset('selectedCountries');

        $this->resetErrorBag();

        $this->taxZone = $taxZone;

        $this->taxZone->loadMissing('countries');

        $this->loadCountries();

        $this->selectedCountries = $taxZone->countries->pluck('country_id')->toArray();

        $this->isShown = true;
    }

    public function save()
    {
        $this->taxZone->exists ? $this->update() : $this->store();
    }

    public function update()
    {
        $this->validate([
            'taxZone.name' => 'required|string',
            'selectedCountries' => [
                'array',
                'min:1',
                Rule::unique('App\Models\TaxZoneCountry', 'country_id')->ignore($this->taxZone->id, 'tax_zone_id'),
            ],
        ]);

        $this->taxZone->save();

        $this->taxZone->countries()->delete();

        $this->taxZone->countries()->createMany(
            collect($this->selectedCountries)->map(fn($countryId) => ['tax_zone_id' => $this->taxZone->id, 'country_id' => $countryId])->toArray()
        );

        $this->isShown = false;

        $this->emit('refresh')->up();
    }

    public function store()
    {
        $this->validate();

        $this->taxZone->save();

        $this->taxZone->countries()->createMany(
            collect($this->selectedCountries)->map(fn($countryId) => ['shipping_zone_id' => $this->taxZone->id, 'country_id' => $countryId])->toArray()
        );

        $this->isShown = false;

        $this->emit('refresh')->up();
    }

    public function getCountriesInAnotherZonesProperty(): array
    {
        return TaxZoneCountry::query()->pluck('country_id')->toArray();
    }

    public function render()
    {
        return view('livewire.employee.taxation.components.tax-zone-form');
    }
}
