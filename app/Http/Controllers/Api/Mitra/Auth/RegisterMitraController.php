<?php

namespace App\Http\Controllers\Api\Mitra\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Symfony\Component\HttpFoundation\Response;

class RegisterMitraController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:mitra,nomor_hp',
            'email' => 'required|unique:mitra,email|email',
            'password' => 'required|min:8|confirmed'
        ], [
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
            $check = DB::table('mitra')->select(DB::raw('MAX(RIGHT(id_mitra, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $mitra = Mitra::create([
                'id_mitra' => 'M' . $code,
                'nama_mitra' => $validated['nama'],
                'nomor_hp' => $validated['nomor_hp'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password'])
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftarkan mitra',
                'data' => $mitra
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mendaftarkan mitra!',
                'errors' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
