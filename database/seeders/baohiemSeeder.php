<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class baohiemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('baohiem')->insert([
            ['TenBaoHiem' => 'BHXH', 'HeSo' => 8.0],
            ['TenBaoHiem' => 'BHYT', 'HeSo' => 1.5],
            ['TenBaoHiem' => 'BHTN', 'HeSo' => 1.0],
        ]);
    }
}
