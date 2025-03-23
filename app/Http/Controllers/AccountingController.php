<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\salary;
use Illuminate\Http\Request;
use DB;
use App\Models\PhongBan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

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
        $salaries = FacadesDB::table('_luong')->get();
        return view('Accounting.salary', compact('salaries'));
    }
    public function salaryAdd(Request $request)
    {
        // Tạm thời vô hiệu hóa kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa tất cả dữ liệu trong bảng _phieu_luong
        DB::table('_phieu_luong')->truncate();

        // Xóa tất cả dữ liệu trong bảng _luong
        DB::table('_luong')->truncate();

        // Bật lại kiểm tra khóa ngoại
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Lấy tất cả nhân viên cùng với các mối quan hệ cần thiết
        $nhanviens = NhanVien::with(['chucVu', 'phongBan', 'hopDong', 'chamCongs', 'lichLamViec', 'ktkls'])->get();

        // Lấy tháng hiện tại
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        foreach ($nhanviens as $nv) {
            // Bỏ qua nếu không có chức vụ hoặc phòng ban
            if (!$nv->chucVu || !$nv->phongBan) {
                continue;
            }
            $heSoLuong = 1;
            $KTKL = 0;
            $NPT = 0;
            if (isset($nv->hopDong)) {
                $soNamLamViec = floor(Carbon::parse($nv->hopDong->ngay_bat_dau)->diffInYears(Carbon::now()));
                if ($soNamLamViec < 1) {
                    $bacLuongID = 1; // Bậc 1
                } elseif ($soNamLamViec >= 2 && $soNamLamViec < 5) {
                    $bacLuongID = 2; // Bậc 2
                } elseif ($soNamLamViec >= 5 && $soNamLamViec < 8) {
                    $bacLuongID = 3; // Bậc 3
                } else {
                    $bacLuongID = 3; // Mặc định Bậc 3 nếu > 8 năm
                }
                $heSoLuong = DB::table('bacluong_chucvu')
                    ->where('chucvu_id', $nv->MaChucVu) // Lấy theo chức vụ
                    ->where('bacluong_id', $bacLuongID) // Lấy theo bậc lương
                    ->value('HeSo');
                $KTKL = DB::table('_khen_thuong_ki_luat_nhan_vien')
                    ->where('nhanvien_id', $nv->id)
                    ->sum('NoiDung');
                $NPT = $nv->hopDong->NPT;
            }
            // Tính toán các giá trị lương
            $luongCB = $nv->chucVu->LuongCoBan ?? 5000000;
            $pcChucVu = $nv->chucVu->PC_Chuc_vu ?? 500000;
            $pcTrachNhiem = $nv->chucVu->PC_Trach_nhiem ?? 300000;

            // Lấy số ngày công từ dữ liệu chấm công thực tế của tháng hiện tại
            $soNgayCong = 0;

            try {
                // Lấy tổng số công từ bảng chamcong cho tháng và năm hiện tại
                $soNgayCong = DB::table('chamcong')
                    ->join('lichlamviec', 'chamcong.lichlamviec_id', '=', 'lichlamviec.id')
                    ->where('chamcong.nhanvien_id', $nv->id)
                    ->whereMonth('lichlamviec.NgayLamViec', $currentMonth)
                    ->whereYear('lichlamviec.NgayLamViec', $currentYear)
                    ->sum('chamcong.SoCong');

                // Nếu không có dữ liệu chấm công, kiểm tra từ lịch làm việc
                if ($soNgayCong == 0) {
                    // Đếm số ngày làm việc từ lịch làm việc
                    $soNgayCong = DB::table('lichlamviec')
                        ->where('nhanvien_id', $nv->id)
                        ->whereMonth('NgayLamViec', $currentMonth)
                        ->whereYear('NgayLamViec', $currentYear)
                        ->count();
                }
            } catch (\Exception $e) {
                // Ghi log lỗi nhưng không dừng chương trình
                \Log::error('Lỗi khi lấy dữ liệu chấm công: ' . $e->getMessage());
            }

            // Nếu vẫn không có dữ liệu, bỏ qua nhân viên này
            if ($soNgayCong == 0) {
                continue;
            }

            // Tính tổng thu nhập dựa trên ngày công đúng theo công thức trong salary.blade.php
            $tongThuNhap = ($luongCB * $heSoLuong / 26) * $soNgayCong + $pcChucVu + $pcTrachNhiem + $KTKL;
            $tongThuNhap = round($tongThuNhap);

            // Tỷ lệ đóng BHXH, BHYT, BHTN của người lao động - chính xác từ salary.blade.php
            $tyLeBHXH_NLD = 0.08;  // 8.0%
            $tyLeBHYT_NLD = 0.015; // 1.5%
            $tyLeBHTN_NLD = 0.01;  // 1.0%

            // Tính các khoản khấu trừ bảo hiểm dựa trên tổng lương và phụ cấp
            // Cơ sở tính đóng BHXH, BHYT, BHTN chính xác từ salary.blade.php
            $tongLuongBaoHiem = $luongCB + $pcChucVu + $pcTrachNhiem;
            $bhxh = round($tongLuongBaoHiem * $tyLeBHXH_NLD);
            $bhyt = round($tongLuongBaoHiem * $tyLeBHYT_NLD);
            $bhtn = round($tongLuongBaoHiem * $tyLeBHTN_NLD);
            $tongBH = $bhxh + $bhyt + $bhtn;

            // Tính thuế thu nhập cá nhân - giảm trừ gia cảnh
            $giamTruGiaCanh = 11000000;
            $giamTruNguoiPhuThuoc = 0;

            // Kiểm tra và tính giảm trừ người phụ thuộc từ hợp đồng
            if ($nv->hopDong && isset($nv->hopDong->NPT)) {
                $giamTruNguoiPhuThuoc = $nv->hopDong->NPT * 4400000;
            }

            // Tính thu nhập chịu thuế - chính xác từ salary.blade.php
            $thuNhapChiuThue = $tongThuNhap - $giamTruGiaCanh - $giamTruNguoiPhuThuoc - $tongBH;
            $thueTncn = 0;

            // Chỉ tính thuế nếu thu nhập chịu thuế > 0
            if ($thuNhapChiuThue > 0) {
                // Biểu thuế lũy tiến theo cách tính giống trong salary.blade.php
                if ($thuNhapChiuThue <= 5000000) {
                    // Bậc 1: Đến 5 triệu => 5% x TNTT
                    $thueTncn = $thuNhapChiuThue * 0.05;
                } elseif ($thuNhapChiuThue <= 10000000) {
                    // Bậc 2: Trên 5 triệu đến 10 triệu => 10% x TNTT - 0,25 triệu
                    $thueTncn = $thuNhapChiuThue * 0.1 - 250000;
                } elseif ($thuNhapChiuThue <= 18000000) {
                    // Bậc 3: Trên 10 triệu đến 18 triệu => 15% x TNTT - 0,75 triệu
                    $thueTncn = $thuNhapChiuThue * 0.15 - 750000;
                } elseif ($thuNhapChiuThue <= 32000000) {
                    // Bậc 4: Trên 18 triệu đến 32 triệu => 20% x TNTT - 1,65 triệu
                    $thueTncn = $thuNhapChiuThue * 0.2 - 1650000;
                } elseif ($thuNhapChiuThue <= 52000000) {
                    // Bậc 5: Trên 32 triệu đến 52 triệu => 25% x TNTT - 3,25 triệu
                    $thueTncn = $thuNhapChiuThue * 0.25 - 3250000;
                } elseif ($thuNhapChiuThue <= 80000000) {
                    // Bậc 6: Trên 52 triệu đến 80 triệu => 30% x TNTT - 5,85 triệu
                    $thueTncn = $thuNhapChiuThue * 0.3 - 5850000;
                } else {
                    // Bậc 7: Trên 80 triệu => 35% x TNTT - 9,85 triệu
                    $thueTncn = $thuNhapChiuThue * 0.35 - 9850000;
                }
            }

            // Đảm bảo thuế không âm - giống trong salary.blade.php
            if ($thueTncn < 0) {
                $thueTncn = 0;
            } else {
                $thueTncn = round($thueTncn);
            }

            // Tính lương thực lãnh
            $luongThucLanh = $tongThuNhap - $bhxh - $bhyt - $bhtn - $thueTncn;

            // Tạm ứng cố định 2,000,000 VND như trong salary.blade.php
            $tamUng = 2000000;
            $conLanh = $luongThucLanh - $tamUng;

            // Tạo bản ghi lương sử dụng DB facade
            DB::table('_luong')->insert([
                'nhanvien_id' => $nv->id,
                'HoTen' => $nv->HoTen,
                'NPT' => $NPT,
                'ChucVu' => $nv->chucVu->TenChucVu,
                'PhongBan' => $nv->phongBan->TenPhongBan,
                'HSL' => $heSoLuong,
                'KTKL' => $KTKL,
                'LuongCB' => $luongCB,
                'pc_chuc_vu' => $pcChucVu,
                'pc_trach_nhiem' => $pcTrachNhiem,
                'SoNgayCong' => $soNgayCong,
                'TongThuNhap' => $tongThuNhap,
                'bhxh' => $bhxh,
                'bhyt' => $bhyt,
                'bhtn' => $bhtn,
                'thue_tncn' => $thueTncn,
                'luong_thuc_lanh' => $luongThucLanh,
                'tam_ung' => $tamUng,
                'con_lanh' => $conLanh,
                'tam_ung' => $tamUng,
                'con_lanh' => $conLanh,
                'NgayTao' => Carbon::now()->format('Y-m-d'),
                'NgayThanhToan' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'NgayThanhToan' => null,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        return redirect()->route('Accounting.salary');
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
                    '_luong.bhtn',
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
