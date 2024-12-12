<?php

namespace App\Providers;

use App\Settings\BrandSetting;
use App\Settings\GeneralSetting;
use App\Settings\LayoutSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Component;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Model::preventLazyLoading(false);

        try {
            \DB::connection()->getPdo();

            if (\Schema::hasTable('settings')) {
                $general_settings = app(GeneralSetting::class);

                config([
                    'seotools.meta.defaults.title' => $general_settings->store_name,
                    'seotools.opengraph.defaults.title' => $general_settings->store_name,
                    'seotools.opengraph.defaults.site_name' => $general_settings->store_name,
                    'seotools.json-ld.defaults.title' => $general_settings->store_name,
                ]);
            }

            if (\Schema::hasTable('payment_methods')) {
                $paymentMethods = \App\Models\PaymentMethod::all();

                foreach ($paymentMethods as $paymentMethod) {
                    if ($paymentMethod->is_enabled) {
                        if ($paymentMethod->identifier == 'stripe') {
                            config([
                                'services.stripe.public_key' => $paymentMethod->meta['public_key'],
                                'services.stripe.secret_key' => $paymentMethod->meta['secret_key'],
                                'stripe-webhooks.signing_secret' => $paymentMethod->meta['webhook_secret'],
                            ]);
                        } else if ($paymentMethod->identifier == 'razorpay') {
                            config([
                                'services.razorpay.api_key' => $paymentMethod->meta['api_key'],
                                'services.razorpay.api_secret' => $paymentMethod->meta['api_secret'],
                                'webhook-client.configs.0.signing_secret' => $paymentMethod->meta['webhook_secret'],
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return;
        }

        Model::preventLazyLoading(! app()->isProduction());

        Component::macro('notify', function ($message) {
            $this->dispatchBrowserEvent('notify', $message);
        });

        Livewire::component('setup.wizard', \App\Http\Livewire\Setup\Wizard::class);

        Livewire::component('setup.license-activation', \App\Http\Livewire\Setup\LicenseActivationStep::class);

        Livewire::component('setup.store-information', \App\Http\Livewire\Setup\StoreInformationStep::class);

        Livewire::component('setup.administrator-account', \App\Http\Livewire\Setup\AdministratorAccountStep::class);

        Livewire::component('setup.finalization', \App\Http\Livewire\Setup\FinalizationStep::class);

        View::share('generalSettings', app(GeneralSetting::class));

        View::share('brandSettings', app(BrandSetting::class));

        View::share('layoutSettings', app(LayoutSetting::class));

        View::share('is_local', request()->getHost() == 'localhost' || request()->getHost() == '127.0.0.1' || \Str::endsWith(request()->getHost(), ['.test', '.example', '.invalid', '.local', '.localhost']));

        View::share('is_staging', \Str::startsWith(request()->getHost(), ['dev.', 'demo.', 'test.', 'testing.', 'stage.', 'staging.', 'development.']));
    }
}
