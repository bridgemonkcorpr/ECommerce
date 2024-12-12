<?php

namespace App\Http\Livewire\Employee\Collection;

use App\Http\Livewire\Traits\WithBulkActions;
use App\Models\Collection;
use Livewire\Component;
use Livewire\WithPagination;

class CollectionList extends Component
{
    use WithBulkActions;

    use WithPagination;

    public $perPage = 10;

    public $showNewCollectionCreationModal = false;

    public $newCollection = [
        'title' => '',
        'description' => '',
    ];

    public $showDeleteConfirmationModal = false;

    public $search = '';

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    protected $rules = [
        'newCollection.title' => 'required|string',
        'newCollection.description' => 'nullable|string',
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPage()
    {
        $this->clearSelection();
    }

    public function deleteSelected()
    {
        Collection::query()->whereIn('id', $this->selected)->delete();

        $this->reset('selectAll', 'selectPage', 'selected');

        $this->showDeleteConfirmationModal = false;
    }

    public function createNewCollection()
    {
        $this->reset('newCollection');

        $this->showNewCollectionCreationModal = true;
    }

    public function saveNewCollection()
    {
        $this->validate();

        $collection = new Collection();

        $collection->title = $this->newCollection['title'];

        $collection->description = $this->newCollection['description'];

        $collection->save();

        $this->showNewCollectionCreationModal = false;

        $this->redirect(route('employee.collections.detail', $collection));
    }

    public function getRowsQueryProperty()
    {
        return Collection::query()
            ->with('media')
            ->withCount('products')
            ->when($this->search, fn($query, $search) => $query->where('title', 'like', '%' . $search . '%'))
            ->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.employee.collection.collection-list', [
            'collections' => $this->rows,
        ])->layout('layouts.admin');
    }
}
