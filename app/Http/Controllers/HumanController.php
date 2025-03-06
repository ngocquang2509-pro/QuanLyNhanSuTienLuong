<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use App\Models\HopDong;
use App\Models\NhanVien;
use App\Models\PhongBan;
use Illuminate\Http\Request;

class HumanController extends Controller
{
    public function index()
    {
        return view('Human.dashboard');
    }
    public function ManagerHM()
    {
        $departments = PhongBan::all();
        $positions = ChucVu::all();
        $employees = NhanVien::with(['chucVu', 'phongBan', 'hopDong'])->get();
        return view('Human.ManagerHM', compact('employees', 'departments', 'positions'));
    }
    public function ManagerHMFindDeparment(Request $request)
    {
        $id = $request->department;
        $positions = ChucVu::all();
        $departments = PhongBan::all();
        $departmentFind = PhongBan::find($id);
        $employees = NhanVien::where('MaPhongBan', $id)->with(['chucVu', 'phongBan', 'hopDong'])->get();
        return view('Human.ManagerHM', compact('employees', 'departments', 'departmentFind', 'positions'));
    }
    public function ManagerAdd(Request $request)
    {

        $nhanvien = NhanVien::create([
            'HoTen' => $request->HoTen,
            'GioiTinh' => $request->GioiTinh,
            'NgaySinh' => $request->NgaySinh,
            'CCCD' => $request->CCCD,
            'DienThoai' => $request->DienThoai,
            'Email' => $request->Email,
            'DiaChi' => $request->DiaChi,
            'MaPhongBan' => $request->MaPhongBan,
            'MaChucVu' => $request->MaChucVu,
        ]);

        return redirect()->route('Human.Manager')->with('success', 'Thêm nhân viên thành công');
    }
    public function ManagerUpdate(Request $request, $id)
    {
        $nhanvien = NhanVien::find($id);
        if (isset($nhanvien->HopDong)) {
            $nhanvien->update([
                'HoTen' => $request->HoTen,
                'GioiTinh' => $request->GioiTinh,
                'NgaySinh' => $request->NgaySinh,
                'CCCD' => $request->CCCD,
                'DienThoai' => $request->DienThoai,
                'Email' => $request->Email,
                'DiaChi' => $request->DiaChi,
                'MaPhongBan' => $request->MaPhongBan,
                'MaChucVu' => $request->MaChucVu,
            ]);
            $hopdong = HopDong::where('nhanvien_id', $id)->first();
            $hopdong->update([
                'LoaiHopDong' => $request->LoaiHopDong,
                'ngay_bat_dau' => $request->ngay_bat_dau,
                'ngay_ket_thuc' => $request->ngay_ket_thuc,
                'ngay_ky' => $request->ngay_ky,
                'noi_dung' => $request->noi_dung,
                'TaiKhoan' => $request->TaiKhoan,

            ]);
        } else {
            $nhanvien->update([
                'HoTen' => $request->HoTen,
                'GioiTinh' => $request->GioiTinh,
                'NgaySinh' => $request->NgaySinh,
                'CCCD' => $request->CCCD,
                'DienThoai' => $request->DienThoai,
                'Email' => $request->Email,
                'DiaChi' => $request->DiaChi,
                'MaPhongBan' => $request->MaPhongBan,
                'MaChucVu' => $request->MaChucVu,
            ]);
            HopDong::create([
                'nhanvien_id' => $id,
                'LoaiHopDong' => $request->LoaiHopDong,
                'ngay_bat_dau' => $request->ngay_bat_dau,
                'ngay_ket_thuc' => $request->ngay_ket_thuc,
                'ngay_ky' => $request->ngay_ky,
                'noi_dung' => $request->noi_dung,
                'TaiKhoan' => $request->TaiKhoan,
            ]);
        }
        return redirect()->route('Human.Manager')->with('success', 'Cập nhật hợp đồng thành công');
    }
    public function FileDelete(Request $request, $id)
    {
        $HopDong = HopDong::find($id);
        $HopDong->delete();
        return redirect()->route('Human.Manager')->with('success', 'Xóa hợp đồng thành công');
    }
    public function ManagerDP()
    {
        $departments = PhongBan::withCount('nhanviens')->get();
        return view('Human.department', compact('departments'));
    }
    public function DepartmentAdd(Request $request)
    {
        PhongBan::create([
            'TenPhongBan' => $request->TenPhongBan,
        ]);
        return redirect()->route('Human.ManagerDP')->with('success', 'Thêm phòng ban thành công');
    }
    public function DepartmentEdit(Request $request, $id)
    {
        $department = PhongBan::find($id);
        $department->update([
            'TenPhongBan' => $request->TenPhongBan,
        ]);
        return redirect()->route('Human.ManagerDP')->with('success', 'Cập nhật phòng ban thành công');
    }
    public function DepartmentDelete(Request $request, $id)
    {
        $department = PhongBan::find($id);
        $department->delete();
        return redirect()->route('Human.ManagerDP')->with('success', 'Xóa phòng ban thành công');
    }
    public function ManagerPS()
    {
        $positions = ChucVu::all();
        return view('Human.position', compact('positions'));
    }
    public function ManagerPSAdd(Request $request)
    {
        ChucVu::create([
            'TenChucVu' => $request->TenChucVu,
            'LuongCoBan' => $request->LuongCoBan,
        ]);
        return redirect()->route('Human.ManagerPS')->with('success', 'Thêm chức vụ thành công');
    }
    public function ManagerPSEdit(Request $request, $id)
    {
        $position = ChucVu::find($id);
        $position->update([
            'TenChucVu' => $request->TenChucVu,
            'LuongCoBan' => $request->LuongCoBan,
        ]);
        return redirect()->route('Human.ManagerPS')->with('success', 'Cập nhật chức vụ thành công');
    }
    public function ManagerPSDelete(Request $request, $id)
    {
        $position = ChucVu::find($id);
        $position->delete();
        return redirect()->route('Human.ManagerPS')->with('success', 'Xóa chức vụ thành công');
    }
    public function Timekeeping()
    {
        return view('Human.Timekeeping');
    }
}
