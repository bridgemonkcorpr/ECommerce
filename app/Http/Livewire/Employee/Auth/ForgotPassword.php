<?php

namespace App\Http\Livewire\Employee\Auth;

use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPassword extends Component
{
    use SEOTools;

    public $email;

    protected $rules = [
        'email' => ['required', 'string', 'email'],
    ];

    public function mount()
    {
        $this->seo()->setTitle(trans('Recover Your Password'));

        $this->seo()->setDescription(trans('Forgot your password? No worries! Easily reset your password for our ecommerce platform. Regain access to your account and continue managing your online store seamlessly.'));

        $this->seo()->opengraph()->addImage(asset('/img/fingerprint.png'), [
            'height' => 200,
            'width' => 200,
            'type' => 'image/png'
        ]);
    }

    public function submit()
    {
        $this->validate();

        $status = Password::broker('employees')->sendResetLink(['email' => $this->email]);

        $status === Password::RESET_LINK_SENT
            ? session()->flash('status', trans($status))
            : $this->addError('email', trans($status));
    }

    public function render()
    {
        return view('livewire.employee.auth.forgot-password')->layout('layouts.blank');
    }
}
