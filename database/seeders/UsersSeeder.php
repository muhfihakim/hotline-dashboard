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
                'name' => 'Administrator',
                'email' => 'admin@mail.id',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Pimpinan',
                'email' => 'pimpinan@mail.id',
                'password' => bcrypt('password123'),
                'role' => 'pimpinan',
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
