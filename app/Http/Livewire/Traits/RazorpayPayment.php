<?php

namespace App\Http\Livewire\Traits;

use App\Models\PaymentMethod;
use Razorpay\Api\Api;

trait RazorpayPayment
{
    public function createRazorpayOrder()
    {
        $razorpay_api_key = $this->razorpay->meta['api_key'];

        $razorpay_api_secret = $this->razorpay->meta['api_secret'];

        $api = new Api($razorpay_api_key, $razorpay_api_secret);

        $razorpayOrder = $api->order->create([
            'receipt' => $this->order->id,
            'amount' => $this->order->total * 100,
            'currency' => config('app.currency'),
        ]);

        $this->order->update([
            'meta' => [
                'razorpay_order_id' => $razorpayOrder->id,
            ],
        ]);
    }

    public function getRazorpayProperty()
    {
        return PaymentMethod::query()->where('identifier', 'razorpay')->firstOrFail();
    }
}
