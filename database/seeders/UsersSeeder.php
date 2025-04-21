<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $userData = [
            [
                'email' => 'admin@mail.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ],
            [
                'email' => 'ketua@mail.id',
                'password' => bcrypt('password123'),
                'role' => 'ketua_tim',
            ],
            [
                'email' => 'kabid@mail.id',
                'password' => bcrypt('password123'),
                'role' => 'kepala_bidang',
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
