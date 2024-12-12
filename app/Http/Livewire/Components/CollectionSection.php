<?php

namespace App\Http\Livewire\Components;

use App\Models\Carousel;
use App\Models\Collection;
use Livewire\Component;

class CollectionSection extends Component
{
    // Yeh 's ek public property hai jo handle karega collection ka slug ya identifier. Isse tum dynamically different collections ko fetch kar paoge.
    public $handle;
   // Yeh 's property ek array ho sakti hai jisme specific collection items ke IDs hain.
    public $items;

    public function getCollectionItemsProperty()
    {
        if ($this->items) {  // Agar $items property set hoti hai, toh yeh method Collection model se media ke saath collection items ko fetch karta hai.
            return Collection::with('media')  // with('media') ka matlab hai ki har collection ke saath uska associated media (images, videos etc.) bhi fetch ho jayega.
                ->whereIn('id', $this->items)->get(); // whereIn('id', $this->items) ka matlab hai ke yeh method un collections ko fetch karega jinki IDs $items array mein hain.
        }
    }

    public function getCollectionCarouselProperty()
    {
        if (!$this->items && $this->handle) { // Agar $items set nahi hai aur $handle set hai, toh yeh method Carousel model ko use karta hai.
            return Carousel::with('slides.media') // with('slides.media') ka matlab hai ki carousel ke saath uske slides aur un slides ka media bhi fetch kiya jayega.
                ->where('slug', $this->handle)->first(); // where('slug', $this->handle) ka matlab hai ki carousel ko slug ke basis pe filter kiya jayega jo $handle mein diya gaya hai.
        }
    }

    public function render()
    {
        return view('livewire.components.collection-section');// yaha collection section render hoga
    }
}
