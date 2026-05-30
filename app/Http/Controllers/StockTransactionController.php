<?php

namespace App\Http\Controllers;

class StockTransactionController extends Controller
{
    public function list()
    {
        return view('transactions.index');
    }

    public function create()
    {
        return view('transactions.form');
    }
}
