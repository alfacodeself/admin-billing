<?php

namespace App\Http\Controllers\Api\Pelanggan;

use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PelangganResource;
use Illuminate\Support\Facades\Hash;

class PelangganApiController extends Controller
{
    public function profil()
    {
        try {
            return (new PelangganResource(auth()->guard('pelanggan')->user()))->additional([
                'status' => true,
                'message' => 'Berhasil mengambil data pelanggan!',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data pelanggan!',
                'errors' => $th->getMessage()
            ]);
        }
    }
    public function updateProfil(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        // Validation
        $validFoto = $pelanggan->foto == null ? 'required' : 'nullable';
        $validJenisKelamin = $pelanggan->jenis_kelamin == null ? 'required' : 'nullable';
        $validAlamat = $pelanggan->alamat == null ? 'required' : 'nullable';

        $validDesa = $pelanggan->id_desa == null ? 'required' : 'nullable';
        $validrt = $pelanggan->rt == null ? 'required' : 'nullable';
        $validrw = $pelanggan->rw == null ? 'required' : 'nullable';
        $validLat = $pelanggan->latitude == null ? 'required' : 'nullable';

        $validated = $request->validate([
            'nik' => 'nullable|numeric|digits:16|unique:pelanggan,nik,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'foto' => $validFoto . '|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'nama_pelanggan' => 'nullable',
            'jenis_kelamin' => $validJenisKelamin,
            'nomor_hp' => 'nullable|numeric|digits_between:9,15|unique:pelanggan,nomor_hp,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'alamat' => $validAlamat,
            'id_desa' => $validDesa,
            'rt' => $validrt,
            'rw' => $validrw,
            'latitude' => $validLat,
            'longitude' => $validLat
        ]);
        try {
            if ($request->has('id_desa')) {
                $desa = DB::table('desa')->select('id_desa')->where('id_desa', $request->id_desa)->where('status', 'a')->first();
                if ($desa == null && $request->has('id_desa')) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal mengubah profil pelanggan!',
                        'errors' => 'Desa tidak ditemukan!'
                    ]);
                }
            }
            if ($request->hasFile('foto')) {
                if ($pelanggan->foto !== null) @unlink(public_path($pelanggan->foto));
                $foto = "fotopelanggan-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
                $send = $request->file('foto')->storeAs('public/pelanggan/foto', $foto);
                $path = Storage::url($send);
            }else {
                $path = $pelanggan->foto;
            }
            $validated['foto'] = $path;
            $pelanggan->update($validated);
            return (new PelangganResource(auth()->guard('pelanggan')->user()))->additional([
                'status' => true,
                'message' => 'Berhasil mengubah profil pelanggan!',
            ]);
        } catch (\Throwable $th) {
            return response($th->getMessage());
        }
    }
    public function updateAccount(Request $request)
    {
        $valid = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);
        $pelanggan = auth()->guard('pelanggan')->user();
        if (!Hash::check($valid['old_password'], $pelanggan->password)) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah password",
                "errors" => "Password lama anda salah"
            ]);
        }
        try {
            $pelanggan->update([
                'password' => bcrypt($valid['new_password'])
            ]);
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengubah password"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah password",
                "errors" => $th->getMessage()
            ]);
        }
    }
}
