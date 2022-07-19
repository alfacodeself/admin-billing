<?php

namespace Database\Seeders;

use App\Models\PengaturanBagiHasil;
use Illuminate\Database\Seeder;

class PengaturanBagiHasilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PengaturanBagiHasil::create([
            'id_pengaturan_bagi_hasil'  =>  'PBH0001',
            'besaran'                   =>  3,
            'status_jenis'              =>  'p',
            'status'                    =>  'a',
            'keterangan'                =>  'Mitra Umum'
        ]);
        PengaturanBagiHasil::create([
            'id_pengaturan_bagi_hasil'  =>  'PBH0002',
            'besaran'                   =>  20000,
            'status_jenis'              =>  'f',
            'status'                    =>  'a',
            'keterangan'                =>  'Mitra Pelanggan Dekat'
        ]);
        PengaturanBagiHasil::create([
            'id_pengaturan_bagi_hasil'  =>  'PBH0003',
            'besaran'                   =>  10,
            'status_jenis'              =>  'p',
            'status'                    =>  'a',
            'keterangan'                =>  'Test Pengaturan Bagi Hasil Mitra'
        ]);
    }
}
