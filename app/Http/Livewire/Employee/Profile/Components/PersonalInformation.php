<?php

namespace App\Http\Livewire\Employee\Profile\Components;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class PersonalInformation extends Component
{
    use WithFileUploads;

    public $avatarFile;

    public $avatarMaxSize = 1024;

    public $state = [
        'name' => '',
        'email' => '',
        'bio' => '',
        'website' => '',
    ];

    protected $messages = [
        'state.name.required' => 'The name field is required.',
        'state.email.required' => 'The email field is required.',
        'state.email.email' => 'The email must be a valid email address.',
        'state.email.unique' => 'The email has already been taken.',
        'state.website.url' => 'The website format is invalid.',
    ];

    public function mount()
    {
        $this->state = [
            'name' => $this->user->name,
            'email' => $this->user->email,
            'bio' => $this->user->bio,
            'website' => $this->user->website,
        ];
    }

    public function updatedAvatarFile()
    {
        $validator = \Validator::make(
            ['avatarFile' => $this->avatarFile],
            ['avatarFile' => ['nullable', 'image', 'max:' . $this->avatarMaxSize]],
        );

        if ($validator->fails()) {
            $this->addError('avatarFile', $validator->errors()->first('avatarFile'));

            $this->reset('avatarFile');
        }
    }

    public function save()
    {
        $this->validate([
            'state.name' => ['required'],
            'state.email' => ['required', 'email', Rule::unique('employees', 'email')->ignore($this->user->id)],
            'state.bio' => ['nullable'],
            'state.website' => ['nullable', 'url'],
        ]);

        $this->user->update([
            'name' => $this->state['name'],
            'email' => $this->state['email'],
            'bio' => $this->state['bio'],
            'website' => $this->state['website'],
        ]);

        if ($this->avatarFile) {
            $this->user->addMedia($this->avatarFile->getRealPath())->toMediaCollection('avatar');

            $this->reset('avatarFile');
        }

        $this->notify(trans('Profile updated successfully.'));
    }

    public function getUserProperty()
    {
        return \Auth::user();
    }

    public function render()
    {
        return view('livewire.employee.profile.components.personal-information');
    }
}
