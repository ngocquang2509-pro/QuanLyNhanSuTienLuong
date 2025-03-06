<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        return view('Accounting.dashboard');
    }
    public function salary()
    {
        return view('Accounting.salary');
    }
    public function payment()
    {
        return view('Accounting.payment');
    }
}
