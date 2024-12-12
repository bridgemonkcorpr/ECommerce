<?php

namespace App\Http\Livewire\Employee\Order\Components;

use App\Models\Order;
use Livewire\Component;

class OrderNotes extends Component
{
    public Order $order;

    public $isEditing = false;

    protected $rules = [
        'order.notes' => 'nullable|string',
    ];

    public function updatedOrderNotes($value)
    {
        $this->order->notes = $value ?: null;
    }

    public function save()
    {
        $this->validate();

        $this->order->save();

        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.employee.order.components.order-notes');
    }
}
