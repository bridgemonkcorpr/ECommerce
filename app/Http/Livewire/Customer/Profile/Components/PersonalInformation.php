<?php

namespace App\Http\Livewire\Customer\Profile\Components;

use Illuminate\Validation\Rule;
use Livewire\Component;

//Code Flow
//Component mount hone par user ke current name aur email ko $state mein initialize karta hai.
//User ne form fill karne ke baad save() method call kiya:
//Validation check hota hai.
//Valid hone par name aur email database mein update hote hain.
//Success message display hota hai using notify().
//Use Case Summary
//Logged-in users apne name aur email ko update kar sakte hain.
//Validation aur error messages ensure karte hain ki input accurate aur user-friendly ho.
//Yeh PersonalInformation Livewire component customer ko unki personal details (name aur email) ko view aur update karne ki functionality provide karta hai.
class PersonalInformation extends Component
{
//Component ke andar $state property name aur email ke fields ko store karta hai:
    public $state = [
        'name' => '',
        'email' => '',
    ];
//$messages property ke through user-friendly error messages define kiye gaye hain:
    protected $messages = [
        'state.name.required' => 'The name field is required.',
        'state.email.required' => 'The email field is required.',
        'state.email.email' => 'The email must be a valid email address.',
        'state.email.unique' => 'The email has already been taken.',
    ];
//mount() Method:
//Logged-in user ke name aur email ko fetch karke $state mein set karta hai:
    public function mount()
    {
        $this->state = [
            'name' => $this->user->name,
            'email' => $this->user->email,
        ];
    }

    public function save()
    {
        //Validation dynamically apply hoti hai inside save() method
//state.name
//required: Name field blank nahi chhod sakte.
//state.email
//required: Email field blank nahi chhod sakte.
//email: Valid email format check karega.
//unique: Email unique hona chahiye except for the current user (ignore($this->user->id)).
        $this->validate([
            'state.name' => ['required'],
            'state.email' => ['required', 'email', Rule::unique('customers', 'email')->ignore($this->user->id)],
        ]);
//        save() Method:
//$this->validate():
//Form validation trigger karta hai.
//    $this->user->update():
//Name aur email ko database mein update karta hai:
        $this->user->update([
            'name' => $this->state['name'],
            'email' => $this->state['email'],
        ]);
//        $this->notify():
//Success message show karta hai to confirm the update.
        $this->notify(trans('Your profile has been updated.'));
    }
//getUserProperty()
//Logged-in user ka data fetch karta hai:
    public function getUserProperty()
    {
        return \Auth::user();
    }
//render() Method:
//View personal-information ko render karta hai, jo user ka profile update form handle karega:
    public function render()
    {
        return view('livewire.customer.profile.components.personal-information');
    }
}
