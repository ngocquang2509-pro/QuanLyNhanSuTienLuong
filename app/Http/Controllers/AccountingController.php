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
        $salaryMax = salary::max('TongThuNhap');
        $salaryMin = salary::min('TongThuNhap');
        $salaryAvg = salary::avg('TongThuNhap');
        $HanhChinhAvg = salary::where('PhongBan', 'Hành chính')->avg('TongThuNhap');
        $KinhDoanhAvg = salary::where('PhongBan', 'Kinh doanh')->avg('TongThuNhap');
        $KyThuatAvg = salary::where('PhongBan', 'Kĩ thuật')->avg('TongThuNhap');
        $NhanSuAvg = salary::where('PhongBan', 'Nhân sự')->avg('TongThuNhap');
        $KeToanAvg = salary::where('PhongBan', 'Kế toán')->avg('TongThuNhap');
        $SanXuatAvg = salary::where('PhongBan', 'Sản xuất')->avg('TongThuNhap');
        $NghienCuuAvg = salary::where('PhongBan', 'Nghiên cứu và phát triển')->avg('TongThuNhap');

        return view('Accounting.dashboard', compact('nhanviens', 'salaryMax', 'salaryMin', 'salaryAvg', 'HanhChinhAvg', 'KinhDoanhAvg', 'KyThuatAvg', 'NhanSuAvg', 'KeToanAvg', 'SanXuatAvg', 'NghienCuuAvg'));
    }
    public function salary(Request $request)
    {
        $month = Carbon::now()->format('Y-m');
        if ($request->has('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month)->format('Y-m');
        }
        // Lấy danh sách lương của nhân viên chính thức, sắp xếp theo tổng thu nhập giảm dần
        $salaries = FacadesDB::table('_luong')
            ->join('nhanvien', '_luong.nhanvien_id', '=', 'nhanvien.id') // Join bảng nhân viên
            ->join('hopdong', 'nhanvien.id', '=', 'hopdong.nhanvien_id') // Join bảng hợp đồng
            ->where('hopdong.LoaiHopDong', 'Nhân viên chính thức') // Lọc theo loại hợp đồng
            ->whereYear('_luong.NgayTao', Carbon::parse($month)->year)  // Lọc theo năm
            ->whereMonth('_luong.NgayTao', Carbon::parse($month)->month) // Lọc theo tháng
            ->select('_luong.*', 'nhanvien.HoTen', 'hopdong.LoaiHopDong') // Chọn các cột cần thiết
            ->orderByDesc('_luong.TongThuNhap') // Sắp xếp theo tổng thu nhập giảm dần
            ->get();

        // Lấy danh sách lương của nhân viên thời vụ, sắp xếp theo tổng thu nhập giảm dần
        $salariesThoiVu = FacadesDB::table('_luong')
            ->join('nhanvien', '_luong.nhanvien_id', '=', 'nhanvien.id') // Join bảng nhân viên
            ->join('hopdong', 'nhanvien.id', '=', 'hopdong.nhanvien_id') // Join bảng hợp đồng
            ->where('hopdong.LoaiHopDong', 'Nhân viên thời vụ') // Lọc theo loại hợp đồng
            ->whereYear('_luong.NgayTao', Carbon::parse($month)->year)  // Lọc theo năm
            ->whereMonth('_luong.NgayTao', Carbon::parse($month)->month) // Lọc theo tháng
            ->select('_luong.*', 'nhanvien.HoTen', 'hopdong.LoaiHopDong') // Chọn các cột cần thiết
            ->orderByDesc('_luong.TongThuNhap') // Sắp xếp theo tổng thu nhập giảm dần
            ->get();

        return view('Accounting.salary', compact('salaries', 'salariesThoiVu'));
    }

    public function salaryAdd(Request $request)
    {
        // Tạm thời vô hiệu hóa kiểm tra khóa ngoại
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Xóa tất cả dữ liệu trong bảng _phieu_luong
        //DB::table('_phieu_luong')->truncate();

        // Xóa tất cả dữ liệu trong bảng _luong
        //DB::table('_luong')->truncate();

        // Bật lại kiểm tra khóa ngoại
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Lấy tất cả nhân viên cùng với các mối quan hệ cần thiết
        $nhanviens = NhanVien::with(['chucVu', 'phongBan', 'hopDong'])
            ->whereHas('hopDong', function ($query) {
                $query->where('LoaiHopDong', 'Nhân viên chính thức');
            })
            ->get();
        $nhanviensThoiVu = NhanVien::with(['chucVu', 'phongBan', 'hopDong'])
            ->whereHas('hopDong', function ($query) {
                $query->where('LoaiHopDong', 'Nhân viên thời vụ');
            })
            ->get();
        // Lấy tháng hiện tại
        $currentMonth = Carbon::createFromFormat('Y-m', $request->month)->month;

        $currentYear = Carbon::createFromFormat('Y-m', $request->month)->year;

        //Kiểm tra tháng có tồn tại không trong bang _luong
        $checkMonth = DB::table('_luong')
            ->whereMonth('NgayTao', $currentMonth)
            ->whereYear('NgayTao', $currentYear)
            ->exists();

        if ($checkMonth == 1) {
            return redirect()->route('Accounting.salary');
        } else {
            foreach ($nhanviensThoiVu as $nhanvien) {
                $soNgayCong = DB::table('chamcong')
                    ->join('lichlamviec', 'chamcong.lichlamviec_id', '=', 'lichlamviec.id')
                    ->where('chamcong.nhanvien_id', $nhanvien->id)
                    ->whereMonth('lichlamviec.NgayLamViec', $currentMonth)
                    ->whereYear('lichlamviec.NgayLamViec', $currentYear)
                    ->sum('chamcong.SoCong');

                DB::table('_luong')->insert([
                    'nhanvien_id' => $nhanvien->id,
                    'HoTen' => $nhanvien->HoTen,
                    'ChucVu' => $nhanvien->chucVu->TenChucVu,
                    'PhongBan' => $nhanvien->phongBan->TenPhongBan,
                    'SoNgayCong' => $soNgayCong,
                    'TongThuNhap' => $nhanvien->TongSoCong * $nhanvien->hopDong->LuongCoBan,
                    'LuongTheoGio' => $nhanvien->hopDong->LuongCoBan,
                    'NgayTao' => Carbon::createFromFormat('Y-m', $request->month)->format('Y-m-d'),
                ]);
            }
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
                $luongCB = $nv->hopDong->LuongCoBan ?? 5000000;
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
                    'NgayTao' => Carbon::createFromFormat('Y-m', $request->month)->format('Y-m-d'),
                    'NgayThanhToan' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'NgayThanhToan' => null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        return redirect()->route('Accounting.salary');
    }

    public function payment(Request $request)
    {
        $departments = PhongBan::all();
        $salaries = [];
        $department = $request->department;
        if (isset($request->department)) {
            $salaries = DB::table('_luong')->where('PhongBan', $request->department)->get();
        }

        return view('Accounting.payment', compact('departments', 'salaries', 'department'));
    }

    public function record(Request $request)
    {

        $salaries = FacadesDB::table('_luong')
            ->join('nhanvien', '_luong.nhanvien_id', '=', 'nhanvien.id')
            ->select('nhanvien.id', 'nhanvien.HoTen', '_luong.TongThuNhap', '_luong.NgayTao')
            ->orderBy('nhanvien.id')
            ->orderBy('_luong.NgayTao')
            ->get()
            ->groupBy('HoTen'); // Nhóm theo nhân viên
        $nhanviens = NhanVien::with(['phongBan'])->get();
        return view('Accounting.record', compact('salaries', 'nhanviens'));
    }


    public function paySalary(Request $request)
    {
        if (isset($request->status)) {
            DB::table('_luong')
                ->where('PhongBan', $request->department)
                ->update(['TrangThai' => 1]);
        }
        return redirect()->route('Accounting.payment', ['department' => $request->department]);
    }
    public function show($id)
    {
        $luongs = DB::table('_luong')
            ->where('nhanvien_id', $id)
            ->orderBy('NgayTao', 'desc')
            ->get();

        if ($luongs->isEmpty()) {
            return response()->json(['error' => 'Không tìm thấy dữ liệu lương'], 404);
        }

        $salaryData = $luongs->map(function ($luong) {
            return [
                'Thang' => Carbon::parse($luong->NgayTao)->format('m/Y'),
                'HoTen' => $luong->HoTen,
                'SoNgayCong' => $luong->SoNgayCong,
                'TongThuNhap' => number_format($luong->TongThuNhap, 0, ',', '.'),
                'TamUng' => number_format($luong->tam_ung, 0, ',', '.'),
                'ConLanh' => number_format($luong->con_lanh, 0, ',', '.')
            ];
        });

        return response()->json([
            'luong' => $salaryData
        ]);
    }
}
