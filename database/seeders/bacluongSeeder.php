<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BacLuongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bacluong')->insert([
            ['id' => 1, 'ten' => 'Bậc 1', 'MoTa' => 'Công tác < 1 năm'],
            ['id' => 2, 'ten' => 'Bậc 2', 'MoTa' => 'Công tác 2-5 năm'],
            ['id' => 3, 'ten' => 'Bậc 3', 'MoTa' => 'Công tác 5-8 năm'],
            ['id' => 4, 'ten' => 'Bậc 4', 'MoTa' => 'Công tác > 8 năm'],
        ]);
    }
}
