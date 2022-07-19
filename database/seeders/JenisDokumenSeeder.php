<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Seeder;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisDokumen::create([
            'id_jenis_dokumen' => 'JD001',
            'nama_dokumen' => 'Foto KTP',
            'status' => 'a',
            'status_dokumen' => 'p',
        ]);
        JenisDokumen::create([
            'id_jenis_dokumen' => 'JD002',
            'nama_dokumen' => 'Foto KTP Bersama Pelanggan',
            'status' => 'a',
            'status_dokumen' => 'p',
        ]);
        JenisDokumen::create([
            'id_jenis_dokumen' => 'JD003',
            'nama_dokumen' => 'Foto Penghasilan per Bulan',
            'status' => 'a',
            'status_dokumen' => 'm',
        ]);
    }
}
