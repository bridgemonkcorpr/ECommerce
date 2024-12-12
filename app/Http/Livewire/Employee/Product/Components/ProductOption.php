<?php

namespace App\Http\Livewire\Employee\Product\Components;

use App\Actions\GenerateProductVariant;
use App\Models\Option;
use App\Models\OptionValue;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductOption extends Component
{
    use WithFileUploads;

    public Product $product;

    public Option $option;

    public array $optionValues = [];

    public $images;

    public $showOptionForm = false;

    protected function rules()
    {
        return [
            'option.name' => ['required', 'string'],
            'option.visual' => ['required', 'string', Rule::in(['text', 'color', 'image'])],
            'optionValues' => ['required', 'array', 'min:1'],
            'optionValues.*.product_id' => ['required', 'exists:products,id'],
            'optionValues.*.value' => ['required', 'string', 'distinct:ignore_case'],
            'optionValues.*.label' => ['required', 'string'],
        ];
    }

    protected function messages()
    {
        return [
            'optionValues.*.value.required' => trans('validation.required', ['attribute' => 'value']),
            'optionValues.*.label.required' => trans('validation.required', ['attribute' => 'label']),
        ];
    }

    public function mount()
    {
        $this->product->load('options.optionValues.media');
    }

    public function showOptionForm($optionId = null)
    {
        $this->reset(['optionValues', 'images']);

        $this->resetErrorBag();

        $this->option = $optionId ?
            Option::query()
                ->with(['optionValues' => function ($query) {
                    return $query->select('id', 'product_id', 'option_id', 'value', 'label');
                }])
                ->find($optionId) :
            new Option([
                'product_id' => $this->product->id,
                'visual' => 'text',
            ]);

        $this->optionValues = $optionId ? $this->option->optionValues->toArray() : [$this->makeBlankOptionValue()->toArray()];

        $this->showOptionForm = true;
    }

    public function hideOptionForm()
    {
        $this->reset(['optionValues']);

        $this->product->loadCount('options');

        $this->showOptionForm = false;
    }

    public function addOptionValueInputs()
    {
        $this->optionValues[] = $this->makeBlankOptionValue()->toArray();
    }

    public function deleteOptionValueInputs($index)
    {
        if (array_key_exists('id', $this->optionValues[$index])) return;

        array_splice($this->optionValues, $index, 1);

        if ($this->images) {
            array_splice($this->images, $index, 1);
        }
    }

    public function makeBlankOptionValue()
    {
        return new OptionValue([
            'product_id' => $this->product->id,
            'value' => null,
            'label' => null,
        ]);
    }

    public function updatedImages($value, $index)
    {
        $this->validate([
            'images.*' => 'image',
        ]);

        $this->optionValues[$index]['value'] = $this->images[$index]->getClientOriginalName();
    }

    public function save()
    {
        $this->validate();

        $this->product->options()->save($this->option);

        // find option values has id key
        $optionValuesWithId = collect($this->optionValues)->filter(function ($optionValue) {
            return isset($optionValue['id']);
        });

        // find option values has no id key
        $optionValuesWithoutId = collect($this->optionValues)->filter(function ($optionValue) {
            return ! isset($optionValue['id']);
        });

        // update option values has id key
        OptionValue::upsert($optionValuesWithId->toArray(), 'id', ['value', 'label']);

        // create option values has no id key
        $this->option->optionValues()->createMany($optionValuesWithoutId->toArray());

        if ($this->option->visual === 'image' && $this->images) {
            foreach ($this->option->optionValues()->get() as $index => $newOptionValue) {
                if (array_key_exists($index, $this->images)) {
                    $newOptionValue->addMedia($this->images[$index]->getRealPath())
                        ->usingName($this->images[$index]->getClientOriginalName())
                        ->usingFileName($this->images[$index]->getClientOriginalName())
                        ->toMediaCollection('image');
                }
            }
        }

        $this->product->load('options.optionValues.media');

        $this->generateProductVariant($this->option->wasRecentlyCreated);

        $this->reset(['optionValues', 'images']);

        $this->emitTo('employee.product.product-detail', 'reload');

        $this->hideOptionForm();
    }

    public function generateProductVariant($withNewOption = false)
    {
        if ($withNewOption) {
            $this->product->variants()->delete();

            $productOptionValues = $this->product->optionValues()->get()->groupBy('option_id')->values()->toArray();

            $temporaryVariants = GenerateProductVariant::handle($productOptionValues);
        } else {
            $productOldOptionValues = OptionValue::query()->where('product_id', $this->product->id)->whereNot('option_id', $this->option->id)->get()->groupBy('option_id')->values()->toArray();

            $productNewOptionValues = OptionValue::query()->where('product_id', $this->product->id)->whereDoesntHave('variantAttributes')->get()->groupBy('option_id')->values()->toArray();

            $temporaryOptionsValues = array_merge($productOldOptionValues, $productNewOptionValues);

            $temporaryVariants = GenerateProductVariant::handle($temporaryOptionsValues);

            $temporaryVariants = collect($temporaryVariants)->map(function ($variant) {
                return collect($variant)->sortBy('option_id');
            })->toArray();
        }

        $temporaryVariantAttributes = [];

        $productVariants = $this->product->variants()->createMany(array_fill(0, count($temporaryVariants), [
            'price' => $this->product->price,
        ]));

        foreach ($productVariants as $index => $variant) {
            foreach ($temporaryVariants[$index] as $optionValue) {
                $temporaryVariantAttributes[] = [
                    'product_id' => $variant->product_id,
                    'variant_id' => $variant->id,
                    'option_id' => $optionValue['option_id'],
                    'option_value_id' => $optionValue['id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        $this->product->variantAttributes()->insert($temporaryVariantAttributes);

        $this->emitTo('employee.product.components.product-variant-list', 'reloadProductVariants');
    }

    public function getProductHasOrderProperty()
    {
        return OrderItem::query()->where('product_id', $this->product->id)->exists();
    }

    public function render()
    {
        return view('livewire.employee.product.components.product-option');
    }
}
