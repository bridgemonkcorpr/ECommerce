<?php

namespace App\Http\Livewire\Guest\Components;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CartSlide extends Component
{
    public Cart $cart;

    public Collection $cartItems;

    public $isShown = false;

    protected $listeners = [
        'show' => 'show',
    ];

    public function mount()
    {
        $this->cartItems = new Collection();
    }

    public function show()
    {
        $this->cart = $this->loadCart();

        $this->cartItems = $this->loadCartItems();

        $this->isShown = true;
    }

    public function loadCart(): \App\Models\Cart|\Illuminate\Database\Eloquent\Model
    {
        $cart = $this->customer
            ? Cart::query()->firstOrCreate(['customer_id' => $this->customer->id])
            : Cart::query()->firstOrCreate(['session_id' => session()->getId()]);

        $cart->load([
            'items' => fn($query) => $query->orderBy('created_at', 'desc'),
            'items.product.media',
            'items.variant.media',
            'items.variant.variantAttributes.option',
            'items.variant.variantAttributes.optionValue',
        ]);

        return $cart;
    }

    public function loadCartItems()
    {
        return $this->cart->items;
    }

    public function removeCartItem($cartItemId): void
    {
        $this->cart->items->find($cartItemId)->delete();

        $this->cart = $this->loadCart();

        $this->cartItems = $this->loadCartItems();

        $this->emit('refresh')->to('guest.components.header');
    }

    public function getCustomerProperty(): \App\Models\Customer|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        return \Auth::user();
    }

    public function render()
    {
        return view('livewire.guest.components.cart-slide');
    }
}
