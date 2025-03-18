<?php

namespace App\Http\Controllers;

use App\Models\calamviec;
use App\Models\ChamCong;
use App\Models\ChucVu;
use App\Models\HopDong;
use App\Models\lichlamviec;
use App\Models\NhanVien;
use App\Models\PhongBan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return redirect()->route('Human.Manager')->with('success', 'Cập nhật nhân viên thành công');
    }
    public function ManagerDelete(Request $request, $id)
    {
        $nhanvien = NhanVien::find($id);
        $nhanvien->delete();
        return redirect()->route('Human.Manager')->with('success', 'Xóa nhân viên thành công');
    }
    public function FileAdd(Request $request)
    {

        HopDong::create([
            'nhanvien_id' => $request->nhanvien_id,
            'LoaiHopDong' => $request->LoaiHopDong,
            'ngay_bat_dau' => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'ngay_ky' => $request->ngay_ky,
            'TaiKhoan' => $request->TaiKhoan,
            'NPT' => $request->NPT,
        ]);
        return redirect()->route('Human.Manager')->with('success', 'Thêm hợp đồng thành công');
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
            'PC_Chuc_vu' => $request->PC_Chuc_vu,
            'PC_Trach_nhiem' => $request->PC_Trach_nhiem,
        ]);
        return redirect()->route('Human.ManagerPS')->with('success', 'Thêm chức vụ thành công');
    }
    public function ManagerPSEdit(Request $request, $id)
    {
        $position = ChucVu::find($id);
        $position->update([
            'TenChucVu' => $request->TenChucVu,
            'LuongCoBan' => $request->LuongCoBan,
            'PC_Chuc_vu' => $request->PC_Chuc_vu,
            'PC_Trach_nhiem' => $request->PC_Trach_nhiem,
        ]);
        return redirect()->route('Human.ManagerPS')->with('success', 'Cập nhật chức vụ thành công');
    }
    public function ManagerPSDelete(Request $request, $id)
    {
        $position = ChucVu::find($id);
        $position->delete();
        return redirect()->route('Human.ManagerPS')->with('success', 'Xóa chức vụ thành công');
    }

    public function ShiftManager()
    {
        $shifts = calamviec::all();
        return view('Human.ShiftManager', compact('shifts'));
    }
    public function ShiftManagerAdd(Request $request)
    {
        calamviec::create([
            'TenLoaiCa' => $request->TenLoaiCa,
            'Giobatdau' => $request->Giobatdau,
            'Gioketthuc' => $request->Gioketthuc,
        ]);
        return redirect()->route('Human.ShiftManager')->with('success', 'Thêm ca làm việc thành công');
    }
    public function ShiftManagerUpdate(Request $request, $id)
    {
        $shift = calamviec::find($id);
        $shift->update([
            'TenLoaiCa' => $request->TenLoaiCa,
            'Giobatdau' => $request->Giobatdau,
            'Gioketthuc' => $request->Gioketthuc,
        ]);
        return redirect()->route('Human.ShiftManager')->with('success', 'Cập nhật ca làm việc thành công');
    }
    public function ShiftManagerDelete(Request $request, $id)
    {
        $shift = calamviec::find($id);
        $shift->delete();
        return redirect()->route('Human.ShiftManager')->with('success', 'Xóa ca làm việc thành công');
    }
    public function WorkSchedule()
    {
        $employees = NhanVien::all();
        $shifts = calamviec::all();
        $schedules = lichlamviec::with(['nhanVien', 'caLamViec'])->whereDate('NgayLamViec', '2025-03-03')->get();
        return view('Human.WorkSchedule', compact('schedules', 'employees', 'shifts'));
    }
    public function WorkScheduleAdd(Request $request)
    {
        lichlamviec::create([
            'NgayLamViec' => $request->NgayLamViec,
            'nhanvien_id' => $request->nhanvien_id,
            'ca_id' => $request->ca_id,
            'MoTa' => $request->MoTa,
        ]);
        return redirect()->route('Human.WorkSchedule')->with('success', 'Thêm lịch làm việc thành công');
    }
    public function WorkScheduleUpdate(Request $request, $id)
    {
        $schedule = lichlamviec::find($id);
        $schedule->update([
            'NgayLamViec' => $request->NgayLamViec,
            'nhanvien_id' => $request->nhanvien_id,
            'ca_id' => $request->ca_id,
            'MoTa' => $request->MoTa,
        ]);
        return redirect()->route('Human.WorkSchedule')->with('success', 'Cập nhật lịch làm việc thành công');
    }
    public function WorkScheduleDelete(Request $request, $id)
    {
        $schedule = lichlamviec::find($id);
        $schedule->delete();
        return redirect()->route('Human.WorkSchedule')->with('success', 'Xóa lịch làm việc thành công');
    }
    public function Timekeeping(Request $request)
    {

        $employees = NhanVien::all();
        $ngayLamViec = '2025-03-03';

        $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
            ->where('nhanvien_id', 1)
            ->get();
        $nhanvien = NhanVien::find(1);
        if ($request->employee) {
            $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                ->where('nhanvien_id', $request->employee)
                ->get();
            $nhanvien = NhanVien::find($request->employee);
        }
        return view('Human.Timekeeping', compact('timekeepings', 'employees', 'nhanvien'));
    }
}
