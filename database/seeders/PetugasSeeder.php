<?php

namespace Database\Seeders;

use App\Models\DetailJabatan;
use App\Models\Petugas;
use App\Models\JenisJabatan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = JenisJabatan::create([
            'id_jenis_jabatan' => 'JJ001',
            'nama_jabatan' => 'superadmin',
            'status' => 'a'
        ]);
        JenisJabatan::create([
            'id_jenis_jabatan' => 'JJ002',
            'nama_jabatan' => 'billing',
            'status' => 'a'
        ]);
        $sales = JenisJabatan::create([
            'id_jenis_jabatan' => 'JJ003',
            'nama_jabatan' => 'sales',
            'status' => 'a'
        ]);
        JenisJabatan::create([
            'id_jenis_jabatan' => 'JJ004',
            'nama_jabatan' => 'customer service',
            'status' => 'a'
        ]);
        $petugas = Petugas::create([
            'id_petugas' => 'PTS001',
            'foto' => 'foto/profil.jpeg',
            'nama_petugas' => 'Petugas Superadmin',
            'jenis_kelamin' => 'l',
            'nomor_hp' => 6282139043511,
            'status' => 'a',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('superadmin1234')
        ]);
        DetailJabatan::create([
            'id_detail_jabatan' => 'DJ0001',
            'id_jenis_jabatan' => $sales->id_jenis_jabatan,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'n',
            'tanggal_jabatan' => Carbon::now()->yesterday()
        ]);
        DetailJabatan::create([
            'id_detail_jabatan' => 'DJ0002',
            'id_jenis_jabatan' => $admin->id_jenis_jabatan,
            'id_petugas' => $petugas->id_petugas,
            'status' => 'a',
            'tanggal_jabatan' => Carbon::now()
        ]);
    }
}
