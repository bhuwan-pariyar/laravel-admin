<?php

namespace App\Http\Controllers;

use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
    }

    public function create()
    {
        return view('items.form');
    }

    public function edit($itemId)
    {
        return view('items.form');
    }

    public function show($itemId)
    {
        return view('items.show');
    }
}
