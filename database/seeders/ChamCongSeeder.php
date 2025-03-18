<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChamCongSeeder extends Seeder
{
    public function run()
    {
        $id = 1;
        // Lấy tất cả lịch làm việc của nhân viên
        $lichLamViecs = DB::table('lichlamviec')
            ->join('calamviec', 'lichlamviec.ca_id', '=', 'calamviec.id')
            ->select('lichlamviec.id as lichlamviec_id', 'lichlamviec.nhanvien_id', 'calamviec.GioBatDau', 'calamviec.GioKetThuc')
            ->get();

        // Các trạng thái chấm công theo bảng trừ công
        $trangThaiChamCong = [
            ['ten' => 'Đúng giờ', 'he_so_tru' => 0, 'delay_minutes' => 0],
            ['ten' => 'Muộn 6 đến 30 phút', 'he_so_tru' => 0.06, 'delay_minutes' => rand(6, 30)],
            ['ten' => 'Muộn 30 đến 60 phút', 'he_so_tru' => 0.12, 'delay_minutes' => rand(30, 60)],
        ];

        $dataChamCong = [];

        foreach ($lichLamViecs as $lich) {
            // Chọn ngẫu nhiên trạng thái chấm công
            $randomStatus = $trangThaiChamCong[array_rand($trangThaiChamCong)];

            // Xử lý giờ vào theo trạng thái
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

        // Chèn dữ liệu vào bảng chấm công
        DB::table('chamcong')->insert($dataChamCong);
    }
}
