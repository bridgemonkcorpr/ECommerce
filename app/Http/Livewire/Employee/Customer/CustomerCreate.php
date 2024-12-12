<?php

namespace App\Http\Livewire\Employee\Customer;

use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CustomerCreate extends Component
{
    public Customer $customer;

    public Address $address;

    public $countries = [];

    public $customer_country;

    public $customer_phone;

    public $customer_phone_country;

    public $customer_password;

    public $customer_password_confirmation;

    public $address_country;

    public $address_phone;

    public $address_phone_country;

    protected function rules()
    {
        return [
            'customer.name' => ['required', 'string'],
            'customer.email' => ['required', 'email', 'unique:customers,email'],
            'customer_password' => ['required', 'string', 'min:8', 'confirmed'],
            'customer_phone' => ['nullable', Rule::phone()->countryField('phone_country')],
            'customer_phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
            'customer.notes' => ['nullable', 'string'],
            'address.country_id' => ['required', 'exists:countries,id'],
            'address.name' => ['required', 'string', 'max:255'],
            'address.company_name' => ['nullable', 'string', 'max:255'],
            'address.address_line_1' => ['required', 'string', 'max:255'],
            'address.address_line_2' => ['nullable', 'string', 'max:255'],
            'address.city' => ['required', 'string', 'max:255'],
            'address.state' => ['nullable', 'string', 'max:255'],
            'address.postcode' => ['nullable', 'string', 'max:255'],
            'address_phone' => ['nullable', Rule::phone()->countryField('phone_country')],
            'address_phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
            'address.is_default' => ['boolean'],
        ];
    }

    public function mount()
    {
        $this->customer = new Customer();

        $this->address = new Address(['is_default' => true]);

        $this->countries = Country::query()->select(['id', 'name', 'iso2', 'phonecode', 'emoji'])->orderBy('name')->get();

        $this->selectCustomerCountry($this->countries->where('iso2', 'US')->first()->iso2);

        $this->selectAddressCountry($this->countries->where('iso2', 'US')->first()->iso2);
    }

    public function selectCustomerCountry($value)
    {
        $this->customer_country = $this->countries->where('iso2', $value)->first();

        $this->customer_phone = '+' . $this->customer_country->phonecode;

        $this->customer_phone_country = $value;
    }

    public function selectAddressCountry($value)
    {
        $this->address_country = $this->countries->where('iso2', $value)->first();

        $this->address_phone = '+' . $this->address_country->phonecode;

        $this->address_phone_country = $value;
    }

    public function updatedAddressCountryId($value)
    {
        $this->selectAddressCountry($this->countries->where('id', $value)->first()->iso2);
    }

    public function save()
    {
        $this->validate();

        $this->customer->password = bcrypt($this->customer_password);

        $this->customer->phone_country = $this->customer_phone_country;

        $this->customer->phone = $this->customer_phone;

        $this->customer->save();

        $this->address->phone_country = $this->address_phone_country;

        $this->address->phone = $this->address_phone;

        $this->address->addressable()->associate($this->customer);

        $this->address->save();

        $this->redirect(route('employee.customers.detail', $this->customer));
    }

    public function render()
    {
        return view('livewire.employee.customer.customer-create')->layout('layouts.admin');
    }
}
