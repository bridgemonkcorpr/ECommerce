<?php

namespace App\Http\Livewire\Setup;

use App\Models\Employee;
use App\Settings\BrandSetting;
use App\Settings\GeneralSetting;
use Spatie\LivewireWizard\Components\StepComponent;

class FinalizationStep extends StepComponent
{
    public $completed = false;

    public function save()
    {
        $this->setupAdminAccount();

        $this->setupStoreInformation();

        $this->completed = true;
    }

    public function setupStoreInformation()
    {
        $this->brand_settings->slogan = $this->store_information_state['store_slogan'];

        $this->brand_settings->save();

        $this->general_settings->store_name = $this->store_information_state['store_name'];

        $this->general_settings->contact_email = $this->store_information_state['store_contact_email'];

        $this->general_settings->contact_phone = $this->store_information_state['store_contact_phone'];

        $this->general_settings->setup_finished = true;

        $this->general_settings->save();
    }

    public function setupAdminAccount()
    {
        $employee = Employee::query()
            ->firstOrCreate([
                'email' => $this->administrator_account_state['administrator_email']
            ], [
                'name' => $this->administrator_account_state['administrator_name'],
                'password' => bcrypt($this->administrator_account_state['administrator_password']),
            ]);

        $employee->email_verified_at = now();

        $employee->is_admin = true;

        $employee->save();

        auth('employee')->loginUsingId($employee->id);
    }

    public function getStoreInformationStateProperty()
    {
        return $this->state()->forStep('setup.store-information')['state'];
    }

    public function getAdministratorAccountStateProperty()
    {
        return $this->state()->forStep('setup.administrator-account')['state'];
    }

    public function getGeneralSettingsProperty()
    {
        return app(GeneralSetting::class);
    }

    public function getBrandSettingsProperty()
    {
        return app(BrandSetting::class);
    }

    public function render()
    {
        return view('livewire.setup.finalization-step');
    }
}
