<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([

            [
                'name' => 'Hải',
                'email' => 'Hai123@gmail.com',
                'password' => Hash::make('123'),
                'type' => 'HMN',
                'created_at' => '2025-02-19 03:39:52',
                'updated_at' => '2025-02-22 02:45:01',
            ],
            [
                'name' => 'Phương',
                'email' => 'thuphuong@gmail.com',
                'password' => Hash::make('123'),
                'type' => 'ACC',
                'created_at' => '2025-02-19 03:42:15',
                'updated_at' => '2025-02-22 02:45:12',
            ],
            [
                'name' => 'Phat',
                'email' => 'phat@gmail.com',
                'password' => Hash::make('123'),
                'type' => 'CTO',
                'created_at' => '2025-02-26 04:41:30',
                'updated_at' => '2025-02-26 04:41:30',
            ],
        ]);
    }
}
