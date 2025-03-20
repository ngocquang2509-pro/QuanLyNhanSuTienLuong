<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\salary;
use Illuminate\Http\Request;
use DB;
use App\Models\PhongBan;

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
        ->whereHas('hopDong', function($query) {
            $query->where('LoaiHopDong', 'Chính thức');
        })
        ->get();

    // Lấy nhân viên có LoaiHopDong là "Thời vụ"
    $nhanvienthoivus = NhanVien::with(['hopDong', 'chucVu', 'phongBan'])
        ->whereHas('hopDong', function($query) {
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
        $departments = PhongBan::all();
        return view('Accounting.payment', compact('departments'));
    }

    public function getSalariesByDepartment(Request $request)
    {
        try {
            $departmentId = $request->departmentId;
            $month = $request->month ?? date('Y-m');
            
            $monthParts = explode('-', $month);
            $monthNumber = isset($monthParts[1]) ? $monthParts[1] : date('m');
            $year = isset($monthParts[0]) ? $monthParts[0] : date('Y');
            
            \Log::info('Fetching salaries', [
                'departmentId' => $departmentId,
                'month' => $month,
                'monthNumber' => $monthNumber,
                'year' => $year
            ]);
            
            // Lấy tên phòng ban
            $departmentName = DB::table('phongban')->where('id', $departmentId)->value('TenPhongBan');
            
            if (!$departmentName) {
                return response()->json(['error' => 'Không tìm thấy phòng ban'], 404);
            }
            
            // Lấy dữ liệu từ bảng _luong
            $salaries = DB::table('_luong')
                        ->leftJoin('nhanvien', '_luong.HoTen', '=', 'nhanvien.HoTen')
                        ->where('_luong.PhongBan', $departmentName)
                        ->whereMonth('_luong.NgayTao', $monthNumber)
                        ->whereYear('_luong.NgayTao', $year)
                        ->select(
                            '_luong.id',
                            '_luong.HoTen',
                            '_luong.ChucVu',
                            '_luong.PhongBan',
                            '_luong.LuongCB as LuongCoBan',  // Đổi tên cột khi trả về
                            '_luong.pc_chuc_vu',
                            '_luong.pc_trach_nhiem',
                            '_luong.SoNgayCong',
                            '_luong.TongThuNhap',
                            '_luong.bhxh',
                            '_luong.bhyt',
                            '_luong.thue_tncn',
                            '_luong.luong_thuc_lanh',
                            '_luong.tam_ung',
                            '_luong.con_lanh',
                            '_luong.NgayThanhToan',
                            'nhanvien.id as MaNV'
                        )
                        ->get();
            
            // Xử lý khi không có MaNV
            if ($salaries->count() > 0) {
                foreach ($salaries as $salary) {
                    if (is_null($salary->MaNV)) {
                        // Tìm nhân viên với tên tương ứng
                        $nhanvien = DB::table('nhanvien')->where('HoTen', $salary->HoTen)->first();
                        if ($nhanvien) {
                            $salary->MaNV = $nhanvien->id;
                        } else {
                            $salary->MaNV = 0; // Gán giá trị mặc định
                        }
                    }
                }
            }
            
            \Log::info('Found ' . count($salaries) . ' salaries');
            
            return response()->json($salaries);
        } catch (\Exception $e) {
            \Log::error('Error in getSalariesByDepartment: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function paySalary(Request $request)
    {
        $salaryId = $request->salaryId;
        
        try {
            DB::table('_luong')
                ->where('id', $salaryId)
                ->update([
                    'NgayThanhToan' => now(),
                    'updated_at' => now()
                ]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Thanh toán lương thành công!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error paying salary: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false, 
                'message' => 'Có lỗi xảy ra khi thanh toán lương: ' . $e->getMessage()
            ], 500);
        }
    }
}