<?php

namespace App\Http\Livewire\Employee\User;

use App\Models\Employee;
use Livewire\Component;

class UserList extends Component
{
    public function getEmployeesProperty()
    {
        return Employee::with('media')->get();
    }

    public function render()
    {
        return view('livewire.employee.user.user-list')->layout('layouts.admin');
    }
}
