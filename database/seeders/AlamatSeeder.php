<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO provinsi (id_provinsi, nama_provinsi, status) VALUE (?,?,?)', ['PROV001', 'Jawa Timur', 'a']);
        DB::insert('INSERT INTO kabupaten (id_kabupaten, id_provinsi, nama_kabupaten, status) VALUE (?,?,?,?)', ['KAB001','PROV001', 'Probolinggo', 'a']);
        DB::insert('INSERT INTO kecamatan (id_kecamatan, id_kabupaten, nama_kecamatan, status) VALUE (?,?,?,?)', ['KEC001','KAB001', 'Paiton', 'a']);
        DB::insert('INSERT INTO kecamatan (id_kecamatan, id_kabupaten, nama_kecamatan, status) VALUE (?,?,?,?)', ['KEC002','KAB001', 'Kraksaan', 'a']);
        DB::insert('INSERT INTO desa (id_desa, id_kecamatan, nama_desa, status) VALUE (?,?,?,?)', ['DES001','KEC001', 'Karanganyar', 'a']);
    }
}
