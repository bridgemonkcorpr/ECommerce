<?php

namespace App\Http\Livewire\Employee\Settings;

use App\Settings\BrandSetting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BrandSettingManager extends Component
{
    use WithFileUploads;

    public array $state = [
        'slogan' => '',
        'short_description' => '',
        'social_links' => [],
    ];

    public $logo_file;

    public $favicon_file;

    public $cover_file;

    protected $rules = [
        'state.slogan' => 'nullable',
        'state.short_description' => 'nullable',
    ];

    public function mount()
    {
        $this->state = [
            'slogan' => $this->brand_settings->slogan,
            'short_description' => $this->brand_settings->short_description,
            'social_links' => $this->brand_settings->social_links,
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->logo_file) {
            tap($this->brandSettings->logo_path, function ($previous) {
                $this->brandSettings->logo_path = $this->logo_file->storePubliclyAs('/', $this->logo_file->getClientOriginalName(), 'public');

                if ($previous) Storage::disk('public')->delete($previous);
            });
        }

        if ($this->favicon_file) {
            tap($this->brandSettings->favicon_path, function ($previous) {
                $this->brandSettings->favicon_path = $this->favicon_file->storePubliclyAs('/', $this->favicon_file->getClientOriginalName(), 'public');

                if ($previous) Storage::disk('public')->delete($previous);
            });
        }

        if ($this->cover_file) {
            tap($this->brandSettings->cover_path, function ($previous) {
                $this->brandSettings->cover_path = $this->cover_file->storePubliclyAs('/', $this->cover_file->getClientOriginalName(), 'public');

                if ($previous) Storage::disk('public')->delete($previous);
            });
        }

        $this->brandSettings->fill($this->state);

        $this->brandSettings->save();

        $this->notify(trans('Settings saved successfully!'));
    }

    public function getBrandSettingsProperty()
    {
        return app(BrandSetting::class);
    }

    public function render()
    {
        return view('livewire.employee.settings.brand-setting-manager')->layout('layouts.admin');
    }
}
