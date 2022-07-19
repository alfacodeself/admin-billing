<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelanggan::create([
            'id_pelanggan' =>  'PL00001',
            'nik' =>  '6106150412010001',
            'foto' =>  '/pelanggan/link-foto-profil.jpg',
            'nama_pelanggan' =>  'Pelanggan 1',
            'jenis_kelamin' =>  'l',
            'nomor_hp' =>  '6282139043511',
            'alamat' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, quam!',
            'id_desa' => 'DES001',
            'rt' => '001',
            'rw' => '002',
            'latitude' => '098962398',
            'longitude' => '098962398',
            'status' => 'a',
            'email' => 'pelanggan1@example.com',
            'password' => bcrypt('pelanggan123'),
        ]);
    }
}
