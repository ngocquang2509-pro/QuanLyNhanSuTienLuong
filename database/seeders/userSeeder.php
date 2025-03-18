<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            [
                'name' => 'quang',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'ADM',
                'created_at' => '2025-02-19 02:34:08',
                'updated_at' => '2025-02-21 03:15:20',
            ],
            [
                'name' => 'Hải',
                'email' => 'Hai123@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'HMN',
                'created_at' => '2025-02-19 03:39:52',
                'updated_at' => '2025-02-22 02:45:01',
            ],
            [
                'name' => 'Phương',
                'email' => 'thuphuong@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'ACC',
                'created_at' => '2025-02-19 03:42:15',
                'updated_at' => '2025-02-22 02:45:12',
            ],
            [
                'name' => 'phat ngu',
                'email' => 'phat@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'ACC',
                'created_at' => '2025-02-26 04:41:30',
                'updated_at' => '2025-02-26 04:41:30',
            ],
        ]);
    }
}
