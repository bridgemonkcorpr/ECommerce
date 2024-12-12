<?php

namespace App\Http\Livewire\Guest;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Variant;
use Artesaos\SEOTools\Traits\SEOTools;
use Livewire\Component;

class ProductDetail extends Component
{
    use SEOTools;

    public Product $product;

    public Variant $variant;

    public int $minQuantity = 1;

    public int $maxQuantity = 1;

    public array $selectedOptionValues;

    public array $addToCart = [
        'product' => null,
        'variant' => null,
        'quantity' => 1,
    ];

    public string $variantQuery = '';

    protected $queryString = ['variantQuery' => ['except' => '', 'as' => 'variant']];

    public function mount()
    {
        $this->product
            ->load([
                'media',
                'reviews' => fn($query) => $query->whereNotNull('published_at'),
                'reviews.customer.media',
                'specifications',
            ])
            ->loadCount([
                'media'
            ]);

        abort_unless($this->product->is_active, 404);

        abort_unless($this->productVariants->count(), 500);

        if ($this->productVariants->count() > 1) {
            if ($this->variantQuery != '') {
                $variant = $this->productVariants->where('id', $this->variantQuery)->first();
                if ($variant) {
                    $this->variant = $variant;
                } else {
                    return redirect()->route('guest.products.show', $this->product);
                }
            } else {
                $this->variant = $this->productVariants->first();
            }
            $this->variantQuery = $this->variant->id;
        } else {
            $this->variant = $this->productVariants->first();
        }

        $this->addToCart['product'] = $this->product->id;

        $this->addToCart['variant'] = $this->variant->id;

        $this->maxQuantity = $this->variant->stock_value > 0 ? $this->variant->stock_value : $this->maxQuantity;

        $this->selectedOptionValues = $this->variant->variantAttributes->pluck('option_value_id')->toArray();

        $this->setRecentlyViewedProduct();

        $this->seo()->setTitle($this->product->seo_title ?: $this->product->name);

        $this->seo()->setDescription($this->product->seo_description ?: null);

        $this->seo()->opengraph()->addImage($this->product->getFirstMediaUrl('gallery'), [
            'height' => 600,
            'width' => 600,
        ]);
    }

    public function updatedSelectedOptionValues()
    {
        if (count($this->selectedOptionValues) == $this->product->options->count()) {
            foreach ($this->product->variants as $variant) {
                if (collect($variant['variantAttributes'])->whereIn('option_value_id', $this->selectedOptionValues)->count() == $this->product->options->count()) {
                    $this->variant = $variant;
                    $this->variantQuery = $variant->id;
                    $this->addToCart['product'] = $this->product->id;
                    $this->addToCart['variant'] = $variant->id;
                    $this->maxQuantity = $variant->stock_value;
                }
            }
        }
    }

    public function addToCart()
    {
        $this->cart->items()->updateOrCreate([
            'product_id' => $this->addToCart['product'],
            'variant_id' => $this->addToCart['variant'],
        ], [
            'quantity' => $this->addToCart['quantity'],
        ]);

        $this->emit('refresh')->to('guest.components.header');

        $this->emit('show')->to('guest.components.cart-slide');
    }

    public function getCustomerProperty(): \App\Models\Customer|\Illuminate\Contracts\Auth\Authenticatable|null
    {
        return \Auth::user();
    }

    public function getCartProperty(): \App\Models\Cart|\Illuminate\Database\Eloquent\Model
    {
        return $this->customer
            ? Cart::query()->firstOrCreate(['customer_id' => $this->customer->id])
            : Cart::query()->firstOrCreate(['session_id' => session()->getId()]);
    }

    public function getProductOptionsProperty()
    {
        $this->product->load('options.optionValues.media');

        return $this->product->options;
    }

    public function getProductVariantsProperty()
    {
        $this->product->load('variants.variantAttributes');

        return $this->product->variants;
    }

    public function getRecentlyViewedProductsProperty()
    {
        if (session()->has('recently_viewed_products')) {

            $recentlyViewedProductKeys = session()->get('recently_viewed_products');

            return Product::query()
                ->with('media')
                ->find($recentlyViewedProductKeys)
                ->sortBy(function ($order) use ($recentlyViewedProductKeys) {
                    return array_search($order['id'], $recentlyViewedProductKeys);
                })
                ->values()
                ->all();
        }

        return [];
    }

    public function setRecentlyViewedProduct()
    {
        $recentlyViewedProducts = session()->has('recently_viewed_products') ? collect(session()->pull('recently_viewed_products')) : collect();

        if ($recentlyViewedProducts->count() > 3 && !$recentlyViewedProducts->contains($this->product->getKey())) $recentlyViewedProducts->pop();

        $recentlyViewedProducts->prepend($this->product->getKey());

        session()->put('recently_viewed_products', $recentlyViewedProducts->unique()->toArray());
    }

    public function render()
    {
        return view('livewire.guest.product-detail')->layout('layouts.guest');
    }
}
