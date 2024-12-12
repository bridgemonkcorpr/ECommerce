<?php

namespace App\Http\Livewire\Employee\Customer\Components;

use App\Models\Customer;
use Livewire\Component;

class CustomerLatestOrder extends Component
{
    public Customer $customer;

    public function mount()
    {
        $this->customer->loadMissing([
            'orders.orderItems',
            'orders.orderDiscounts',
            'orders.orderItems.variant.media',
            'orders.orderItems.variant.product.media',
            'orders.orderItems.variant.variantAttributes.option',
            'orders.orderItems.variant.variantAttributes.optionValue',
        ]);
    }

    public function render()
    {
        return view('livewire.employee.customer.components.customer-latest-order');
    }
}
