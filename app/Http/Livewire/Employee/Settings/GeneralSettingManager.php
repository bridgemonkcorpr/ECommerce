<?php

namespace App\Http\Livewire\Employee\Settings;

use App\Settings\GeneralSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class GeneralSettingManager extends Component
{
    use WithFileUploads;

    public $logo_file;

    public $favicon_file;

    public array $state = [
        'store_name' => '',
        'contact_email' => '',
        'contact_phone' => '',
        'cookie_consent_enabled' => false,
        'cookie_consent_message' => '',
        'cookie_consent_agree' => '',
        'cookie_consent_reject' => '',
    ];

    protected $rules = [
        'state.store_name' => 'required',
        'state.contact_email' => 'nullable|email',
        'state.contact_phone' => 'nullable',
        'state.cookie_consent_enabled' => 'boolean',
        'state.cookie_consent_message' => 'nullable',
        'state.cookie_consent_agree' => 'required_if:state.cookie_consent_enabled,true',
        'state.cookie_consent_reject' => 'required_if:state.cookie_consent_enabled,true',
    ];

    public function mount()
    {
        $this->state = [
            'store_name' => $this->general_settings->store_name,
            'contact_email' => $this->general_settings->contact_email,
            'contact_phone' => $this->general_settings->contact_phone,
            'cookie_consent_enabled' => $this->general_settings->cookie_consent_enabled,
            'cookie_consent_message' => $this->general_settings->cookie_consent_message,
            'cookie_consent_agree' => $this->general_settings->cookie_consent_agree,
            'cookie_consent_reject' => $this->general_settings->cookie_consent_reject,
        ];
    }

    public function save()
    {
        $this->validate();

        $this->general_settings->fill($this->state);

        $this->general_settings->save();

        $this->notify(trans('Settings saved successfully!'));
    }

    public function getGeneralSettingsProperty()
    {
        return app(GeneralSetting::class);
    }

    public function render()
    {
        return view('livewire.employee.settings.general-setting-manager')->layout('layouts.admin');
    }
}
