<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CTOController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('Human.dashboard');
    }
    public function Admin()
    {
        return view('CTO.Admin');
    }
}
