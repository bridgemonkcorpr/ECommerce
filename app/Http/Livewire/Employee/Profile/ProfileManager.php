<?php

namespace App\Http\Livewire\Employee\Profile;

use Livewire\Component;

class ProfileManager extends Component
{
    public function render()
    {
        return view('livewire.employee.profile.profile-manager')->layout('layouts.admin');
    }
}
