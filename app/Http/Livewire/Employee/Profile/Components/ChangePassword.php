<?php

namespace App\Http\Livewire\Employee\Profile\Components;

use Livewire\Component;

class ChangePassword extends Component
{
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    protected function rules()
    {
        return [
            'state.current_password' => ['required', 'current_password:employee'],
            'state.password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    protected $messages = [
        'state.current_password.required' => 'The current password field is required.',
        'state.current_password.current_password' => 'The current password is incorrect.',
        'state.password.required' => 'The password field is required.',
        'state.password.confirmed' => 'The password confirmation does not match.',
        'state.password.min' => 'The password must be at least 8 characters.',
    ];

    public function save()
    {
        $this->validate();

        $this->user->update([
            'password' => \Hash::make($this->state['password']),
        ]);

        $this->notify(trans('Your password has been updated.'));

        $this->reset('state');
    }

    public function getUserProperty()
    {
        return \Auth::user();
    }

    public function render()
    {
        return view('livewire.employee.profile.components.change-password');
    }
}
