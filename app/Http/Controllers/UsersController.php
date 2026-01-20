<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function list()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.form');
    }

    public function edit()
    {
        return view('users.form');
    }

    public function show()
    {
        return view('users.show');
    }
}
