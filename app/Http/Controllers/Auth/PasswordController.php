<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use App\Repositories\User\UserRepositoryInterface;

class PasswordController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', Password::defaults()],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        $response = $this->userRepository->changePassword([
            'password' => Hash::make($validated['new_password']),
        ]);

        if ($response instanceof User)
        {
            return back()->with(['message' => 'Password Changed Successfully.', 'alert-type' => 'success']);
        }
        return back()->with(['message' => 'Something went wrong.', 'alert-type' => 'error']);
    }
}
