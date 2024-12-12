<?php

namespace App\Http\Livewire\Customer\Order;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Review;
use App\Models\Variant;
use Livewire\Component;
use Razorpay\Api\Api;
use Stripe\StripeClient;

//Use Case Summary
//Customers apne orders ka detail dekh sakte hain.
//Products ka review likh aur update kar sakte hain.
//Digital files download kar sakte hain.
//Payment methods (Stripe aur Razorpay) handle hote hain.

class OrderDetail extends Component
{
    public Order $order;

    public Review $review;

    public $productBeingReviewed;

    public $showReviewForm = false;

    protected $rules = [
        'review.rating' => 'required|integer|min:1|max:5',
        'review.title' => 'required|string|max:255',
        'review.content' => 'required|string',
    ];

// Order aur usse related details (addresses, order items, products, reviews, variants, etc.) ko eager load karta hai.
// Yeh optimize queries ko ensure karta hai, jisse unnecessary queries avoid ho.
    public function mount()
    {
        $this->order->load([
            'addresses.country:id,name',
            'orderItems:id,order_id,product_id,variant_id,price,quantity,subtotal',
            'orderItems.product:id,name,slug,excerpt,price',
            'orderItems.product.media',
            'orderItems.product.reviews' => function ($query) {
                $query->select('reviews.product_id', 'reviews.rating')->where('customer_id', $this->customer->id)->latest();
            },
            'orderItems.variant:id,product_id,sku,price,shipping_type',
            'orderItems.variant.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
            'orderItems.shipmentItems',
        ]);
    }
//writeReviewForProduct($productId)
//
//User kisi specific product ke liye review likhne ki shuruat kar sakta hai.
//Agar existing review hai, toh usse load karega. Naya review banane ke liye firstOrNew() use hota hai.
//$showReviewForm ko true karta hai jisse review form UI mein dikhaye.
    public function writeReviewForProduct($productId)
    {
        $this->order->load([
            'addresses.country:id,name',
            'orderItems:id,order_id,product_id,variant_id,price,quantity,subtotal',
            'orderItems.product:id,name,slug,excerpt,price',
            'orderItems.product.media',
            'orderItems.product.reviews' => function ($query) {
                $query->select('reviews.product_id', 'reviews.rating')->where('customer_id', $this->customer->id)->latest();
            },
            'orderItems.variant:id,product_id,sku,price,shipping_type',
            'orderItems.variant.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
            'orderItems.shipmentItems',
        ]);

        $this->review = Review::where('customer_id', $this->customer->id)->where('product_id', $productId)->firstOrNew();

        $this->productBeingReviewed = $productId;

        $this->showReviewForm = true;
    }

//saveReview()
//
//User ka review validate karne ke baad save karta hai.
//Review customer_id aur product_id ke saath database mein store hota hai.
//Save karne ke baad review form band ho jata hai ($showReviewForm = false).
    public function saveReview()
    {
        $this->order->load([
            'addresses.country:id,name',
            'orderItems:id,order_id,product_id,variant_id,price,quantity,subtotal',
            'orderItems.product:id,name,slug,excerpt,price',
            'orderItems.product.media',
            'orderItems.product.reviews' => function ($query) {
                $query->select('reviews.product_id', 'reviews.rating')->where('customer_id', $this->customer->id)->latest();
            },
            'orderItems.variant:id,product_id,sku,price,shipping_type',
            'orderItems.variant.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
            'orderItems.shipmentItems',
        ]);

        $this->validate();

        $this->review->customer_id = $this->customer->id;

        $this->review->product_id = $this->productBeingReviewed;

        $this->review->save();

        $this->showReviewForm = false;
    }

//downloadDigitalAttachment(Variant $variant)
//User order mein kisi digital attachment ko download kar sakta hai.
//getFirstMedia() se variant ka pehla attachment fetch hota hai.
    public function downloadDigitalAttachment(Variant $variant)
    {
        $this->order->load([
            'addresses.country:id,name',
            'orderItems:id,order_id,product_id,variant_id,price,quantity,subtotal',
            'orderItems.product:id,name,slug,excerpt,price',
            'orderItems.product.media',
            'orderItems.product.reviews' => function ($query) {
                $query->select('reviews.product_id', 'reviews.rating')->where('customer_id', $this->customer->id)->latest();
            },
            'orderItems.variant:id,product_id,sku,price,shipping_type',
            'orderItems.variant.media',
            'orderItems.variant.variantAttributes.option',
            'orderItems.variant.variantAttributes.optionValue',
            'orderItems.shipmentItems',
        ]);

        return $variant->getFirstMedia('attachment');
    }

//Stripe Payment: processStripePayment()
//
//Stripe ka checkout session fetch karta hai.
//Agar successful hai, toh user ko payment session ke URL par redirect karta hai.
//Agar error hoti hai, toh error log karta hai.
    public function processStripePayment()
    {
        $stripe = new StripeClient(config('services.stripe.secret_key'));

        try {
            $session = $stripe->checkout->sessions->retrieve($this->order->meta['stripe_session_id'], []);

            return redirect($session->url);
        } catch (\Exception $e) {
            return logger($e->getMessage());
        }
    }

//Razorpay Payment: verifyRazorpayPayment($razorpay_payment_id, $razorpay_signature)
//
//Razorpay ka Api class use karke payment signature verify karta hai.
//Agar signature valid hai, toh order ki payment status update karta hai (e.g., PENDING).
//Payment details ko meta field mein save karta hai.
    public function verifyRazorpayPayment($razorpay_payment_id, $razorpay_signature)
    {
        $api = new Api(config('services.razorpay.api_key'), config('services.razorpay.api_secret'));

        $razorpay_order_id = $this->order->meta['razorpay_order_id'];

        $attributes = [
            'razorpay_order_id' => $razorpay_order_id,
            'razorpay_payment_id' => $razorpay_payment_id,
            'razorpay_signature' => $razorpay_signature,
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);

            if ($this->order->payment_status == PaymentStatus::UNPAID) {
                $this->order->payment_status = PaymentStatus::PENDING;
            }

            $this->order->update([
                'meta' => [
                    'razorpay_order_id' => $razorpay_order_id,
                    'razorpay_payment_id' => $razorpay_payment_id,
                    'razorpay_signature' => $razorpay_signature,
                ],
            ]);
        } catch (\Exception $e) {
            logger($e->getMessage());
        }
    }

//getCustomerProperty()
//
//Authenticated user object ko fetch karta hai.
    public function getCustomerProperty()
    {
        return \Auth::user();
    }

//getBillingAddressProperty()
//
//Order ke billing address ko retrieve karta hai.
    public function getBillingAddressProperty()
    {
        return $this->order->addresses->where('is_billing', true)->first();
    }

//getShippingAddressProperty()
//
//Order ke shipping address ko retrieve karta hai.
    public function getShippingAddressProperty()
    {
        return $this->order->addresses->where('is_billing', false)->first();
    }

//render() Method:
//Component ke order-detail view ko load karta hai.
//layouts.guest layout ke saath render hota hai.
    public function render()
    {
        return view('livewire.customer.order.order-detail')->layout('layouts.guest');
    }
}
