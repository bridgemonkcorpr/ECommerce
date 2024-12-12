<?php
namespace App\Http\Livewire\Setup;

use App\Settings\GeneralSetting;
use Spatie\LivewireWizard\Components\StepComponent;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LicenseActivationStep extends StepComponent
{
    public $item_id = '38755184';

    public $state = [
        'license_key' => '',
        'license_user' => '',
        'license_vendor' => 'Envato',
        'license_active' => false,
    ];

    protected function rules()
    {
        return [
            'state.license_key' => [
                'required',
                'string',
                'uuid',
                function ($attribute, $value, $fail) {
                    if (!$this->validateLicenseKey($value)) {
                        $fail(trans('The license key is invalid or could not be verified.'));
                    }
                },
            ],
        ];
    }

    protected function messages()
    {
        return [
            'state.license_key.required' => trans('License key is required.'),
            'state.license_key.uuid' => trans('The license key must be a valid UUID format.'),
        ];
    }

    public function mount()
    {
        $this->state['license_key'] = $this->generalSettings->license_key;
        $this->state['license_user'] = $this->generalSettings->license_user;
        $this->state['license_vendor'] = $this->generalSettings->license_vendor;
        $this->state['license_active'] = $this->generalSettings->license_active;
    }

    /**
     * Validate license key through various methods
     *
     * @param string $licenseKey
     * @return bool
     */
    protected function validateLicenseKey(string $licenseKey): bool
    {
        // 1. Basic format validation
        if (!Str::isUuid($licenseKey)) {
            return false;
        }

        // 2. Vendor-specific validation (Envato)
        if ($this->state['license_vendor'] === 'Envato') {
            return $this->validateEnvatoLicense($licenseKey);
        }

        // 3. Custom validation for other vendors
        return $this->validateCustomVendorLicense($licenseKey);
    }

    /**
     * Validate Envato license key
     *
     * @param string $licenseKey
     * @return bool
     */
    protected function validateEnvatoLicense(string $licenseKey): bool
    {
        try {
            // Example Envato license verification
            // Note: Replace with actual Envato API endpoint and authentication
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.envato.token'),
            ])->get('https://api.envato.com/v3/market/buyer/purchase', [
                'code' => $licenseKey,
                'item_id' => $this->item_id,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Additional verification checks
                $this->state['license_user'] = $data['buyer'] ?? '';
                return true;
            }

            return false;
        } catch (\Exception $e) {
            // Log the error
            logger()->error('License verification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Validate license key for custom vendors
     *
     * @param string $licenseKey
     * @return bool
     */
    protected function validateCustomVendorLicense(string $licenseKey): bool
    {
        // Implement custom vendor-specific validation
        // This could involve:
        // - Checking against a local database
        // - Calling a third-party license verification service
        // - Performing specific checks based on vendor requirements

        return false; // Placeholder
    }

    public function skip()
    {
        $this->nextStep();
    }

    public function save()
    {
        $this->validate();

        $this->generalSettings->license_key = $this->state['license_key'];
        $this->generalSettings->license_user = $this->state['license_user'];
        $this->generalSettings->license_vendor = $this->state['license_vendor'];
        $this->generalSettings->license_active = true;
        $this->generalSettings->save();

        $this->nextStep();
    }

    public function getGeneralSettingsProperty()
    {
        return app(GeneralSetting::class);
    }

    public function render()
    {
        return view('livewire.setup.license-activation-step');
    }
}
