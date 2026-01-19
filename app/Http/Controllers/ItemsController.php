<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        return view('users.index');
        // return view('items.index');
    }

    public function create()
    {
        return view('users.form');
    }
}
