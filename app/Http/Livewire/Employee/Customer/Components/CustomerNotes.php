<?php

namespace App\Http\Livewire\Employee\Customer\Components;

use App\Models\Customer;
use Livewire\Component;

class CustomerNotes extends Component
{
    public Customer $customer;

    public bool $isEditing = false;

    protected $rules = [
        'customer.notes' => 'nullable|string',
    ];

    public function updatedCustomerNotes($value)
    {
        if (! $value) $this->customer->notes = null;
    }

    public function save()
    {
        $this->validate();

        $this->customer->save();

        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.employee.customer.components.customer-notes');
    }
}
