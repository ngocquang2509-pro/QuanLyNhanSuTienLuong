<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\salary;
use Illuminate\Http\Request;

class AccountingController extends Controller
{
    public function index()
    {
        $nhanviens = NhanVien::all()->count();
        return view('Accounting.dashboard', compact('nhanviens'));
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
    public function salaryAdd(Request $request)
    {
        $salaries = $request->input('salaries');

        if (!$salaries) {
            return response()->json(['success' => false, 'message' => 'Không có dữ liệu lương!'], 400);
        }
        $savedSalaries = [];
        foreach ($salaries as $salary) {
            salary::create($salary); // Lưu vào database
        }


        return response()->json([
            'success' => true,
            'message' => 'Lương đã được lưu!',
            'data' => $savedSalaries
        ]);
    }


    public function payment()
    {
        return view('Accounting.payment');
    }
}
