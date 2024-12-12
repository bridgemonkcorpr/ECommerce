<?php

namespace App\Http\Livewire\Employee\Customer\Components;

use App\Models\Address;
use App\Models\Country;
use App\Models\Customer;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CustomerAddress extends Component
{
    public Customer $customer;

    public $addresses = [];

    public Address $address;

    public $countries = [];

    public Country $selectedCountry;

    public $phone;

    public $phone_country;

    public bool $showAddressForm = false;

    public bool $showAddressesManageModal = false;

    protected $listeners = ['refresh' => '$refresh'];

    protected function rules()
    {
        return [
            'address.country_id' => 'required|exists:countries,id',
            'address.name' => 'required|string|max:255',
            'address.company_name' => 'nullable|string|max:255',
            'address.address_line_1' => 'required|string|max:255',
            'address.address_line_2' => 'nullable|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'nullable|string|max:255',
            'address.postcode' => 'nullable|string|max:255',
            'phone' => ['nullable', Rule::phone()->countryField('phone_country')],
            'phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
        ];
    }

    public function mount()
    {
        $this->address = new Address();
    }

    public function manageAddresses()
    {
        $this->addresses = $this->customer->addresses->sortByDesc('is_default');

        $this->showAddressesManageModal = true;
    }

    public function updatedAddressCountryId($value)
    {
        $this->selectCountry($this->countries->where('id', $value)->first()->iso2);
    }

    public function selectCountry($value)
    {
        $this->selectedCountry = $this->countries->where('iso2', $value)->first();

        $this->phone = '+' . $this->selectedCountry->phonecode;

        $this->phone_country = $value;
    }

    public function setDefaultAddress($addressId)
    {
        $this->customer->addresses->each(function ($address) use ($addressId) {
            $address->is_default = $address->id == $addressId;
            $address->save();
        });

        $this->addresses = $this->customer->addresses->sortByDesc('is_default');
    }

    public function create()
    {
        $this->address = new Address();

        $this->countries = Country::query()->select(['id', 'name', 'iso2', 'phonecode', 'emoji'])->orderBy('name')->get();

        $this->selectCountry($this->countries->where('iso2', 'US')->first()->iso2);

        $this->showAddressForm = true;
    }

    public function edit($addressId)
    {
        $this->address = Address::findOrFail($addressId);

        $this->countries = Country::query()->select(['id', 'name', 'iso2', 'phonecode', 'emoji'])->orderBy('name')->get();

        $this->selectCountry($this->address->country->iso2);

        if ($this->showAddressesManageModal) $this->showAddressesManageModal = false;

        $this->showAddressForm = true;
    }

    public function save()
    {
        $this->validate();

        $this->address->phone_country = $this->phone_country;

        $this->address->phone = $this->phone;

        if (!$this->customer->addresses->count()) $this->address->is_default = true;

        $this->address->addressable()->associate($this->customer);

        $this->address->save();

        $this->showAddressForm = false;

        $this->emit('refresh');
    }

    public function render()
    {
        return view('livewire.employee.customer.components.customer-address');
    }
}
