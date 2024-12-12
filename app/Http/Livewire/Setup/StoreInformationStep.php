<?php

namespace App\Http\Livewire\Setup;

use App\Settings\BrandSetting;
use App\Settings\GeneralSetting;
use Spatie\LivewireWizard\Components\StepComponent;

class StoreInformationStep extends StepComponent
{
    public $state = [
        'store_name' => '',
        'store_slogan' => '',
        'store_contact_email' => '',
        'store_contact_phone' => '',
    ];

    protected function rules()
    {
        return [
            'state.store_name' => 'required|string',
            'state.store_slogan' => 'nullable|string',
            'state.store_contact_email' => 'nullable|email',
            'state.store_contact_phone' => 'nullable|string',
        ];
    }

    protected function messages()
    {
        return [
            'state.store_name.required' => 'Store name is required.',
            'state.store_name.string' => 'Store name must be a string.',
            'state.store_slogan.string' => 'Store slogan must be a string.',
            'state.store_contact_email.email' => 'Store contact email must be a valid email address.',
            'state.store_contact_phone.string' => 'Store contact phone must be a string.',
        ];
    }

    public function mount()
    {
        $this->state['store_name'] = $this->general_settings->store_name;

        $this->state['store_slogan'] = $this->brand_settings->slogan;

        $this->state['store_contact_email'] = $this->general_settings->contact_email;

        $this->state['store_contact_phone'] = $this->general_settings->contact_phone;
    }

    public function save()
    {
        $this->validate();
        
        $this->nextStep();
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
        return view('livewire.setup.store-information-step');
    }
}
