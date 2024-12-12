<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Models\Meta;
use App\Models\Product;
use Livewire\Component;

class ProductSpecification extends Component
{
    public Product $product;

    public Meta $specificationBeingUpdated;

    public Meta $specificationBeingDeleted;

    public $editingSpecification = false;

    public $confirmingSpecificationDeletion = false;

    protected $rules = [
        'specificationBeingUpdated.key' => 'required',
        'specificationBeingUpdated.name' => 'required',
        'specificationBeingUpdated.value' => 'required',
    ];

    public function mount()
    {
        $this->product->load('specifications');

        $this->specificationBeingUpdated = new Meta([
            'key' => 'specifications',
            'value' => '',
        ]);
    }

    public function makeBlankSpecification(): Meta
    {
        return new Meta([
            'key' => 'specifications',
            'value' => '',
        ]);
    }

    public function create()
    {
        $this->specificationBeingUpdated = $this->makeBlankSpecification();

        $this->editingSpecification = true;
    }

    public function edit(Meta $specification)
    {
        $this->specificationBeingUpdated = $specification;

        $this->editingSpecification = true;
    }

    public function save()
    {
        $this->validate();

        $this->specificationBeingUpdated->metable()->associate($this->product);

        $this->specificationBeingUpdated->save();

        $this->specificationBeingUpdated = $this->makeBlankSpecification();

        $this->product->load('specifications');

        $this->editingSpecification = false;
    }

    public function confirmSpecificationDeletion(Meta $specification)
    {
        $this->specificationBeingDeleted = $specification;

        $this->editingSpecification = false;

        $this->confirmingSpecificationDeletion = true;
    }

    public function deleteSpecification()
    {
        $this->specificationBeingDeleted->delete();

        $this->confirmingSpecificationDeletion = false;

        $this->specificationBeingUpdated = $this->makeBlankSpecification();

        $this->product->load('specifications');
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-specification');
    }
}
