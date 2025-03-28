<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BacLuongChucVuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bacluong_chucvu')->insert([
            ['id' => 1, 'chucvu_id' => 1, 'bacluong_id' => 1, 'HeSo' => 1.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'chucvu_id' => 1, 'bacluong_id' => 2, 'HeSo' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'chucvu_id' => 1, 'bacluong_id' => 3, 'HeSo' => 2.80, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'chucvu_id' => 2, 'bacluong_id' => 1, 'HeSo' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'chucvu_id' => 2, 'bacluong_id' => 2, 'HeSo' => 2.80, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'chucvu_id' => 2, 'bacluong_id' => 3, 'HeSo' => 3.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'chucvu_id' => 2, 'bacluong_id' => 4, 'HeSo' => 3.50, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'chucvu_id' => 3, 'bacluong_id' => 1, 'HeSo' => 1.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'chucvu_id' => 3, 'bacluong_id' => 2, 'HeSo' => 2.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'chucvu_id' => 3, 'bacluong_id' => 3, 'HeSo' => 2.80, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'chucvu_id' => 4, 'bacluong_id' => 1, 'HeSo' => 3.00, 'created_at' => null, 'updated_at' => null],
            ['id' => 12, 'chucvu_id' => 4, 'bacluong_id' => 2, 'HeSo' => 3.00, 'created_at' => null, 'updated_at' => null],
            ['id' => 13, 'chucvu_id' => 4, 'bacluong_id' => 3, 'HeSo' => 3.50, 'created_at' => null, 'updated_at' => null],
            ['id' => 14, 'chucvu_id' => 4, 'bacluong_id' => 4, 'HeSo' => 4.00, 'created_at' => null, 'updated_at' => null],
        ]);
    }
}
