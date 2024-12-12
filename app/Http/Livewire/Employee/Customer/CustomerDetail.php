<?php

namespace App\Http\Livewire\Employee\Customer;

use App\Models\Customer;
use Livewire\Component;

class CustomerDetail extends Component
{
    public Customer $customer;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->customer->loadCount('orders');
    }

    public function render()
    {
        return view('livewire.employee.customer.customer-detail')->layout('layouts.admin');
    }
}
