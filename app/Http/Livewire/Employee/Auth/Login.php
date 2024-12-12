<?php

namespace App\Http\Livewire\Employee\Auth;

use App\Providers\RouteServiceProvider;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    use SEOTools;

    public $email;

    public $password;

    public $remember_me = false;

    protected $rules = [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
        'remember_me' => ['sometimes', 'bool'],
    ];

    public function mount()
    {
        $this->seo()->setTitle(trans('Admin Login'));

        $this->seo()->setDescription(trans('Access powerful features to handle product management, inventory control, order processing, and customer data.'));

        $this->seo()->opengraph()->addImage(asset('/img/fingerprint.png'), [
            'height' => 200,
            'width' => 200,
            'type' => 'image/png'
        ]);
    }

    public function submit()
    {
        $this->validate();

        if (!Auth::guard('employee')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember_me)) {
            $this->dispatchBrowserEvent('login-error');
            return $this->addError('email', trans('auth.failed'));
        }

        $this->redirect(RouteServiceProvider::EMPLOYEE_HOME);
    }

    public function render()
    {
        return view('livewire.employee.auth.login')->layout('layouts.blank');
    }
}
