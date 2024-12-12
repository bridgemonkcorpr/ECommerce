<?php

namespace App\Http\Livewire\Guest;

use App\Enums\PaymentStatus;
use App\Events\OrderCreated;
use App\Http\Livewire\Traits\RazorpayPayment;
use App\Http\Livewire\Traits\StripePayment;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingZone;
use App\Models\ShippingZoneCountry;
use App\Models\ShippingZoneRate;
use App\Models\TaxZone;
use App\Models\TaxZoneRate;
use App\Settings\CheckoutSetting;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Checkout extends Component
{
    use SEOTools;

    use StripePayment;

    use RazorpayPayment;

    public Order $order;

    public $discountCode;

    public $discountTotal = 0;

    public $showDiscountForm = false;

    public Address $billingAddress;

    public $billing_phone;

    public $billing_phone_country;

    public Address $shippingAddress;

    public $shipping_phone;

    public $shipping_phone_country;

    public $shippingMethod;

    public $isBillingSameAsShipping = true;

    public $paymentMethod;

    protected $listeners = ['refresh' => '$refresh'];

    protected function rules(): array
    {
        return [
            'billingAddress.name' => [Rule::requiredIf(! $this->isBillingSameAsShipping), 'string'],
            'billingAddress.company_name' => ['nullable', 'string'],
            'billingAddress.address_line_1' => [Rule::requiredIf(! $this->isBillingSameAsShipping), 'string'],
            'billingAddress.address_line_2' => ['nullable', 'string'],
            'billingAddress.city' => [Rule::requiredIf(! $this->isBillingSameAsShipping), 'string'],
            'billingAddress.state' => ['nullable', 'string'],
            'billingAddress.postcode' => ['nullable', 'string'],
            'billing_phone' => ['nullable', Rule::phone()->country('billing_phone_country')],
            'billing_phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
            'billingAddress.is_billing' => [Rule::requiredIf(! $this->isBillingSameAsShipping), 'boolean'],
            'billingAddress.country_id' => [Rule::requiredIf(! $this->isBillingSameAsShipping), 'exists:countries,id'],
            'shippingAddress.name' => ['required', 'string'],
            'shippingAddress.company_name' => ['nullable', 'string'],
            'shippingAddress.address_line_1' => ['required', 'string'],
            'shippingAddress.address_line_2' => ['nullable', 'string'],
            'shippingAddress.city' => ['required', 'string'],
            'shippingAddress.state' => ['nullable', 'string'],
            'shippingAddress.postcode' => ['nullable', 'string'],
            'shipping_phone' => ['nullable', Rule::phone()->country('shipping_phone_country')],
            'shipping_phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
            'shippingAddress.country_id' => ['required', 'exists:countries,id'],
            'shippingMethod' => ['required', 'exists:shipping_zone_rates,id'],
            'paymentMethod' => ['required', 'exists:payment_methods,identifier'],
            'order.customer_email' => ['required', 'email'],
            'order.shipping_rate' => ['required', 'string'],
            'order.shipping_price' => ['required', 'numeric'],
            'order.notes' => ['nullable', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'cartItems.*.quantity.required' => __('Quantity is required'),
            'cartItems.*.quantity.numeric' => __('Quantity must be a number'),
            'cartItems.*.quantity.min' => __('Quantity must be at least 1'),
            'billingAddress.name.required' => __('Please enter your name'),
            'billingAddress.name.string' => __('Name must be a string'),
            'billingAddress.company_name.string' => __('Company name must be a string'),
            'billingAddress.address_line_1.required' => __('Please enter your address'),
            'billingAddress.address_line_1.string' => __('Address must be a string'),
            'billingAddress.address_line_2.string' => __('Apartment, suite must be a string'),
            'billingAddress.city.required' => __('Please enter your city'),
            'billingAddress.city.string' => __('City must be a string'),
            'billingAddress.state.string' => __('State must be a string'),
            'billingAddress.postcode.string' => __('Postcode must be a string'),
            'shippingAddress.name.required' => __('Please enter your name'),
            'shippingAddress.name.string' => __('Name must be a string'),
            'shippingAddress.company_name.string' => __('Company name must be a string'),
            'shippingAddress.address_line_1.required' => __('Please enter your address'),
            'shippingAddress.address_line_1.string' => __('Address must be a string'),
            'shippingAddress.address_line_2.string' => __('Apartment, suite must be a string'),
            'shippingAddress.city.required' => __('Please enter your city'),
            'shippingAddress.city.string' => __('City must be a string'),
            'shippingAddress.state.string' => __('State must be a string'),
            'shippingAddress.postcode.string' => __('Postcode must be a string'),
            'shippingMethod.required' => __('Please select a shipping method'),
            'paymentMethod.required' => __('Please select a payment method'),
            'order.customer_email' => __('Please enter your email address'),
        ];
    }

    public function mount()
    {
        if ($this->cartItems->isEmpty()) return redirect()->route('guest.welcome');

        if ($this->checkout_settings->requires_login && ! auth()->check()) {
            return redirect()->route('login');
        }

        $this->order = new Order(['customer_email' => $this->customer?->email]);

        $this->discountTotal = $this->cartItems->reduce(function ($carry, $item) {
            return $carry + $item->discounted_amount;
        }, 0);

        $this->billingAddress = new Address([
            'is_billing' => true,
        ]);

        $this->shippingAddress = new Address([
            'country_id' => $this->availableShippingCountries->first()->country->id,
        ]);

        if ($this->customer && $this->customer->defaultAddress()) {
            $this->shippingAddress = $this->customer->defaultAddress()->replicate();

            $this->shipping_phone_country = $this->customer->defaultAddress()->country->iso2;

            $this->shipping_phone = (string)$this->customer->defaultAddress()->phone;
        }

        $this->seo()->setTitle(trans('Checkout'));
    }

    public function updateBillingCountry(Country $countryId)
    {
        $this->billing_phone_country = $countryId->iso2;
    }

    public function updateShippingCountry(Country $countryId)
    {
        $this->shipping_phone_country = $countryId->iso2;
    }

    public function updatedShippingMethod($value)
    {
        $this->order->shipping_rate = $this->availableShippingRates->find($value)->name;

        $this->order->shipping_price = $this->availableShippingRates->find($value)->price;
    }

    public function applyDiscount()
    {
        $this->validateOnly('discountCode', [
            'discountCode' => ['required', 'exists:discounts,code'],
        ]);

        $discount = Discount::query()
            ->with(['collections.products', 'products'])
            ->where('code', $this->discountCode)
            ->first();

        if ($this->cart->discounts->pluck('discount_id')->contains($discount->id)) {
            return $this->addError('discountCode', __('Discount code is already applied'));
        }

        if ($discount->status != 'active') {
            return $this->addError('discountCode', __('Discount code is used or expired'));
        }

        $discountedProducts = $discount->applies_to == 'products' ? $discount->products->toArray() : $discount->collections->pluck('products')->flatten()->toArray();

        foreach ($this->cartItems as $item) {
            if (collect($discountedProducts)->contains('id', $item->product_id)) {
                $item->discount()->delete();

                $item->discount()->create([
                    'cart_id' => $item->cart_id,
                    'discount_id' => $discount->id,
                    'code' => $discount->code,
                    'type' => $discount->type,
                    'amount' => $discount->value,
                ]);
            }
        }

        $this->reset('discountCode');

        $this->showDiscountForm = false;

        $this->calculateDiscount();

        $this->emitSelf('refresh');
    }

    public function removeDiscount($discountCode)
    {
        $this->cart->discounts()->where('code', $discountCode)->delete();

        $this->calculateDiscount();

        $this->emitSelf('refresh');
    }

    public function calculateDiscount()
    {
        $this->reset('discountTotal');

        $this->cart->load([
            'discounts',
            'items.discount',
            'items.product.media',
            'items.variant.media',
            'items.variant.variantAttributes.option',
            'items.variant.variantAttributes.optionValue',
        ]);

        $discounts = Discount::query()
            ->with(['collections.products', 'products'])
            ->whereIn('id', $this->cart->discounts->pluck('discount_id'))
            ->get();

        $discountedProducts = $discounts->pluck('products')->flatten()
            ->merge($discounts->pluck('collections')->flatten()->pluck('products')->flatten())
            ->unique('id')
            ->toArray();

        foreach ($discounts as $discount) {
            foreach ($this->cartItems as $item) {
                $itemHasDiscount = collect($discountedProducts)->firstWhere('id', $item->product_id);

                if ($itemHasDiscount) {
                    if (! $item->discount()->exists()) {
                        $item->discount()->create([
                            'cart_id' => $item->cart_id,
                            'discount_id' => $discount->id,
                            'code' => $discount->code,
                            'type' => $discount->type,
                            'amount' => $discount->value,
                        ]);
                    }
                }
            }
        }

        $this->cart->load([
            'discounts',
            'items.discount',
            'items.product.media',
            'items.variant.media',
            'items.variant.variantAttributes.option',
            'items.variant.variantAttributes.optionValue',
        ]);

        $this->discountTotal = $this->cart->items->reduce(function ($carry, $item) {
            return $carry + $item->discounted_amount;
        }, 0);
    }

    public function findOrCreateCustomer()
    {
        return Customer::query()->firstOrCreate([
            'email' => $this->order->customer_email,
        ], [
            'name' => $this->isBillingSameAsShipping ? $this->shippingAddress->name : $this->billingAddress->name,
            'password' => Hash::make(Str::random(40)),
        ]);
    }

    public function placeOrder()
    {
        if ($this->isBillingSameAsShipping) {
            $this->validate([
                'shippingAddress.name' => ['required', 'string'],
                'shippingAddress.company_name' => ['nullable', 'string'],
                'shippingAddress.address_line_1' => ['required', 'string'],
                'shippingAddress.address_line_2' => ['nullable', 'string'],
                'shippingAddress.city' => ['required', 'string'],
                'shippingAddress.state' => ['nullable', 'string'],
                'shippingAddress.postcode' => ['nullable', 'string'],
                'shipping_phone' => ['nullable', Rule::phone()->country('shipping_phone_country')],
                'shipping_phone_country' => ['nullable', 'string', 'exists:countries,iso2'],
                'shippingAddress.country_id' => ['required', 'exists:countries,id'],
                'shippingMethod' => ['required', 'exists:shipping_zone_rates,id'],
                'paymentMethod' => ['required', 'exists:payment_methods,identifier'],
                'order.customer_email' => ['required', 'email'],
                'order.shipping_rate' => ['required', 'string'],
                'order.shipping_price' => ['required', 'numeric'],
                'order.notes' => ['nullable', 'string'],
            ]);
        } else {
            $this->validate();
        }

        $customer = $this->customer ? $this->customer : $this->findOrCreateCustomer();

        $this->order->customer_id = $customer->id;

        $this->order->customer_email = $customer->email;

        $this->order->payment_method_id = $this->availablePaymentProviders->firstWhere('identifier', $this->paymentMethod)->id;

        $this->order->payment_status = PaymentStatus::UNPAID;

        $taxBreakDown = [];

        foreach ($this->availableTaxRates as $rate) {
            $taxBreakDown[] = [
                'name' => $rate->name,
                'priority' => $rate->priority,
                'percentage' => $rate->percentage,
            ];
        }

        $this->order->tax_breakdown = $taxBreakDown;

        $this->order->save();

        $this->shippingAddress->phone_country = $this->shipping_phone_country;

        $this->shippingAddress->phone = $this->shipping_phone;

        $this->order->shippingAddress()->save($this->shippingAddress);

        if ($this->isBillingSameAsShipping) {
            $this->billingAddress = $this->shippingAddress->replicate(['is_billing' => true]);
        } else {
            $this->billingAddress->phone_country = $this->billing_phone_country;

            $this->billingAddress->phone = $this->billing_phone;
        }

        $this->billingAddress->is_billing = true;

        $this->order->billingAddress()->save($this->billingAddress);

        $this->cartItems->each(function (CartItem $item) {
            $orderItem = $this->order->orderItems()->create([
                'product_id' => $item->product_id,
                'variant_id' => $item->variant_id,
                'name' => $item->product->name,
                'price' => $item->variant->price,
                'quantity' => $item->quantity,
            ]);

            if ($item->discount) {
                $this->order->orderDiscounts()->create([
                    'order_item_id' => $orderItem->id,
                    'code' => $item->discount->code,
                    'type' => $item->discount->type,
                    'amount' => $item->discount->amount,
                ]);
            }
        });

        $this->cart->items()->delete();

        $this->cart->discounts()->delete();

        OrderCreated::dispatch($this->order);

        if ($this->paymentMethod === 'stripe') return $this->buildStripeSession();

        if ($this->paymentMethod === 'razorpay') {
            $this->createRazorpayOrder();
        }

        $this->redirect($this->customer ? route('customer.orders.detail', $this->order) : URL::signedRoute('guest.orders.detail', $this->order));
    }

    public function getCustomerProperty(): \App\Models\Customer|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        return \Auth::user();
    }

    public function getCartProperty(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $cart = $this->customer
            ? Cart::query()->firstOrCreate(['customer_id' => $this->customer->id])
            : Cart::query()->firstOrCreate(['session_id' => session()->getId()]);

        $cart->load([
            'discounts',
            'items.discount',
            'items.product.media',
            'items.variant.media',
            'items.variant.variantAttributes.option',
            'items.variant.variantAttributes.optionValue',
        ])->loadCount('items');

        return $cart;
    }

    public function getCartItemsProperty()
    {
        return $this->cart->items;
    }

    public function getAvailableShippingCountriesProperty(): \Illuminate\Database\Eloquent\Collection|array
    {
        $shippingZones = ShippingZone::query()
            ->has('rates')
            ->pluck('id')
            ->toArray();

        return ShippingZoneCountry::query()
            ->with('country')
            ->whereIn('shipping_zone_id', $shippingZones)
            ->orderBy('country_id')
            ->get();
    }

    public function getAvailableShippingRatesProperty(): \Illuminate\Database\Eloquent\Collection|array
    {
        $shippingZone = ShippingZone::query()
            ->whereHas('countries', function ($query) {
                return $query->where('country_id', $this->shippingAddress->country_id);
            })
            ->first();

        return ShippingZoneRate::query()
            ->where('shipping_zone_id', $shippingZone->id)
            ->get()
            ->filter(function ($rate) {
                return ! $rate->hasConditions
                    || $rate->based_on == 'weight' && $rate->min_value <= $this->cart->weight
                    || $rate->based_on == 'price' && $rate->min_value <= $this->cart->subtotal;
            });
    }

    public function getAvailableTaxRatesProperty(): Collection|\Illuminate\Support\Collection|array
    {
        $taxZone = TaxZone::query()
            ->whereHas('countries', function ($query) {
                return $query->where('country_id', $this->shippingAddress->country_id);
            })
            ->first();

        return $taxZone ? TaxZoneRate::query()->where('tax_zone_id', $taxZone->id)->get() : collect([]);
    }

    public function getTotalTaxesAppliedProperty()
    {
        return $this->availableTaxRates->reduce(function ($taxTotal, $taxLine) {
            return $taxTotal + ($this->cart->subtotal - $this->discountTotal) * $taxLine->percentage / 100;
        }, 0);
    }

    public function getAvailablePaymentProvidersProperty(): Collection|array
    {
        return PaymentMethod::query()
            ->where('is_enabled', true)
            ->get();
    }

    public function getCheckoutSettingsProperty()
    {
        return app(CheckoutSetting::class);
    }

    public function render()
    {
        return view('livewire.guest.checkout', [
            'cart' => $this->cart,
            'cartItems' => $this->cartItems,
        ])->layout('layouts.guest');
    }
}
