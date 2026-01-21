<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function list()
    {
        return view('categories.index');
    }

    public function create()
    {
        return view('categories.form');
    }

    public function edit($categoryId)
    {
        return view('categories.form');
    }

    public function show($categoryId)
    {
        return view('categories.show');
    }
}
