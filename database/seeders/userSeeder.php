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
        $users = [
            [
                'name' => 'quang',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'ADM',
            ],
            [
                'name' => 'Hải',
                'email' => 'Hai123@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'HMN',
            ],
            [
                'name' => 'Phương',
                'email' => 'thuphuong@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'ACC',
            ],
            [
                'name' => 'phat ngu',
                'email' => 'phat@gmail.com',
                'password' => Hash::make('password123'),
                'type' => 'ACC',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}