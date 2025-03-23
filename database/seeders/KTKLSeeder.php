<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KTKLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('_khen_thuong_ki_luat')->insert([
            ['Loai' => 'Khen thưởng', 'NoiDung' => 'Khen thưởng'],
            ['Loai' => 'Kỷ luật', 'NoiDung' => 'Kỷ luật'],
        ]);
    }
}
