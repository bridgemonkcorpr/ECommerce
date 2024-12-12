<?php

namespace App\Http\Livewire\Employee\Customer\Components;

use App\Models\Customer;
use Livewire\Component;

class CustomerStatistics extends Component
{
    public Customer $customer;

    public function mount()
    {
        $this->customer->loadMissing(['orders.orderItems', 'orders.orderDiscounts.orderItem'])->loadCount('orders');
    }

    public function render()
    {
        return view('livewire.employee.customer.components.customer-statistics');
    }
}
