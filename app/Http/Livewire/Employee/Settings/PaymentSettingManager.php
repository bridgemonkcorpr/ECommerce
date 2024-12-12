<?php

namespace App\Http\Livewire\Employee\Settings;

use App\Models\PaymentMethod;
use Livewire\Component;

class PaymentSettingManager extends Component
{
    public $stripe_payment_state = [
        'is_enabled' => false,
        'display_name' => '',
        'description' => '',
        'meta' => [
            'public_key' => '',
            'secret_key' => '',
            'webhook_secret' => '',
        ],
    ];

    public $razorpay_payment_state = [
        'is_enabled' => false,
        'display_name' => '',
        'description' => '',
        'meta' => [
            'api_key' => '',
            'api_secret' => '',
            'webhook_secret' => '',
        ],
    ];

    public $cash_on_delivery_state = [
        'is_enabled' => false,
        'display_name' => '',
        'description' => '',
        'instructions' => '',
    ];

    public $bank_deposit_state = [
        'is_enabled' => false,
        'display_name' => '',
        'description' => '',
        'instructions' => '',
    ];

    protected $rules = [
        'stripe_payment_state.is_enabled' => 'boolean',
        'stripe_payment_state.display_name' => 'required|string',
        'stripe_payment_state.description' => 'nullable|string',
        'stripe_payment_state.meta.public_key' => 'required_if:stripe_payment_state.is_enabled,true|string',
        'stripe_payment_state.meta.secret_key' => 'required_if:stripe_payment_state.is_enabled,true|string',
        'stripe_payment_state.meta.webhook_secret' => 'required_if:stripe_payment_state.is_enabled,true|string',
        'razorpay_payment_state.is_enabled' => 'boolean',
        'razorpay_payment_state.display_name' => 'required|string',
        'razorpay_payment_state.description' => 'nullable|string',
        'razorpay_payment_state.meta.api_key' => 'required_if:razorpay_payment_state.is_enabled,true|string',
        'razorpay_payment_state.meta.api_secret' => 'required_if:razorpay_payment_state.is_enabled,true|string',
        'razorpay_payment_state.meta.webhook_secret' => 'required_if:razorpay_payment_state.is_enabled,true|string',
        'cash_on_delivery_state.is_enabled' => 'boolean',
        'cash_on_delivery_state.display_name' => 'required|string',
        'cash_on_delivery_state.description' => 'nullable|string',
        'cash_on_delivery_state.instructions' => 'nullable|string',
        'bank_deposit_state.is_enabled' => 'boolean',
        'bank_deposit_state.display_name' => 'required|string',
        'bank_deposit_state.description' => 'nullable|string',
        'bank_deposit_state.instructions' => 'nullable|string',
    ];

    public function mount()
    {
        $this->stripe_payment_state = $this->stripe_payment->toArray();

        $this->razorpay_payment_state = $this->razorpay_payment->toArray();

        $this->cash_on_delivery_state = $this->cash_payment->toArray();

        $this->bank_deposit_state = $this->bank_deposit->toArray();
    }

    public function save()
    {
        $this->validate();

        $this->stripe_payment->update($this->stripe_payment_state);

        $this->razorpay_payment->update($this->razorpay_payment_state);

        $this->cash_payment->update($this->cash_on_delivery_state);

        $this->bank_deposit->update($this->bank_deposit_state);

        $this->notify('Payment settings saved successfully.');
    }

    public function getStripePaymentProperty()
    {
        return PaymentMethod::query()->firstOrCreate([
            'identifier' => 'stripe',
        ], [
            'name' => 'Stripe',
            'display_name' => 'Stripe',
            'description' => 'Stripe',
            'is_enabled' => false,
            'is_third_party' => true,
            'meta' => [
                'public_key' => '',
                'secret_key' => '',
                'webhook_secret' => '',
            ],
        ]);
    }

    public function getRazorpayPaymentProperty()
    {
        return PaymentMethod::query()->firstOrCreate([
            'identifier' => 'razorpay',
        ], [
            'name' => 'Razorpay',
            'display_name' => 'Razorpay',
            'description' => 'Razorpay',
            'is_enabled' => false,
            'is_third_party' => true,
            'meta' => [
                'api_key' => '',
                'api_secret' => '',
                'webhook_secret' => '',
            ],
        ]);
    }

    public function getCashPaymentProperty()
    {
        return PaymentMethod::where('identifier', 'cash_on_delivery')->first();
    }

    public function getBankDepositProperty()
    {
        return PaymentMethod::where('identifier', 'bank_deposit')->first();
    }

    public function render()
    {
        return view('livewire.employee.settings.payment-setting-manager', [
            'stripe_payment' => $this->stripe_payment,
            'razorpay_payment' => $this->razorpay_payment,
            'cash_payment' => $this->cash_payment,
            'bank_deposit' => $this->bank_deposit,
        ])->layout('layouts.admin');
    }
}
