<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bacluongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bacluong')->insert([
            ['ten' => 'Bậc 1', 'MoTa' => 'Công tác < 1 năm'],
            ['ten' => 'Bậc 2', 'MoTa' => 'Công tác 3-5 năm'],
            ['ten' => 'Bậc 3', 'MoTa' => 'Công tác 5-8 năm'],
        ]);
    }
}
