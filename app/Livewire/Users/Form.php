<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Repositories\User\UserRepository;
use App\Services\UploadService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Form extends Component
{
    use WithFileUploads;

    public ?int $userId = null;
    public ?User $user = null;

    public $name = '';
    public $username = '';
    public $email = '';
    public $address = '';
    public $pic;
    public $password = '';
    public $password_confirmation = '';
    public $status = true;

    public function mount(?int $userId = null)
    {
        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->userId = $this->user->id;

            $this->fill([
                'name' => $this->user->name,
                'username' => $this->user->username,
                'email' => $this->user->email,
                'address' => $this->user->address,
                'pic' => $this->user->pic,
                'status' => $this->user->status,
            ]);
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->userId),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->userId),
            ],
            'address' => 'required|string|max:255',
            'pic' => [
                $this->userId ? 'nullable' : 'required',
                'image',
                'max:2048',
            ],
            'password' => [
                $this->userId ? 'nullable' : 'required',
                'min:8',
                'confirmed',
            ],
            'status' => 'required|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $uploadService = app(UploadService::class);
        $repository = app(UserRepository::class);

        if ($this->pic instanceof TemporaryUploadedFile) {
            $validated['pic'] = $uploadService->uploadImage(
                $this->pic,
                $this->user,
                'pic',
                'users'
            );
        } else {
            unset($validated['pic']);
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user = $this->userId
            ? $repository->update($this->userId, $validated)
            : $repository->create($validated);

        session()->flash(
            'message',
            $this->userId ? 'User Updated Successfully.' : 'User Created Successfully.'
        );

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('users.list');
    }

    public function render()
    {
        return view('livewire.users.form');
    }
}
