<?php

namespace App\Http\Livewire\Traits;

trait WithBulkActions
{
    public bool $selectPage = false;
    public bool $selectAll = false;
    public array $selected = [];

    public function updatedSelectPage()
    {
        $this->selectAll = false;
        $this->selected = $this->selectPage
            ? $this->rows->pluck('id')->map(fn($id) => (string)$id)->toArray()
            : [];
    }

    public function updatedSelectAll()
    {
        $this->selectPage = $this->selectAll;
        $this->selected = $this->selectAll
            ? $this->rowsQuery->pluck('id')->map(fn($id) => (string)$id)->toArray()
            : [];
    }

    public function updatedSelected()
    {
        $diffs = array_diff($this->rows->pluck('id')->toArray(), $this->selected);

        $this->selectPage = ! count($diffs);

        $this->selectAll = false;

        $this->selected = array_keys(array_count_values($this->selected));
    }

    public function clearSelection()
    {
        $this->reset('selected', 'selectPage', 'selectAll');
    }
}
