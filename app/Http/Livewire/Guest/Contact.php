<?php

namespace App\Http\Livewire\Guest;

use App\Mail\StoreContact;
use App\Settings\GeneralSetting;
use Livewire\Component;
use Mail;

class Contact extends Component
{
    public $state = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'message' => '',
    ];

    protected $rules = [
        'state.name' => 'required|string',
        'state.email' => 'required|email',
        'state.phone' => 'required|string',
        'state.message' => 'required|string',
    ];

    public function sendMessage()
    {
        $this->validate();

        if (!$this->general_settings->contact_email) {
            $this->notify(trans('The store owner is not configured to receive contact messages'));

            return;
        }

        Mail::to($this->general_settings->contact_email)
            ->send(new StoreContact(
                $this->state['name'],
                $this->state['email'],
                $this->state['phone'],
                $this->state['message'],
            ));

        $this->reset('state');

        $this->notify(trans('Your message has been sent successfully'));
    }

    public function getGeneralSettingsProperty()
    {
        return app(GeneralSetting::class);
    }

    public function render()
    {
        return view('livewire.guest.contact');
    }
}
