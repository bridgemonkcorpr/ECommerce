<?php

namespace App\Http\Livewire\Employee\Order;

use App\Events\RefundCreated;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Refund;
use App\Models\RefundItem;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Razorpay\Api\Api;
use Stripe\StripeClient;

class OrderRefundCreate extends Component
{
    public Order $order;

    public Refund $refund;

    public RefundItem $refundItem;

    public Collection $refundItems;

    public $selectedShippedItems = [];

    public $selectedUnshippedItems = [];

    public $removedItemsCount = 0;

    protected function rules()
    {
        return [
            'refund.amount' => ['required', 'numeric', 'min:1', 'max:' . $this->order->totalPaid - $this->order->totalRefunded],
            'refund.reason' => ['nullable', 'string'],
            'selectedShippedItems.*.selected_quantity' => ['nullable', 'integer'],
            'selectedUnshippedItems.*.selected_quantity' => ['nullable', 'integer'],
        ];
    }

    protected function messages()
    {
        return [
            'refund.amount.required' => trans('The amount field is required.'),
            'refund.amount.numeric' => trans('The amount field must be a number.'),
            'refund.amount.min' => trans('The amount field must be at least 1.'),
            'refund.amount.max' => trans('The amount field may not be greater than :amount', ['amount' => $this->order->totalPaid - $this->order->totalRefunded]),
        ];
    }

    public function mount()
    {
        $this->order
            ->load([
                'orderItems',
                'orderDiscounts',
                'paymentMethod',
                'payments',
                'refunds',
            ])
            ->loadCount([
                'refundItems as removed_items_count' => fn($query) => $query->where('is_shipped', false),
            ]);

        $this->refund = new Refund();

        $this->refundItems = new Collection();

        $this->selectedUnshippedItems = $this->unshippedItems->map(function ($item) {
            $item['selected_quantity'] = 0;
            return $item;
        });

        $this->selectedShippedItems = $this->shippedItems->map(function ($item) {
            $item['selected_quantity'] = 0;
            return $item;
        });

        $this->removedItemsCount = $this->order->removed_items_count;
    }

    public function updated($name)
    {
        if (\Str::contains($name, 'selectedUnshippedItems') || \Str::contains($name, 'selectedShippedItems')) {
            $this->refund->amount = $this->summary['refund_total'];
        }
    }

    public function refund()
    {
        $this->validate();

        if ($this->order->paymentMethod->identifier == 'stripe') {
            try {
                $stripe_refund_response = $this->processStripeRefund();

                $this->refund->meta = [
                    'stripe_refund_id' => $stripe_refund_response->id,
                ];
            } catch (\Exception $e) {
                $this->addError('refund.amount', $e->getMessage());

                return;
            }
        }

        if ($this->order->paymentMethod->identifier == 'razorpay') {
            try {
                $razorpay_refund_response = $this->processRazorpayRefund();

                $this->refund->meta = [
                    'razorpay_refund_id' => $razorpay_refund_response->id,
                ];
            } catch (\Exception $e) {
                $this->addError('refund.amount', $e->getMessage());

                return;
            }
        }

        $this->order->refunds()->save($this->refund);

        foreach ($this->selectedShippedItems as $selectedShippedItem) {
            if ($selectedShippedItem['selected_quantity'] > 0) {
                $this->refund->refundItems()->save(new RefundItem([
                    'order_id' => $this->order->id,
                    'order_item_id' => $selectedShippedItem['id'],
                    'quantity' => $selectedShippedItem['selected_quantity'],
                    'price' => $selectedShippedItem['price'],
                    'is_shipped' => true,
                ]));
            }
        }

        foreach ($this->selectedUnshippedItems as $selectedUnshippedItem) {
            if ($selectedUnshippedItem['selected_quantity'] > 0) {
                $this->refund->refundItems()->save(new RefundItem([
                    'order_id' => $this->order->id,
                    'order_item_id' => $selectedUnshippedItem['id'],
                    'quantity' => $selectedUnshippedItem['selected_quantity'],
                    'price' => $selectedUnshippedItem['price'],
                    'is_shipped' => false,
                ]));
            }
        }

        RefundCreated::dispatch($this->refund);

        $this->redirect(route('employee.orders.detail', $this->order));
    }

