<?php

namespace App\Http\Livewire\Traits;

use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\URL;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\StripeClient;

trait StripePayment
{
    /**
     * @throws ApiErrorException
     */
    protected function createStripeCustomer()
    {
        $stripeSecretKey = $this->stripe->meta['secret_key'];

        $stripeClient = new StripeClient($stripeSecretKey);

        return $stripeClient->customers->create([
            'email' => $this->order->customer_email,
            'address' => [
                'line1' => $this->order->shippingAddress->address_line_1,
                'line2' => $this->order->shippingAddress->address_line_2,
                'city' => $this->order->shippingAddress->city,
                'state' => $this->order->shippingAddress->state,
                'postal_code' => $this->order->shippingAddress->postcode,
                'country' => $this->order->shippingAddress->country->iso2,
            ],
            'shipping' => [
                'name' => $this->order->shippingAddress->name,
                'phone' => $this->order->shippingAddress->phone,
                'address' => [
                    'line1' => $this->order->shippingAddress->address_line_1,
                    'line2' => $this->order->shippingAddress->address_line_2,
                    'city' => $this->order->shippingAddress->city,
                    'state' => $this->order->shippingAddress->state,
                    'postal_code' => $this->order->shippingAddress->postcode,
                    'country' => $this->order->shippingAddress->country->iso2,
                ],
            ],
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    protected function createStripeTaxRates()
    {
        $stripeSecretKey = $this->stripe->meta['secret_key'];

        $stripeClient = new StripeClient($stripeSecretKey);

        $taxRates = [];

        foreach ($this->availableTaxRates as $taxRate) {
            $taxRates[] = $stripeClient->taxRates->create([
                'display_name' => $taxRate->name,
                'percentage' => $taxRate->percentage,
                'inclusive' => false,
            ]);
        }

        return $taxRates;
    }

    /**
     * @throws ApiErrorException
     */
    protected function buildStripeSession()
    {
        $stripeSecretKey = $this->stripe->meta['secret_key'];

        Stripe::setApiKey($stripeSecretKey);

        $this->order->load([
            'orderItems.discount',
            'orderItems.product.media',
            'orderItems.variant.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
        ]);

        $taxRates = $this->createStripeTaxRates();

        $lineItems = $this->order->orderItems->map(function (OrderItem $orderItem) use ($taxRates) {
            $discountAmount = $orderItem->discount()->exists() ? ($orderItem->discount->type === 'fixed' ? $orderItem->discount->amount : $orderItem->subtotal * $orderItem->discount->amount / 100) : 0;

            $lineItem = [
                'price_data' => [
                    'currency' => config('app.currency'),
                    'product_data' => [
                        'name' => $orderItem->product->name,
                        'images' => [$orderItem->variant->hasMedia('image') ? $orderItem->variant->getFirstMediaUrl('image') : $orderItem->product->getFirstMediaUrl('gallery')],
                    ],
                    'unit_amount' => ($orderItem->price - $discountAmount) * 100,
                ],
                'quantity' => $orderItem->quantity,
                'tax_rates' => [collect($taxRates)->map(fn($taxRate) => $taxRate->id)->toArray()],
            ];

            $variantName = $orderItem->variant->variantAttributes->map(function ($attribute) {
                return $attribute->optionValue->label;
            })->implode(' / ');

            if ($variantName) {
                data_set($lineItem, 'price_data.product_data.description', $variantName);
            }

            return $lineItem;
        })->toArray();

        $session = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'line_items' => $lineItems,
            'shipping_options' => [
                [
                    'shipping_rate_data' => [
                        'type' => 'fixed_amount',
                        'fixed_amount' => ['amount' => $this->order->shipping_price * 100, 'currency' => \Str::lower(config('app.currency'))],
                        'display_name' => $this->order->shipping_rate,
                    ],
                ],
            ],
            'billing_address_collection' => 'auto', // TODO add a setting to enable/disable this
            'cancel_url' => $this->customer ? route('customer.orders.detail', $this->order) : URL::signedRoute('guest.orders.detail', $this->order),
            'success_url' => $this->customer ? route('customer.orders.detail', $this->order) : URL::signedRoute('guest.orders.detail', $this->order),
            'client_reference_id' => $this->order->id,
        ]);

        $this->order->meta = array_merge($this->order->meta, ['stripe_session_id' => $session->id]);

        $this->order->save();
        
        return redirect()->to($session->url);
    }

    public function getStripeProperty(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return PaymentMethod::query()->where('identifier', 'stripe')->firstOrFail();
    }
}
