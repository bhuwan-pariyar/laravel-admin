<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function getUser();
    public function updateProfile($payload): User;
    public function uploadImage(Request $request): User;
    public function changePassword($payload): User;
}
