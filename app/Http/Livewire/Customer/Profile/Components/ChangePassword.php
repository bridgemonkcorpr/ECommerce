<?php

namespace App\Http\Livewire\Customer\Profile\Components;

use Livewire\Component;
//Code Flow
//Component load hone par current_password, password, aur password_confirmation fields initialize hote hain.
//User form fill karke save() trigger karta hai.
//Validation hone ke baad password securely update hota hai.
//Form reset hota hai aur success notification show hoti hai.
//Use Case Summary
//Users apne existing password ko validate kar sakte hain aur securely naya password set kar sakte hain.
//Custom error messages aur validation rules UI experience ko improve karte hain.
//Success message notify karta hai ki password update ho gaya hai.

//Yeh ChangePassword Livewire component customers ko apne password ko securely change karne ki functionality deta hai. Yeh form validation, error messages, aur password update features handle karta hai.
class ChangePassword extends Component
{
//Password Fields
//Component ke andar $state property password-related fields store karta hai:
//current_password: Pehle se set password.
//password: Naya password.
//password_confirmation: Confirm new password.
    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

//Validation ko dynamic banane ke liye rules() method use hota hai:
//state.current_password
//required: Field blank nahi chhod sakte.
//current_password:customer: Laravel ke inbuilt rule se ensure karta hai ki password correct hai.
//state.password
//required: Field blank nahi chhod sakte.
//confirmed: Password aur confirmation field ka value same hona chahiye.
//min:8: Password minimum 8 characters ka hona chahiye.
    protected function rules()
    {
        return [
            'state.current_password' => ['required', 'current_password:customer'],
            'state.password' => ['required', 'confirmed', 'min:8'],
        ];
    }

//$messages array ke through validation errors ke custom messages define hote hain:
//Agar koi validation fail kare, toh readable aur user-friendly message display hota hai.
    protected $messages = [
        'state.current_password.required' => 'The current password field is required.',
        'state.current_password.current_password' => 'The current password is incorrect.',
        'state.password.required' => 'The password field is required.',
        'state.password.confirmed' => 'The password confirmation does not match.',
        'state.password.min' => 'The password must be at least 8 characters.',
    ];


//save() Method:
//$this->validate():
//Validation ko trigger karta hai.
//$this->user->update():
//Naya password hash karke (via \Hash::make) database mein save karta hai.
//$this->notify():
//Password update hone par success message show karta hai.
//$this->reset():
//Form fields ko reset karta hai.

    public function save()
    {
        $this->validate();

        $this->user->update([
            'password' => \Hash::make($this->state['password']),
        ]);

        $this->notify(trans('Your password has been updated.'));

        $this->reset('state');
    }


//getUserProperty()
//Logged-in user ko fetch karta hai using \Auth::user().
    public function getUserProperty()
    {
        return \Auth::user();
    }


//render() Method:
//View change-password ko render karta hai, jo password change karne ke form ka layout handle karta hoga.

    public function render()
    {
        return view('livewire.customer.profile.components.change-password');
    }
}
