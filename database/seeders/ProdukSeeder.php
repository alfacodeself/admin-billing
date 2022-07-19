<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Produk::create([
            'id_produk' => 'P001',
            'id_kategori' => 'K001',
            'nama_produk' => '25 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 25 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 250000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P002',
            'id_kategori' => 'K001',
            'nama_produk' => '30 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 30 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 280000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P003',
            'id_kategori' => 'K001',
            'nama_produk' => '40 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 40 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 300000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P004',
            'id_kategori' => 'K002',
            'nama_produk' => '40 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 40 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 300000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P005',
            'id_kategori' => 'K002',
            'nama_produk' => '50 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 50 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 320000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P006',
            'id_kategori' => 'K002',
            'nama_produk' => '60 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 60 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 320000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P007',
            'id_kategori' => 'K003',
            'nama_produk' => '70 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 70 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 350000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P008',
            'id_kategori' => 'K003',
            'nama_produk' => '80 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 80 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 380000,
            'status' => 'a'
        ]);
        Produk::create([
            'id_produk' => 'P009',
            'id_kategori' => 'K003',
            'nama_produk' => '100 Mbps',
            'deskripsi' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?',
            'fitur' => 'Internet 100 Mbps|Kartu Langganan|Pemasangan Instalasi',
            'harga' => 400000,
            'status' => 'a'
        ]);
    }
}
