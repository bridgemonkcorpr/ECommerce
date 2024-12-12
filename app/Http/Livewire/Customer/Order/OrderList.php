<?php

namespace App\Http\Livewire\Customer\Order;

use App\Models\Order;
use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;




//Use Case Summary
//Customer apne saare orders dekh sakta hai.
//Orders ka paginated list dikhaya jata hai.
//Reviews add ya update karne ki functionality provide karta hai.
//Code Flow
//Component mount() hone ke baad orders fetch karta hai via getRowsQueryProperty.
//Paginated data ko getRowsProperty ke zariye fetch karta hai.
//Customer kisi specific product ka review likh sakta hai ya update kar sakta hai.
//Component UI ko re-render karne ke liye Livewire reactive state ka use karta hai.
class OrderList extends Component
{
//WithPagination Trait:
//Component pagination support ke liye WithPagination use karta hai.
//Orders ko 10 items per page dikhata hai.
    use WithPagination;

    public Review $review;

    public $productBeingReviewed;

    public $showReviewForm = false;

    protected $rules = [
        'review.rating' => 'required|integer|min:1|max:5',
        'review.title' => 'required|string|max:255',
        'review.content' => 'required|string',
    ];

//getRowsQueryProperty()
//
//Saare orders customer ke ID ke basis par filter karta hai.
//with() ke through orders ke related models (e.g., orderItems, orderDiscounts, product, variant, etc.) ko eager load karta hai.
//Orders ko latest order date ke basis par sort karta hai.

    public function getRowsQueryProperty()
    {
        return Order::query()
            ->with([
                'orderDiscounts.orderItem',
                'orderItems:id,order_id,product_id,variant_id,price,quantity,subtotal',
                'orderItems.product:id,name,slug,excerpt,price',
                'orderItems.product.media',
                'orderItems.product.reviews' => function ($query) {
                    $query->select('reviews.product_id', 'reviews.rating')->where('customer_id', $this->customer->id)->latest();
                },
                'orderItems.variant:id,product_id,sku,price',
                'orderItems.variant.media',
                'orderItems.variant.variantAttributes.option',
                'orderItems.variant.variantAttributes.optionValue',
            ])
            ->where('customer_id', $this->customer->id)
            ->latest();
    }


//writeReviewForProduct($productId)
//
//Customer kisi product ke liye review likh sakta hai.
//Agar existing review hai, toh firstOrNew() ke through load karega.
//Product ID aur review form UI ko set karta hai ($showReviewForm = true).
    public function writeReviewForProduct($productId)
    {
        $this->review = Review::where('customer_id', $this->customer->id)->where('product_id', $productId)->firstOrNew();

        $this->productBeingReviewed = $productId;

        $this->showReviewForm = true;
    }


//saveReview()
//
//Review form ko validate karne ke baad save karta hai.
//Customer ID aur product ID ke saath review database mein store hota hai.
//Save hone ke baad review form ko close kar deta hai ($showReviewForm = false).
    public function saveReview()
    {
        $this->validate();

        $this->review->customer_id = $this->customer->id;

        $this->review->product_id = $this->productBeingReviewed;

        $this->review->save();

        $this->showReviewForm = false;
    }


//getRowsProperty()
//
//Paginated orders ko fetch karta hai using paginate(10).
    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate(10);
    }


//getCustomerProperty()
//Currently logged-in customer object ko fetch karta hai using Auth::user().
    public function getCustomerProperty(): \App\Models\Customer
    {
        return \Auth::user();
    }


//render() Method:
//order-list view ko orders data ke saath render karta hai.
//View layouts.guest ke saath load hota hai.
    public function render()
    {
        return view('livewire.customer.order.order-list', [
            'orders' => $this->rows,
        ])->layout('layouts.guest');
    }
}
