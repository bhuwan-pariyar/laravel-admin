<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\FileUploadService;
use App\Http\Resources\UserResource;

class UserRepository implements UserRepositoryInterface
{
    protected $fileUploadService;
    public function __construct( FileUploadService $fileUploadService )
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function getUser()
    {
        $user = auth()->user();

        return new UserResource($user);
    }

    public function updateProfile($payload): User
    {
        $user = auth()->user();
        $user->fill($payload);
        $user->save();

        return $user;
    }

    public function uploadImage($request): User
    {
        $user = auth()->user();

        if (!$request->hasFile('pic')) {
            return $user;
        }

        return DB::transaction(function () use ($request, $user) {
            $user->pic = $this->fileUploadService
                ->uploadImage($request->file('pic'), $user, 'pic');
            $user->save();

            return $user;
        });
    }

    public function changePassword($payload): User
    {
        $user = auth()->user();
        $user->fill($payload);
        $user->save();

        return $user;
    }

    public function create(array $data): User
    {
        return User::create($data);
    }
}
