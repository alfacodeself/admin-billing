<?php

namespace App\Http\Controllers\Api\Pelanggan;

use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PelangganResource;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

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
            ], Response::HTTP_UNAUTHORIZED);
        }  catch (JWTException $exception) {
            return response()->json(['errors' =>'Failed regenerate token!' . $exception->getMessage()], 500);
        }
    }
    public function updateProfil(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        // Validation
        $validJenisKelamin = $pelanggan->jenis_kelamin == null ? 'required' : 'nullable';

        $validated = $request->validate([
            'nik' => 'nullable|numeric|digits:16|unique:pelanggan,nik,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'nama_pelanggan' => 'nullable',
            'jenis_kelamin' => $validJenisKelamin,
            'nomor_hp' => 'nullable|numeric|digits_between:9,15|unique:pelanggan,nomor_hp,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'alamat' => 'nullable',
            'id_desa' => 'nullable',
            'rt' => 'nullable',
            'rw' => 'nullable',
            'latitude' => 'nullable',
            'longitude' => 'nullable'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'nik.required' => 'NIK tidak boleh kosong!',
            'nik.numeric' => 'NIK harus berupa angka!',
            'nik.digits' => 'NIK harus 16 digit!',
            'nik.unique' => 'Tidak dapat menggunakan NIK yang sudah ada!',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email harus memiliki format email!',
            'email.unique' => 'Tidak dapat menggunakan Email yang sudah ada!',
            'nomor_hp.required' => 'Nomor Handphone tidak boleh kosong!',
            'nomor_hp.numeric' => 'Nomor Handphone harus berupa angka!',
            'nomor_hp.digits_between' => 'Nomor Handphone minimal 9 digit dan maksimal 15 digit!',
            'nomor_hp.unique' => 'Tidak dapat menggunakan Nomor Handphone yang sudah ada!',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'id_desa.required' => 'Desa tidak boleh kosong!',
            'rt.required' => 'RT tidak boleh kosong!',
            'rw.required' => 'RW tidak boleh kosong!',
            'latitude.required' => 'Harap pilih tempat anda di map!',
            'longitude.required' => 'Harap pilih tempat anda di map!',
        ]);
        try {
            if ($request->has('id_desa') && $pelanggan->id_desa == null) {
                $desa = DB::table('desa')->select('id_desa')->where('id_desa', $request->id_desa)->where('status', 'a')->first();
                if ($desa == null && $request->has('id_desa')) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Gagal mengubah profil pelanggan!',
                        'errors' => ['Desa tidak ditemukan!']
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
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah profil pelanggan",
                "errors" => [$th->getMessage()]
            ]);
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
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $pelanggan->update([
                'password' => bcrypt($valid['new_password'])
            ]);
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengubah password"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah password",
                "errors" => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
