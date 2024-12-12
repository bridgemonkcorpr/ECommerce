<?php

namespace App\Http\Livewire\Employee\Taxation\Components;

use App\Models\TaxZone;
use App\Models\TaxZoneRate;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TaxRateForm extends Component
{
    public TaxZoneRate $taxRate;

    public $isShown = false;

    protected $listeners = ['create', 'edit', 'delete'];

    protected function rules()
    {
        return [
            'taxRate.tax_zone_id' => 'required|exists:tax_zones,id',
            'taxRate.name' => 'required|string',
            'taxRate.percentage' => 'required|numeric',
            'taxRate.priority' => ['required', 'integer', Rule::unique('App\Models\TaxZoneRate', 'priority')->where(fn($query) => $query->where('tax_zone_id', $this->taxRate->tax_zone_id))],
        ];
    }

    public function mount()
    {
        $this->taxRate = new TaxZoneRate();
    }

    public function create(TaxZone $taxZone)
    {
        $this->resetErrorBag();

        $this->taxRate = new TaxZoneRate();

        $this->taxRate->zone()->associate($taxZone);

        $this->isShown = true;
    }

    public function edit(TaxZoneRate $taxRate)
    {
        $this->resetErrorBag();

        $this->taxRate = $taxRate;

        $this->isShown = true;
    }

    public function save()
    {
        $this->validate();

        $this->taxRate->save();

        $this->isShown = false;

        $this->emit('refresh')->up();
    }

    public function render()
    {
        return view('livewire.employee.taxation.components.tax-rate-form');
    }
}
