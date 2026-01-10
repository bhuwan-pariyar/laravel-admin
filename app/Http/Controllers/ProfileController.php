<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\User\UserRepositoryInterface;

class ProfileController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $user = $this->userRepository->getUser();
        return view('profile.user', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->user()->isDirty('email')) {
            $validated['email_verified_at'] = null;
        }

        $response = $this->userRepository->updateProfile($validated);

        if ($response instanceof User) {
            return redirect()->route('profile.index')->with(['message' => 'Profile Updated Successfully.', 'alert-type' => 'success']);
        }

        return redirect()->route('profile.index')->with(['message' => 'Something went wrong.', 'alert-type' => 'error']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'pic' => 'required|image|max:2048', // max 2MB
        ]);
        $response = $this->userRepository->uploadImage($request);
        if ($response instanceof User) {
            return redirect()->route('profile.index')->with(['message' => 'Profile Image Saved Successfully.', 'alert-type' => 'success']);
        }
        return redirect()->route('profile.index')->with(['message' => 'Something went wrong.', 'alert-type' => 'error']);
    }
}
