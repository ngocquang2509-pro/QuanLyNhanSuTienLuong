<?php

namespace App\Http\Controllers;

use App\Models\calamviec;
use App\Models\ChamCong;
use App\Models\ChucVu;
use App\Models\HopDong;
use App\Models\lichlamviec;
use App\Models\NhanVien;
use App\Models\PhongBan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HumanController extends Controller
{
    public function index(Request $request)
    {
        $departments = PhongBan::all();
        $dateWork = '2025-03-03'; // Hoặc lấy từ request: $request->dateWork
        $department = PhongBan::find(1); // Hoặc lấy từ request nếu cần
        $departmentName = $department->TenPhongBan;
        if ($request->dateWork) {
            $dateWork = $request->dateWork;
        }
        if ($request->department) {
            $department = PhongBan::find($request->department);
            $departmentName = $department->TenPhongBan;
        }
        $nhanviendunggio = NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
            $query->where('TrangThai', 'Đúng giờ')
                ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                    $subQuery->where('NgayLamViec', $dateWork);
                });
        })->whereHas('phongBan', function ($query) use ($departmentName) {
            $query->where('TenPhongBan', $departmentName);
        })->count();
        $nhanviendimuon = NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
            $query->where('TrangThai', 'Muộn 6 đến 30 phút')
                ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                    $subQuery->where('NgayLamViec', $dateWork);
                });
        })->whereHas('phongBan', function ($query) use ($departmentName) {
            $query->where('TenPhongBan', $departmentName);
        })->count() + NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
            $query->where('TrangThai', 'Muộn 30 đến 60 phút')
                ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                    $subQuery->where('NgayLamViec', $dateWork);
                });
        })->whereHas('phongBan', function ($query) use ($departmentName) {
            $query->where('TenPhongBan', $departmentName);
        })->count();
        $nhanvienvangmat = NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
            $query->where('TrangThai', 'Vắng mặt')
                ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                    $subQuery->where('NgayLamViec', $dateWork);
                });
        })->whereHas('phongBan', function ($query) use ($departmentName) {
            $query->where('TenPhongBan', $departmentName);
        })->count();
        $date = Carbon::parse($dateWork);
        $startOfWeek = $date->copy()->startOfWeek(); // Lấy thứ 2 của tuần
        $endOfWeek = $date->copy()->endOfWeek(); // Lấy chủ nhật của tuần

        $days = [];
        $dataset1 = [];
        $dataset2 = [];
        $dataset3 = [];

        for ($day = $startOfWeek; $day->lte($endOfWeek); $day->addDay()) {
            $days[] = $day->toDateString(); // Lưu lại các ngày trong tuần
        }
        foreach ($days as $day) {
            $part1 = NhanVien::whereHas('chamCongs', function ($query) use ($day) {
                $query->where('TrangThai', 'Đúng giờ')
                    ->whereHas('lichLamViec', function ($subQuery) use ($day) {
                        $subQuery->where('NgayLamViec', $day);
                    });
            })->whereHas('phongBan', function ($query) use ($departmentName) {
                $query->where('TenPhongBan', $departmentName);
            })->count();
            $part2 = NhanVien::whereHas('chamCongs', function ($query) use ($day) {
                $query->where('TrangThai', 'Muộn 6 đến 30 phút')
                    ->whereHas('lichLamViec', function ($subQuery) use ($day) {
                        $subQuery->where('NgayLamViec', $day);
                    });
            })->whereHas('phongBan', function ($query) use ($departmentName) {
                $query->where('TenPhongBan', $departmentName);
            })->count() + NhanVien::whereHas('chamCongs', function ($query) use ($day) {
                $query->where('TrangThai', 'Muộn 30 đến 60 phút')
                    ->whereHas('lichLamViec', function ($subQuery) use ($day) {
                        $subQuery->where('NgayLamViec', $day);
                    });
            })->whereHas('phongBan', function ($query) use ($departmentName) {
                $query->where('TenPhongBan', $departmentName);
            })->count();
            $part3 = NhanVien::whereHas('chamCongs', function ($query) use ($day) {
                $query->where('TrangThai', 'Vắng mặt')
                    ->whereHas('lichLamViec', function ($subQuery) use ($day) {
                        $subQuery->where('NgayLamViec', $day);
                    });
            })->whereHas('phongBan', function ($query) use ($departmentName) {
                $query->where('TenPhongBan', $departmentName);
            })->count();
            $dataset1[] = $part1;
            $dataset2[] = $part2;
            $dataset3[] = $part3;
        }
        $TongNV = 0;
        $datasetDeparment1 = [];
        $datasetDeparment2 = [];
        $datasetDeparment3 = [];
        foreach ($departments as $department) {
            $TenPB = $department->TenPhongBan;
            $part1 = NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
                $query->where('TrangThai', 'Đúng giờ')
                    ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                        $subQuery->where('NgayLamViec', $dateWork);
                    });
            })->whereHas('phongBan', function ($query) use ($TenPB) {
                $query->where('TenPhongBan', $TenPB);
            })->count();
            $part2 = NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
                $query->where('TrangThai', 'Muộn 6 đến 30 phút')
                    ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                        $subQuery->where('NgayLamViec', $dateWork);
                    });
            })->whereHas('phongBan', function ($query) use ($TenPB) {
                $query->where('TenPhongBan', $TenPB);
            })->count() + NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
                $query->where('TrangThai', 'Muộn 30 đến 60 phút')
                    ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                        $subQuery->where('NgayLamViec', $dateWork);
                    });
            })->whereHas('phongBan', function ($query) use ($TenPB) {
                $query->where('TenPhongBan', $TenPB);
            })->count();
            $part3 = NhanVien::whereHas('chamCongs', function ($query) use ($dateWork) {
                $query->where('TrangThai', 'Vắng mặt')
                    ->whereHas('lichLamViec', function ($subQuery) use ($dateWork) {
                        $subQuery->where('NgayLamViec', $dateWork);
                    });
            })->whereHas('phongBan', function ($query) use ($TenPB) {
                $query->where('TenPhongBan', $TenPB);
            })->count();

            $TongNV =  NhanVien::where('MaPhongBan', $department->id)->count();

            $datasetDeparment1[] = (($part1 / $TongNV) * 100);
            $datasetDeparment2[] = (($part2 / $TongNV) * 100);
            $datasetDeparment3[] = (($part3 / $TongNV) * 100);
        }
        if ($request->department) {
            $department = PhongBan::find($request->department);
            $departmentName = $department->TenPhongBan;
        }

        return view('Human.dashboard', compact('nhanviendunggio', 'nhanviendimuon', 'nhanvienvangmat', 'departments', 'days', 'dateWork', 'department', 'dataset1', 'dataset2', 'dataset3', 'datasetDeparment1', 'datasetDeparment2', 'datasetDeparment3'));
    }
    public function ChartHuman()
    {
        $nhanviens = NhanVien::all()->count();
        return view('Human.chartHuman', compact('nhanviens'));
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
        $departments = PhongBan::all();
        $employees = NhanVien::all();
        $nhanvien = null;

        // Lấy ngày làm việc từ request, nếu không có thì mặc định là hôm nay
        $ngayLamViec = $request->dateWork ?? '2025-03-03';

        // Mặc định lấy công của nhân viên có id = 1 theo ngày làm việc
        $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
            ->whereHas('lichLamViec', function ($query) use ($ngayLamViec) {
                $query->where('NgayLamViec', $ngayLamViec);
            })
            ->get();
        if ($timekeepings->isEmpty()) {
            $timekeepings = collect(); // Trả về một collection rỗng thay vì null
        }
        // Nếu có lọc theo nhân viên
        if ($request->employee) {
            $nhanvien = NhanVien::find($request->employee);
        }

        // Nếu có lọc theo phòng ban
        if ($request->department) {
            $employeesInDepartment = NhanVien::where('MaPhongBan', $request->department)->pluck('id');
        }

        // Nếu cả employee và department cùng tồn tại
        if ($request->employee && $request->department) {
            if ($nhanvien && in_array($request->employee, $employeesInDepartment->toArray())) {
                $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                    ->where('nhanvien_id', $request->employee)
                    ->get();
            } else {
                $timekeepings = collect(); // Nếu nhân viên không thuộc phòng ban, trả về danh sách rỗng
            }
        } elseif ($request->department && $request->dateWork) {
            $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                ->whereIn('nhanvien_id', $employeesInDepartment)
                ->whereHas('lichLamViec', function ($query) use ($ngayLamViec) {
                    $query->where('NgayLamViec', $ngayLamViec);
                })
                ->get();
        } elseif ($request->employee && $request->dateWork) {
            $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                ->where('nhanvien_id', $request->employee)
                ->whereHas('lichLamViec', function ($query) use ($ngayLamViec) {
                    $query->where('NgayLamViec', $ngayLamViec);
                })
                ->get();
        }
        // Nếu chỉ có phòng ban
        elseif ($request->department) {
            $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                ->whereIn('nhanvien_id', $employeesInDepartment)
                ->get();
        }
        // Nếu chỉ có nhân viên
        elseif ($request->employee) {
            $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                ->where('nhanvien_id', $request->employee)
                ->get();
        }
        if ($request->employee && $request->department && $request->dateWork) {
            $timekeepings = ChamCong::with(['nhanVien', 'lichLamViec'])
                ->where('nhanvien_id', $request->employee)
                ->whereHas('lichLamViec', function ($query) use ($ngayLamViec) {
                    $query->where('NgayLamViec', $ngayLamViec);
                })
                ->get();
        }
        return view('Human.Timekeeping', compact('timekeepings', 'employees', 'nhanvien', 'departments'));
    }
}
