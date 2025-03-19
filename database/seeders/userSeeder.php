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
                'name' => 'Phong',
                'email' => 'Phong@gmail.com',
                'password' => Hash::make('123456'),
                'type' => 'CTO',

            ],

        ]);
    }
}
