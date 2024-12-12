<?php

namespace App\Http\Livewire\Employee\Auth;

use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;
use Illuminate\Validation\Rules;

class ResetPassword extends Component
{
    use SEOTools;

    public $token;

    public $email;

    public $password;

    public $password_confirmation;

    protected $queryString = ['email'];

    protected function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    public function mount($token)
    {
        $this->token = $token;

        $this->seo()->setTitle(trans('Reset Your Password'));

        $this->seo()->setDescription(trans('Securely regain access to your account and resume managing your online store effortlessly. Our password reset offers a seamless and user-friendly process to help you regain control over your account.'));

        $this->seo()->opengraph()->addImage(asset('/img/fingerprint.png'), [
            'height' => 200,
            'width' => 200,
            'type' => 'image/png'
        ]);
    }

    public function submit()
    {
        $this->validate();

        $status = Password::broker('employees')
            ->reset([
                'token' => $this->token,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ], function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            });

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('employee.login')->with('status', trans($status))
            : $this->addError('email', trans($status));
    }

    public function render()
    {
        return view('livewire.employee.auth.reset-password')->layout('layouts.blank');
    }
}
