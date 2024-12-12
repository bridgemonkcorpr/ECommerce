<?php

namespace App\Http\Livewire\Employee\Order;

use App\Models\Order;
use Livewire\Component;

class OrderDetail extends Component
{
    public Order $order;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->order->loadCount([
            'shipments',
            'refunds',
            'refundItems' => fn($query) => $query->where('is_shipped', false),
        ]);
    }

    public function render()
    {
        return view('livewire.employee.order.order-detail')->layout('layouts.admin');
    }
}
