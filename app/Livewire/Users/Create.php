<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepository;

class Create extends Component
{
    use WithFileUploads;
    public $name = '';
    public $username = '';
    public $email = '';
    public $address = '';
    public $pic = '';
    public $password = '';
    public $password_confirmation = '';
    public $status = true;
    protected FileUploadService $fileUploadService;
    protected UserRepository $userRepository;

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'address' => 'required|string|max:255',
        'pic' => 'required|image|max:2048',
        'password' => 'required|string|min:8|confirmed',
        'status' => 'required|boolean',
    ];

    protected $messages = [
        'name.required' => 'The name field is required.',
        'email.required' => 'The email field is required.',
        'username.required' => 'The username field is required.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'address.required' => 'The address field is required.',
        'pic.required' => 'The profile image field is required.',
        'password.required' => 'The password field is required.',
        'password.min' => 'Password must be at least 8 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    public function mount(FileUploadService $fileUploadService, UserRepository $userRepository)
    {
        $this->fileUploadService = $fileUploadService;
        $this->userRepository = $userRepository;
    }

    public function save()
    {
        $validated = $this->validate();

        $response = $this->userRepository->create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'pic' => $this->fileUploadService->uploadImage($this->pic, null, 'users'),
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
        ]);

        if ($response instanceof User) {
            session()->flash('message', 'User Created Successfully.');
            session()->flash('alert-type', 'success');

            return $this->redirectRoute('users.list');
        }

        session()->flash('message', 'Something went wrong.');
        session()->flash('alert-type', 'error');

        return $this->redirectRoute('users.create');
    }

    public function render()
    {
        return view('livewire.users.create');
    }
}
