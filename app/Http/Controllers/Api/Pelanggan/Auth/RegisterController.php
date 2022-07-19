<?php

namespace App\Http\Controllers\Api\Pelanggan\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:pelanggan,nik',
            'nama' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:pelanggan,nomor_hp',
            'email' => 'required|unique:pelanggan,email|email',
            'password' => 'required|min:8|confirmed'
        ], [
            'nik.required' => 'NIK tidak boleh kosong!',
            'nik.numeric' => 'NIK harus berupa angka!',
            'nik.digits' => 'NIK harus 16 digit!',
            'nik.unique' => 'NIK sudah terdaftar! Silakan gunakan NIK lain!',
            'nomor_hp.required' => 'Nomor Handphone tidak boleh kosong!',
            'nomor_hp.numeric' => 'Nomor Handphone harus berupa angka!',
            'nomor_hp.digits_between' => 'Nomor Handphone harus berisi 9 sampai 15 digit!',
            'nomor_hp.unique' => 'Nomor Handphone sudah terdaftar! Silakan gunakan Nomor Handphone lain!',
            'nama.required' => 'Nama tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.unique' => 'Email sudah terdaftar! Silakan gunakan Email lain!',
            'email.email' => 'Format email salah!',
            'password.required' => 'Password tidak boleh kosong!',
            'password.min' => 'Password minimal 8 karakter!',
            'password.confirmed' => 'Konfirmasi password tidak sama dengan password anda!',
        ]);
        try {
            $check = DB::table('pelanggan')->select(DB::raw('MAX(RIGHT(id_pelanggan, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $pelanggan = Pelanggan::create([
                'id_pelanggan' => 'PL' . $code,
                'nik' => $validated['nik'],
                'nama_pelanggan' => $validated['nama'],
                'nomor_hp' => $validated['nomor_hp'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'])
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftarkan pelanggan',
                'data' => $pelanggan
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan pelanggan!',
                'errors' => $th->getMessage()
            ]);
        }
    }
}
