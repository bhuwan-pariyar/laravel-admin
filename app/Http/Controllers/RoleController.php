<?php

namespace App\Http\Controllers;

class RoleController extends Controller
{
    public function list()
    {
        return view('roles.index');
    }

    public function create()
    {
        return view('roles.form');
    }

    public function edit($roleId)
    {
        return view('roles.form');
    }
}
