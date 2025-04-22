<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('aduan_layanan')->truncate();
        DB::table('penerbitan_tte')->truncate();
        DB::table('permohonan_bod')->truncate();
        DB::table('permohonan_infrastruktur')->truncate();
        DB::table('permohonan_pentest')->truncate();
        DB::table('permohonan_reset_email')->truncate();
        DB::table('permohonan_virtual_meeting')->truncate();
        DB::table('permohonan_vps')->truncate();
    }
}
