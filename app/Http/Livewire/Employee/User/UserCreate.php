<?php

namespace App\Http\Livewire\Employee\User;

use App\Models\Employee;
use Livewire\Component;

class UserCreate extends Component
{
    public Employee $employee;

    public $state = [
        'name' => '',
        'email' => '',
        'password' => '',
        'is_admin' => false,
    ];

    protected $rules = [
        'state.name' => 'required',
        'state.email' => 'required|email|unique:employees,email',
        'state.password' => 'required|min:8',
    ];

    public function mount()
    {
        abort_if(!auth()->user()->is_admin, 403);

        $this->employee = new Employee();

        $this->employee->makeVisible('is_admin');

        if (request()->filled('admin') && request()->admin) {
            $this->state['is_admin'] = true;
        }
    }

    public function save()
    {
        $this->validate();

        $this->employee->name = $this->state['name'];

        $this->employee->email = $this->state['email'];

        $this->employee->password = bcrypt($this->state['password']);

        $this->employee->is_admin = $this->state['is_admin'];

        $this->employee->save();

        $this->redirect(route('employee.settings.user.list'));
    }

    public function render()
    {
        return view('livewire.employee.user.user-create')->layout('layouts.admin');
    }
}
