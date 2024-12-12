<?php

namespace App\Http\Livewire\Guest;

use App\Models\Cart;
use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;

class ShoppingCart extends Component
{
    use SEOTools;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount()
    {
        $this->seo()->setTitle('Shopping Cart');
    }

    public function updateCartItemQuantity($cartItemId, $quantity)
    {
        if ($quantity < 1) {
            return $this->addError('cartItems.' . $cartItemId . '.quantity', __('Quantity must be at least 1'));
        }

        $this->cartItems->find($cartItemId)->update(['quantity' => $quantity]);

        $this->emit('refresh')->to('guest.components.header');
    }

    public function removeCartItem($cartItemId)
    {
        $this->cartItems->find($cartItemId)->delete();

        $this->emit('refresh')->self();

        $this->emit('refresh')->to('guest.components.header');
    }

    public function getCustomerProperty()
    {
        return \Auth::user();
    }

    public function getCartProperty(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $cart = $this->customer
            ? Cart::query()->firstOrCreate(['customer_id' => $this->customer->id])
            : Cart::query()->firstOrCreate(['session_id' => session()->getId()]);

        $cart->load([
            'items.product.media',
            'items.variant.media',
            'items.variant.variantAttributes.option',
            'items.variant.variantAttributes.optionValue',
        ]);

        return $cart;
    }

    public function getCartItemsProperty()
    {
        return $this->cart->items;
    }

    public function render()
    {
        return view('livewire.guest.shopping-cart', [
            'cart' => $this->cart,
            'cartItems' => $this->cartItems,
        ])->layout('layouts.guest');
    }
}
