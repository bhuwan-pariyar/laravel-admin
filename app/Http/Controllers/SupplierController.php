<?php

namespace App\Http\Controllers;

class SupplierController extends Controller
{
    public function list()
    {
        return view('suppliers.index');
    }

    public function create()
    {
        return view('suppliers.form');
    }

    public function edit($supplierId)
    {
        return view('suppliers.form');
    }

    public function show($supplierId)
    {
        return view('suppliers.show');
    }
}
