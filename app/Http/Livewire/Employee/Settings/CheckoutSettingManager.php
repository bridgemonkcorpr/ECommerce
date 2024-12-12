<?php

namespace App\Http\Livewire\Employee\Settings;

use App\Settings\CheckoutSetting;
use Livewire\Component;

class CheckoutSettingManager extends Component
{
    public $state = [
        'requires_login' => false,
    ];

    protected $rules = [
        'state.requires_login' => 'boolean',
    ];

    public function mount()
    {
        $this->state = [
            'requires_login' => $this->checkout_settings->requires_login,
        ];
    }

    public function save()
    {
        $this->validate();

        $this->checkout_settings->fill($this->state);

        $this->checkout_settings->save();

        $this->notify(trans('Settings saved successfully!'));
    }

    public function getCheckoutSettingsProperty()
    {
        return app(CheckoutSetting::class);
    }

    public function render()
    {
        return view('livewire.employee.settings.checkout-setting-manager')->layout('layouts.admin');
    }
}
