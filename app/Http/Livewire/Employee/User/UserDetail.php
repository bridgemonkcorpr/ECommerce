<?php

namespace App\Http\Livewire\Employee\User;

use App\Models\Employee;
use Livewire\Component;

class UserDetail extends Component
{
    public Employee $employee;

    protected $listeners = ['refresh' => '$refresh'];

    public $confirmingAccessSuspension = false;

    public $confirmingEmployeeRemoval = false;

    public $state = [
        'name' => '',
        'email' => '',
        'bio' => '',
        'website' => '',
    ];

    protected function rules()
    {
        return [
            'state.name' => 'required',
            'state.email' => 'required|email|unique:employees,email,' . $this->employee->id,
            'state.password' => 'sometimes|required|min:8',
            'state.bio' => 'nullable',
            'state.website' => 'nullable|url',
        ];
    }

    public function mount()
    {
        abort_if(!auth()->user()->is_admin, 403);

        $this->employee = Employee::find(request()->user);

        $this->state = [
            'name' => $this->employee->name,
            'email' => $this->employee->email,
            'bio' => $this->employee->bio,
            'website' => $this->employee->website,
        ];
    }

    public function save()
    {
        $this->validate();

        $this->employee->name = $this->state['name'];

        $this->employee->email = $this->state['email'];

        $this->employee->bio = $this->state['bio'];

        $this->employee->website = $this->state['website'];

        if (request()->filled('password')) {
            $this->employee->password = bcrypt($this->state['password']);
        }

        $this->employee->save();

        $this->notify(trans('User profile was updated successfully.'));
    }

    public function confirmAccessSuspension()
    {
        $this->confirmingAccessSuspension = true;
    }

    public function suspendAccess()
    {
        $this->employee->ban();

        $this->confirmingAccessSuspension = false;

        $this->emit('refresh')->self();
    }

    public function restoreAccess()
    {
        $this->employee->unban();

        $this->emit('refresh')->self();
    }

    public function confirmEmployeeRemoval()
    {
        $this->confirmingEmployeeRemoval = true;
    }

    public function removeEmployee()
    {
        $this->employee->delete();

        $this->redirect(route('employee.settings.user.list'));
    }

    public function render()
    {
        return view('livewire.employee.user.user-detail')->layout('layouts.admin');
    }
}
