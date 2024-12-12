<?php

namespace App\Http\Livewire\Employee\Order\Components;

use App\Models\Order;
use Livewire\Component;

class OrderCustomerDetail extends Component
{
    public Order $order;

    public function mount()
    {
        $this->order->load([
            'customer:id,name,email,phone',
            'billingAddress.country:id,name',
            'shippingAddress.country:id,name',
        ]);
    }

    public function render()
    {
        return view('livewire.employee.order.components.order-customer-detail');
    }
}
