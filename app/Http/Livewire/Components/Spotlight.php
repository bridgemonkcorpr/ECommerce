<?php

namespace App\Http\Livewire\Components;

use App\Models\Employee;
use App\Models\Product;
use Livewire\Component;

class Spotlight extends Component
{
    // Yeh boolean property define karti hai ki search request admin panel se aa rahi hai ya nahi.
    public bool $searchFromAdmin = false;

    // User ke search input ko store karne ke liye yeh property use hoti hai. Example: User shoes search karega, toh $query = 'shoes'.
    public string $query = '';

    // Check karta hai ki current route admin panel ka hai ya nahi.
    // Agar route employee.* ke under hai, toh $searchFromAdmin = true.
    public function mount()
    {
        $this->searchFromAdmin = request()->routeIs('employee.*');
    }

    // Authenticated user object ko fetch karta hai.
    public function getUserProperty()
    {
        return \Auth::user();
    }


    // User ke query ke basis par products fetch karta hai.
    // Agar query empty hai, toh result bhi empty hoga.
    public function getProductsProperty()
    {
        $products = [];

        if ($this->query) {
            $products = Product::query()
                ->select('id', 'name', 'slug', 'price')
                ->with('media') // Products ke saath related media (e.g., images) ko eager load karta hai.
                ->where('name', 'like', "%{$this->query}%"); // Search results ko query ke matching names ke basis par filter karta hai.

            if (!$this->user instanceof Employee) {
                $products->published()->active();  // Agar user regular hai, toh sirf published aur active products filter hote hain
            }

            $products = $products->get(); // Agar user admin hai (Employee model ka instance hai), toh sabhi products fetch hote hain.
        }

        return $products;  // Saare products return hote hain
    }

    public function render()
    {
        return view('livewire.components.spotlight', [
            'products' => $this->products,
        ]);
    }
}
