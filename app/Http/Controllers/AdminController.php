<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }
    public function HR_Manager()
    {

        return view('admin.HR_Manager', compact('users'));
    }
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'type' => ['required'],
        ]);
        $credentials['password'] = bcrypt($credentials['password']);
        User::create($credentials);
        return redirect()->route('admin.dashboard')->with('success', 'Thêm tài khoản thành công');
    }
    public function update(Request $request, $id)
    {
        if ($request->password != '') {
            $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required'],
                'password' => ['required'],
                'type' => ['required'],
            ]);
            $credentials['password'] = bcrypt($credentials['password']);
        } else {
            $credentials = $request->validate([
                'name' => ['required'],
                'email' => ['required'],
                'type' => ['required'],
            ]);
        }
        User::find($id)->update($credentials);
        return redirect()->route('admin.dashboard')->with('success', 'Cập nhật tài khoản thành công');
    }
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('admin.dashboard')->with('success', 'Xóa tài khoản thành công');
    }
}
