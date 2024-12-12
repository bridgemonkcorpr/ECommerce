<?php

namespace App\Http\Livewire\Employee\Taxation;

use App\Models\TaxZone;
use App\Models\TaxZoneRate;
use Livewire\Component;

class TaxManager extends Component
{
    public $confirmingTaxZoneDeletion = false;

    public $taxZoneBeingDeleted;

    public $confirmingTaxRateDeletion = false;

    public $taxRateBeingDeleted;

    protected $listeners = ['refresh' => '$refresh'];

    public function confirmTaxZoneDeletion($shippingZoneId)
    {
        $this->confirmingTaxZoneDeletion = true;

        $this->taxZoneBeingDeleted = $shippingZoneId;
    }

    public function deleteTaxZone()
    {
        $this->taxZones->where('id', $this->taxZoneBeingDeleted)->first()->delete();

        $this->confirmingTaxZoneDeletion = false;

        $this->emitSelf('refresh');
    }

    public function confirmTaxRateDeletion($taxRateId)
    {
        $this->confirmingTaxRateDeletion = true;

        $this->taxRateBeingDeleted = $taxRateId;
    }

    public function deleteTaxRate()
    {
        TaxZoneRate::query()->where('id', $this->taxRateBeingDeleted)->delete();

        $this->confirmingTaxRateDeletion = false;

        $this->emitSelf('refresh');
    }

    public function getTaxZonesProperty()
    {
        return TaxZone::with('countries.country', 'rates.zone')->get();
    }

    public function render()
    {
        return view('livewire.employee.taxation.tax-manager')->layout('layouts.admin');
    }
}
