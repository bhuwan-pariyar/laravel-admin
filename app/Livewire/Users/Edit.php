<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    public $userId;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $status = 'active';
    public $user;

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
        $this->userId = $this->user->id;
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->status = $this->user->status ?? 'active';
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId)],
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ];
    }

    protected $messages = [
        'name.required' => 'The name field is required.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already taken.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    public function update()
    {
        $validated = $this->validate();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => $validated['status'],
        ];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $this->user->update($data);

        $this->dispatch('closeModal');
        $this->dispatch('itemUpdated');

        session()->flash('success', 'User updated successfully!');
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
