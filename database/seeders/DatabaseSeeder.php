<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil UsersSeeder untuk akun spesifik (admin, ketua, kabid)
        $this->call(UsersSeeder::class);

        // Buat 10 user dummy tambahan secara acak
        User::factory(10)->create();
    }
}
