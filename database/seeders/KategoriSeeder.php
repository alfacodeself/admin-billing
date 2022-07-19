<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        Kategori::create([
            'id_kategori' => 'K001',
            'nama_kategori' => 'Home',
            'status' => 'a'
        ]);
        Kategori::create([
            'id_kategori' => 'K002',
            'nama_kategori' => 'Premium',
            'status' => 'a'
        ]);
        Kategori::create([
            'id_kategori' => 'K003',
            'nama_kategori' => 'Business',
            'status' => 'a'
        ]);
    }
}
