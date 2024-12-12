<?php

namespace App\Http\Livewire\Components;

use App\Models\Article;
use Livewire\Component;

class BlogSection extends Component
{
//Yeh method ek dynamic property define karta hai jiska naam articles hai, jo latest 3 published articles ko unke associated media ke saath fetch karta hai.
    public function getArticlesProperty()
    {
        return Article::query()  // Article::query() se query start hoti hai.
            ->with(['media'])  // with(['media']): Yeh article ke sath media ko bhi load kar raha hai (for example images, videos).
            ->limit(3)  // limit(3): Yeh query ko sirf 3 articles tak limit kar raha hai.
            ->published()  //  published(): Yeh method (jo Article model me defined hona chahiye) published articles ko filter karta hai.
            ->latest()  //  latest(): Yeh articles ko latest date ke hisaab se order karta hai.
            ->get();   //  get(): Yeh query execute karta hai aur result deta hai.
    }

    public function render()
    {
        return view('livewire.components.blog-section');  // yeh blog section waala page return karega
    }
}
