<?php

namespace App\Http\Livewire\Employee\Customer\Components;

use App\Models\Country;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CustomerInformation extends Component
{
    public Customer $customer;

    public Country $country;

    public $countries = [];

    public $phone;

    public $phone_country;

    public bool $isEditing = false;

    protected function rules()
    {
        return [
            'customer.name' => ['required', 'string'],
            'customer.email' => ['required', 'email'],
            'phone' => ['nullable', Rule::phone()->countryField('phone_country')],
            'phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
        ];
    }

    public function mount()
    {
        $this->country = $this->customer->phone_country ? Country::where('iso2', $this->customer->phone_country)->first() : Country::where('iso2', 'US')->first();

        $this->phone = $this->customer->phone ? $this->customer->phone->formatE164() : '+' . $this->country->phonecode;
    }

    public function selectCountry($value)
    {
        $this->country = $this->countries->where('iso2', $value)->first();

        $this->phone = '+' . $this->country->phonecode;

        $this->phone_country = $value;
    }

    public function edit()
    {
        $this->countries = Country::query()->select(['id', 'name', 'iso2', 'phonecode', 'emoji'])->orderBy('name')->get();

        $this->isEditing = true;
    }

    public function save()
    {
        $this->validate();

        // attribute phone_country must be filled first
        // otherwise E164PhoneNumberCast will encounter an
        // empty country value and throw an unexpected exception
        $this->customer->phone_country = $this->phone_country;

        $this->customer->phone = $this->phone;

        $this->customer->save();

        $this->isEditing = false;

        $this->emitUp('refresh');
    }

    public function render()
    {
        return view('livewire.employee.customer.components.customer-information');
    }
}
