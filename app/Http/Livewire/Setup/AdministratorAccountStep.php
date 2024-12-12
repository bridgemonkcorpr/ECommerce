<?php

namespace App\Http\Livewire\Setup;

use Spatie\LivewireWizard\Components\StepComponent;

class AdministratorAccountStep extends StepComponent
{
    public $state = [
        'administrator_name' => '',
        'administrator_email' => '',
        'administrator_password' => '',
        'administrator_password_confirmation' => '',
    ];

    protected function rules()
    {
        return [
            'state.administrator_name' => 'required|string',
            'state.administrator_email' => 'required|email',
            'state.administrator_password' => 'required|min:8|confirmed',
        ];
    }

    protected function messages()
    {
        return [
            'state.administrator_name.required' => 'Administrator name is required.',
            'state.administrator_name.string' => 'Administrator name must be a string.',
            'state.administrator_email.required' => 'Administrator email is required.',
            'state.administrator_email.email' => 'Administrator email must be a valid email address.',
            'state.administrator_password.required' => 'Administrator password is required.',
            'state.administrator_password.min' => 'Administrator password must be at least 8 characters.',
            'state.administrator_password.confirmed' => 'Administrator password confirmation does not match.',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->nextStep();
    }

    public function render()
    {
        return view('livewire.setup.administrator-account-step');
    }
}
