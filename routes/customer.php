<?php

use App\Http\Middleware\RedirectIfNotSetup;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'account',
    'as' => 'customer.',
    'middleware' => ['auth:customer', RedirectIfNotSetup::class],
], function () {
    Route::get('/profile', \App\Http\Livewire\Customer\Profile\ProfileManager::class)->name('profile');
    Route::get('/orders', \App\Http\Livewire\Customer\Order\OrderList::class)->name('orders.list');
    Route::get('/orders/{order}', \App\Http\Livewire\Customer\Order\OrderDetail::class)->name('orders.detail');
});
