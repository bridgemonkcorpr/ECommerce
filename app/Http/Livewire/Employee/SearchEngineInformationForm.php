<?php

namespace App\Http\Livewire\Employee;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SearchEngineInformationForm extends Component
{
    public Model $model;

    protected function rules()
    {
        return [
            'model.seo_title' => ['nullable', 'string', 'max:70'],
            'model.seo_description' => ['nullable', 'string', 'max:320'],
            'model.slug' => ['required', 'string', 'max:255', Rule::unique($this->model->getTable(), 'slug')->ignore($this->model->id)],
        ];
    }

    public function updatedModelSlug($value)
    {
        $this->model->slug = Str::slug($value);
    }

    public function save()
    {
        $this->validate();

        $this->model->save();

        $this->dispatchBrowserEvent('saved');

        $this->notify(trans('Search engine information updated.'));
    }

    public function render()
    {
        return view('livewire.employee.search-engine-information-form');
    }
}
