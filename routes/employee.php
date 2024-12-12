<?php

use App\Http\Livewire\Employee\Auth\ForgotPassword;
use App\Http\Livewire\Employee\Auth\Login;
use App\Http\Livewire\Employee\Auth\ResetPassword;
use App\Http\Middleware\RedirectIfNotSetup;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => config('app.admin_path'),
    'as' => 'employee.',
    'middleware' => RedirectIfNotSetup::class
], function () {
    Route::group(['middleware' => 'guest:employee'], function () {
        Route::get('/login', Login::class)->name('login');
        Route::get('/forgot-password', ForgotPassword::class)->name('forgot-password');
        Route::get('/reset-password/{token}', ResetPassword::class)->name('reset-password');
    });

    Route::group(['middleware' => 'auth:employee'], function () {
        Route::get('/', \App\Http\Livewire\Employee\Dashboard::class)->name('dashboard');
        Route::get('/profile', \App\Http\Livewire\Employee\Profile\ProfileManager::class)->name('profile');
        Route::get('/orders', \App\Http\Livewire\Employee\Order\OrderList::class)->name('orders.list');
        Route::get('/orders/{order:id}', \App\Http\Livewire\Employee\Order\OrderDetail::class)->name('orders.detail');
        Route::get('/orders/{order}/refund', \App\Http\Livewire\Employee\Order\OrderRefundCreate::class)->name('orders.refund');
        Route::get('/orders/{order}/shipments/create', \App\Http\Livewire\Employee\Order\OrderShipmentCreate::class)->name('orders.shipments.create');
        Route::get('/collections', \App\Http\Livewire\Employee\Collection\CollectionList::class)->name('collections.list');
        Route::get('/collections/create', \App\Http\Livewire\Employee\Collection\CollectionDetail::class)->name('collections.create');
        Route::get('/collections/{collection:id}', \App\Http\Livewire\Employee\Collection\CollectionDetail::class)->name('collections.detail');
        Route::get('/products', \App\Http\Livewire\Employee\Product\ProductList::class)->name('products.list');
        Route::get('/products/{product:id}', \App\Http\Livewire\Employee\Product\ProductDetail::class)->name('products.detail');
        Route::get('/products/{product:id}/variants/{variant:id}', \App\Http\Livewire\Employee\Product\ProductVariantDetail::class)->name('products.variants.detail');
        Route::get('/customers', \App\Http\Livewire\Employee\Customer\CustomerList::class)->name('customers.list');
        Route::get('/customers/create', \App\Http\Livewire\Employee\Customer\CustomerCreate::class)->name('customers.create');
        Route::get('/customers/{customer:id}', \App\Http\Livewire\Employee\Customer\CustomerDetail::class)->name('customers.detail');
        Route::get('/discounts', \App\Http\Livewire\Employee\Discount\DiscountList::class)->name('discounts.list');
        Route::get('/discounts/create', \App\Http\Livewire\Employee\Discount\DiscountDetail::class)->name('discounts.create');
        Route::get('/discounts/{discount:id}', \App\Http\Livewire\Employee\Discount\DiscountDetail::class)->name('discounts.detail');
        Route::get('/shipping', \App\Http\Livewire\Employee\Shipping\ShippingManager::class)->name('shipping.manager');
        Route::get('/taxes', \App\Http\Livewire\Employee\Taxation\TaxManager::class)->name('taxes.manager');
        Route::redirect('/settings', '/admin/settings/general');
        Route::get('/settings/general', \App\Http\Livewire\Employee\Settings\GeneralSettingManager::class)->name('settings.general');
        Route::get('/settings/user', \App\Http\Livewire\Employee\User\UserList::class)->name('settings.user.list');
        Route::get('/settings/user/create', \App\Http\Livewire\Employee\User\UserCreate::class)->name('settings.user.create');
        Route::get('/settings/user/{user:id}', \App\Http\Livewire\Employee\User\UserDetail::class)->name('settings.user.detail');
        Route::get('/settings/branding', \App\Http\Livewire\Employee\Settings\BrandSettingManager::class)->name('settings.branding');
        Route::get('/settings/payments', \App\Http\Livewire\Employee\Settings\PaymentSettingManager::class)->name('settings.payments');
        Route::get('/settings/checkout', \App\Http\Livewire\Employee\Settings\CheckoutSettingManager::class)->name('settings.checkout');

    });
});
