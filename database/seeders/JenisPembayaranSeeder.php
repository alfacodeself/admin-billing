<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisPembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('INSERT INTO jenis_pembayaran VALUES (?,?,?,?,?)', ['JP001', 'Biaya Pemasangan Instalasi', 120000, 'f', 'a']);
        DB::insert('INSERT INTO jenis_pembayaran VALUES (?,?,?,?,?)', ['JP002', 'PPn', 5, 'p','a']);
        DB::insert('INSERT INTO jenis_pembayaran VALUES (?,?,?,?,?)', ['JP003', 'Test Jenis Pembayaran', 10000, 'f','a']);
    }
}
