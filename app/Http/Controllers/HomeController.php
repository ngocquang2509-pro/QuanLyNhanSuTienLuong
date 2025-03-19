<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }

    public function check(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            if (Auth::user()->type == 'ADM') {
                return redirect()->route('admin.dashboard');
            } else if (Auth::user()->type == 'HMN') {
                return redirect()->route('Human.dashboard');
            } else if (Auth::user()->type == 'CTO') {
                return redirect()->route('CTO.dashboard');
            } else {
                return redirect()->route('Accounting.dashboard');
            }
        }
        return redirect()->route('auth.login')->with('error', 'Tài khoản hoặc mật khẩu không tồn tại');
    }
}
