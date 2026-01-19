<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('profile.user', compact('user'));
    }

    public function list()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.form');
    }

    public function show()
    {
        return view('users.show');
    }
}
