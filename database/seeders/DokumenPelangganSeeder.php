<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DokumenPelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO dokumen_pelanggan (id_dokumen_pelanggan, id_pelanggan, id_jenis_dokumen, path_dokumen) VALUES (?,?,?,?)', ['DP00001', 'PL00001', 'JD001', '/path/dokumen-ktp.jpg']);
        DB::insert('INSERT INTO dokumen_pelanggan (id_dokumen_pelanggan, id_pelanggan, id_jenis_dokumen, path_dokumen) VALUES (?,?,?,?)', ['DP00002', 'PL00001', 'JD002', '/path/dokumen-ktp-dan-pelanggan.jpg']);
    }
}
