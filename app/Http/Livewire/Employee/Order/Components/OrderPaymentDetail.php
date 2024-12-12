<?php

namespace App\Http\Livewire\Employee\Order\Components;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;
use Livewire\Component;

class OrderPaymentDetail extends Component
{
    public Order $order;

    public bool $confirmingMarkingAsPaid = false;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount()
    {
        $this->order->load(['orderItems', 'orderDiscounts.orderItem', 'paymentMethod:id,name,is_third_party', 'refunds']);
    }

    public function confirmMarkingPaymentAsPaid()
    {
        $this->confirmingMarkingAsPaid = true;
    }

    public function markAsPaid(): void
    {
        $payment = new Payment([
            'amount' => $this->order->total,
            'currency' => config('app.currency'),
            'method' => $this->order->paymentMethod->name,
            'status' => 'PAID',
        ]);

        $this->order->payments()->save($payment);

        $this->order->payment_status = PaymentStatus::PAID;

        $this->order->save();

        $this->emit('refresh')->self();

        $this->emit('refresh')->up();

        $this->confirmingMarkingAsPaid = false;

        $this->notify(trans('Payment marked as paid.'));
    }

    public function getTotalOrderItemsQuantityProperty()
    {
        return $this->order->orderItems->sum(function ($item) {
            return $item->quantity;
        });
    }

    public function render()
    {
        return view('livewire.employee.order.components.order-payment-detail');
    }
}
