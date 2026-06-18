<?php

namespace Database\Seeders;

use App\Models\Layanan;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanans = [
            ['kode' => '1', 'nama' => 'Aduan Layanan', 'icon' => 'message-circle', 'pertanyaan' => []],
            ['kode' => '2', 'nama' => 'Virtual Meeting', 'icon' => 'video', 'pertanyaan' => []],
            ['kode' => '3', 'nama' => 'Virtual Private Server (VPS)', 'icon' => 'database', 'pertanyaan' => []],
            ['kode' => '4', 'nama' => 'Bandwidth on Demand', 'icon' => 'wifi', 'pertanyaan' => []],
            ['kode' => '5', 'nama' => 'Tanda Tangan Elektronik', 'icon' => 'file-signature', 'pertanyaan' => []],
            ['kode' => '6', 'nama' => 'Infrastruktur Baru', 'icon' => 'network', 'pertanyaan' => []],
            ['kode' => '7', 'nama' => 'Reset Email', 'icon' => 'mail', 'pertanyaan' => []],
            ['kode' => '8', 'nama' => 'Pentesting', 'icon' => 'shield', 'pertanyaan' => []],
        ];

        foreach ($layanans as $layanan) {
            Layanan::updateOrCreate(['kode' => $layanan['kode']], $layanan);
        }
    }
}
