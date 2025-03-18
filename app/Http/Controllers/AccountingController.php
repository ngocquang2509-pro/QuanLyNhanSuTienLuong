<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        return view('Accounting.dashboard');
    }
    public function salary()
    {
        // Lấy nhân viên có LoaiHopDong là "Chính thức"
        $nhanvienchinhthucs = NhanVien::with(['hopDong', 'chucVu', 'phongBan'])
            ->whereHas('hopDong', function ($query) {
                $query->where('LoaiHopDong', 'Chính thức');
            })
            ->get();

        // Lấy nhân viên có LoaiHopDong là "Thời vụ"
        $nhanvienthoivus = NhanVien::with(['hopDong', 'chucVu', 'phongBan'])
            ->whereHas('hopDong', function ($query) {
                $query->where('LoaiHopDong', 'Thời vụ');
            })
            ->get();

        return view('Accounting.salary', compact('nhanvienchinhthucs', 'nhanvienthoivus'));
    }


    public function payment()
    {
        return view('Accounting.payment');
    }
}
