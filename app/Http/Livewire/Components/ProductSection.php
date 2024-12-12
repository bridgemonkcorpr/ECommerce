<?php

namespace App\Http\Livewire\Components;

use App\Models\Carousel;
use App\Models\Product;
use Livewire\Component;

//Scenario 1: Display Specific Products
//
//$items defined hai, e.g., [1, 2, 3].
//Component sirf in products ko fetch karega aur dikhayega.
//Scenario 2: Display a Carousel
//
//$items undefined hai, lekin $handle = 'homepage-carousel'.
//    Component carousel slides fetch karega aur render karega.

class ProductSection extends Component
{
    // Yeh ek unique identifier ya slug hai jo specific carousel ko identify karta hai.
    // Agar tumhe ek banner section load karna ho, toh $handle ka use hota hai.
    public $handle;

    // Agar tum ek list of products fetch karna chahte ho, toh $items mein un product IDs ki list hoti hai.
    // Example: [1, 2, 3] will fetch products with these IDs.
    public $items;

    // Yeh 's method active products fetch karta hai jo $items mein defined hain.
    public function getProductItemsProperty()
    {
        if ($this->items) {
            return Product::with(['reviews', 'media']) // with(['reviews', 'media']): Reviews aur media relations ko eager load karta hai.
                ->whereIn('id', $this->items)->
            active()   // active(): Active products filter karne ke liye scope method use karta hai (assuming active scope Product model mein defined hai).
                ->get();
        }
    }

    public function getCollectionCarouselProperty()
    {
        if (!$this->items && $this->handle) { // Agar $items nahi hain, toh yeh $handle ke basis par carousel data fetch karta hai.
            return Carousel::with('slides.media') // with('slides.media'): Carousel slides ke saath unka media (images/videos) load karta hai.
                ->where('slug', $this->handle) // where('slug', $this->handle): Slug ke basis par specific carousel ko filter karta hai.
                ->first();
        }
    }

    public function render()
    {  // Yeh method ek Blade view ko return karta hai jo tumhare product section ya carousel ko render karega.
        return view('livewire.components.product-section');
    }
}
