<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['as' => 'guest.', 'middleware' => \App\Http\Middleware\RedirectIfNotSetup::class], function () {
    Route::get('/', \App\Http\Livewire\Guest\Welcome::class)->name('welcome');
    Route::get('/about', \App\Http\Livewire\Guest\About::class)->name('about');
    Route::get('/collections', \App\Http\Livewire\Guest\CollectionList::class)->name('collections.list');
    Route::get('/collections/{collection}', \App\Http\Livewire\Guest\CollectionDetail::class)->name('collections.detail');
    Route::redirect('/products', '/collections')->name('products.list');
    Route::get('/products/{product}', \App\Http\Livewire\Guest\ProductDetail::class)->name('products.detail');
    Route::get('/cart', \App\Http\Livewire\Guest\ShoppingCart::class)->name('cart');
    Route::get('/checkout', \App\Http\Livewire\Guest\Checkout::class)->name('checkout');
    Route::get('/orders/{order}', \App\Http\Livewire\Guest\OrderDetail::class)->name('orders.detail')->middleware('signed');
    Route::get('/contact', \App\Http\Livewire\Guest\Contact::class)->name('contact');
});

Route::get('/setup', \App\Http\Livewire\Setup\Setup::class)->middleware(\App\Http\Middleware\RedirectIfSetupFinished::class)->name('setup');

Route::webhooks('webhooks/razorpay', 'razorpay');
Route::stripeWebhooks('webhooks/stripe');

require __DIR__ . '/auth.php';
require __DIR__ . '/customer.php';
require __DIR__ . '/employee.php';
