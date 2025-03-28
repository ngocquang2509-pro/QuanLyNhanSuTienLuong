<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChamCongSeeder extends Seeder
{
    public function run()
    {
        $id = 1;

        // Lấy danh sách lịch làm việc của nhân viên chính thức
        $lichLamViecChinhThuc = DB::table('lichlamviec')
            ->join('nhanvien', 'lichlamviec.nhanvien_id', '=', 'nhanvien.id')
            ->join('hopdong', 'nhanvien.id', '=', 'hopdong.nhanvien_id')
            ->join('calamviec', 'lichlamviec.ca_id', '=', 'calamviec.id')
            ->where('hopdong.LoaiHopDong', 'Nhân viên chính thức')
            ->select('lichlamviec.id as lichlamviec_id', 'lichlamviec.nhanvien_id', 'calamviec.GioBatDau', 'calamviec.GioKetThuc')
            ->get();

        // Lấy danh sách lịch làm việc của nhân viên thời vụ
        $lichLamViecThoiVu = DB::table('lichlamviec')
            ->join('nhanvien', 'lichlamviec.nhanvien_id', '=', 'nhanvien.id')
            ->join('hopdong', 'nhanvien.id', '=', 'hopdong.nhanvien_id')
            ->join('calamviec', 'lichlamviec.ca_id', '=', 'calamviec.id')
            ->where('hopdong.LoaiHopDong', 'Nhân viên thời vụ')
            ->select('lichlamviec.id as lichlamviec_id', 'lichlamviec.nhanvien_id', 'calamviec.GioBatDau', 'lichlamviec.NgayLamViec')
            ->get();

        // Các trạng thái chấm công
        $trangThaiChamCong = [
            ['ten' => 'Đúng giờ', 'he_so_tru' => 0, 'delay_minutes' => 0],
            ['ten' => 'Muộn 6 đến 30 phút', 'he_so_tru' => 0.06, 'delay_minutes' => rand(6, 30)],
            ['ten' => 'Muộn 30 đến 60 phút', 'he_so_tru' => 0.12, 'delay_minutes' => rand(30, 60)],
        ];

        $dataChamCong = [];

        // Xử lý chấm công cho nhân viên chính thức
        foreach ($lichLamViecChinhThuc as $lich) {
            $randomStatus = $trangThaiChamCong[array_rand($trangThaiChamCong)];
            $gioVao = date('H:i:s', strtotime($lich->GioBatDau . " +{$randomStatus['delay_minutes']} minutes"));

            $dataChamCong[] = [
                'id'             => $id++,
                'nhanvien_id'    => $lich->nhanvien_id,
                'lichlamviec_id' => $lich->lichlamviec_id,
                'GioVao'         => $gioVao,
                'GioRa'          => $lich->GioKetThuc,
                'NguonMay'       => 'Máy chấm công',
                'SoCong'         => 1 - $randomStatus['he_so_tru'],
                'TrangThai'      => $randomStatus['ten'],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        // Xử lý chấm công cho nhân viên thời vụ
        foreach ($lichLamViecThoiVu as $lich) {
            // Chọn số công ngẫu nhiên (1 công = 8 giờ)
            $soCong = rand(4, 6);
            $soGioLam = $soCong * 8; // Số giờ làm việc trong ngày

            // Tính giờ vào và giờ ra thực tế
            $gioVao = Carbon::parse($lich->GioBatDau);
            $gioRa = $gioVao->copy()->addHours($soCong);

            $dataChamCong[] = [
                'id'             => $id++,
                'nhanvien_id'    => $lich->nhanvien_id,
                'lichlamviec_id' => $lich->lichlamviec_id,
                'GioVao'         => $gioVao->format('H:i:s'),
                'GioRa'          => $gioRa->format('H:i:s'),
                'NguonMay'       => 'Máy chấm công',
                'SoCong'         => $soCong,
                'TrangThai'      => 'Đúng giờ',
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        }

        // Chèn dữ liệu vào bảng chấm công
        DB::table('chamcong')->insert($dataChamCong);
    }
}