    public function getShippedItemsProperty()
    {
        $this->loadOrderItems();

        return $this->order->orderItems->filter(function ($item) {
            return $item->shipmentItems->sum('quantity') - $item->refundItems->where('is_shipped', true)->sum('quantity') > 0;
        });
    }

    public function getUnshippedItemsProperty()
    {
        $this->loadOrderItems();

        return $this->order->orderItems->filter(function ($item) {
            return $item->quantity - ($item->shipmentItems->sum('quantity') + $item->refundItems->sum('quantity')) > 0;
        });
    }

    public function getSummaryProperty()
    {
        $unshipped_subtotal = collect($this->selectedUnshippedItems)->sum(function ($item) {
            return $item['selected_quantity'] * $item['price'];
        });

        $shipped_subtotal = collect($this->selectedShippedItems)->sum(function ($item) {
            return $item['selected_quantity'] * $item['price'];
        });

        $unshipped_discount_total = collect($this->order->orderDiscounts)->reduce(function ($value, $discount) use ($unshipped_subtotal) {
            return $value + ($discount->type == 'percentage' ? $unshipped_subtotal * $discount->amount / 100 : $discount->amount);
        }, 0);

        $shipped_discount_total = collect($this->order->orderDiscounts)->reduce(function ($value, $discount) use ($shipped_subtotal) {
            return $value + ($discount->type == 'percentage' ? $shipped_subtotal * $discount->amount / 100 : $discount->amount);
        }, 0);

        $unshipped_tax_total = collect($this->order->tax_breakdown)->reduce(function ($value, $line) use ($unshipped_subtotal) {
            return $value + ($unshipped_subtotal - $this->order->discount_total) * $line['percentage'] / 100;
        }, 0);

        $shipped_tax_total = collect($this->order->tax_breakdown)->reduce(function ($value, $line) use ($shipped_subtotal) {
            return $value + ($shipped_subtotal - $this->order->discount_total) * $line['percentage'] / 100;
        }, 0);

        $unshipped_items_count = collect($this->selectedUnshippedItems)->where('selected_quantity', '>', 0)->count();

        $shipped_items_count = collect($this->selectedShippedItems)->where('selected_quantity', '>', 0)->count();

        return [
            'subtotal' => $unshipped_subtotal + $shipped_subtotal,
            'discount_total' => $unshipped_discount_total + $shipped_discount_total,
            'tax_total' => $unshipped_tax_total + $shipped_tax_total,
            'refund_total' => $unshipped_subtotal + $shipped_subtotal - $unshipped_discount_total - $shipped_discount_total + $unshipped_tax_total + $shipped_tax_total,
            'items_count' => $unshipped_items_count + $shipped_items_count,
        ];
    }

    protected function loadOrderItems(): Order
    {
        return $this->order->load([
            'orderItems.variant.media',
            'orderItems.variant.product.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
            'orderItems.shipmentItems',
            'orderItems.refundItems',
        ]);
    }

    protected function processStripeRefund()
    {
        $stripe = new StripeClient($this->stripe->meta['secret_key']);

        return $stripe->refunds->create([
            'payment_intent' => $this->order->meta['stripe_payment_intent'],
            'amount' => $this->refund->amount * 100,
        ]);
    }

    protected function processRazorpayRefund()
    {
        $api = new Api($this->razorpay->meta['api_key'], $this->razorpay->meta['api_secret']);

        return $api->payment->fetch($this->order->meta['razorpay_payment_id'])->refund([
            'amount' => $this->refund->amount * 100,
            'speed' => 'normal',
            'receipt' => $this->order->id,
        ]);
    }

    public function getStripeProperty(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return PaymentMethod::query()->where('identifier', 'stripe')->firstOrFail();
    }

    public function getRazorpayProperty(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return PaymentMethod::query()->where('identifier', 'razorpay')->firstOrFail();
    }

    public function render()
    {
        return view('livewire.employee.order.order-refund-create')->layout('layouts.admin');
    }
}
