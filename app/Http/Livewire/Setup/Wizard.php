<?php

namespace App\Http\Livewire\Setup;

use Spatie\LivewireWizard\Components\WizardComponent;

class Wizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            // LicenseActivationStep::class,
            StoreInformationStep::class,
            AdministratorAccountStep::class,
            FinalizationStep::class,
        ];
    }
}
