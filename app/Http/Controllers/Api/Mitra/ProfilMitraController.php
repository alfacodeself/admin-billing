<?php

namespace App\Http\Controllers\Api\Mitra;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DetailBagiHasil;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class ProfilMitraController extends Controller
{
    public function index()
    {
        try {
            $mitra = auth()->guard('mitra')->user();
            $bagi_hasil = DetailBagiHasil::with('pengaturan_bagi_hasil')->where('status', 'a')->where('id_mitra', $mitra->id_mitra)->first();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengambil data pelanggan!',
                'data' => [
                        'nama' => $mitra->nama_mitra,
                        'foto' => url($mitra->foto),
                        'jenis_kelamin' => $mitra->jenis_kelamin == 'l' ? 'laki-laki' : 'perempuan',
                        'nomor_hp' => $mitra->nomor_hp,
                        'email' => $mitra->email,
                        'bagi_hasil' => $bagi_hasil->pengaturan_bagi_hasil->status_jenis == 'f' ? 'Rp.' . $bagi_hasil->pengaturan_bagi_hasil->besaran : $bagi_hasil->pengaturan_bagi_hasil->besaran . '%'
                    ]
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
        $mitra = auth('mitra')->user();
        $validFoto = $mitra->foto == null ? 'required':'nullable';
        $validated = $request->validate([
            'nama' => 'required',
            'foto' => $validFoto . '|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:mitra,nomor_hp,'. $mitra->id_mitra . ',id_mitra',
        ], [
            'foto.image' => 'Foto harus berupa gambar!',
            'foto.mimes' => 'Foto harus berformat png, jpg, jpeg, gif, svg!',
            'foto.max' => 'Foto maksimal 2MB!',
            'nama.required' => 'Nama tidak boleh kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong!',
            'nomor_hp.required' => 'Nomor Handphone tidak boleh kosong!',
            'nomor_hp.numeric' => 'Nomor Handphone harus berupa angka!',
            'nomor_hp.digits_between' => 'Nomor Handphone minimal 9 digit dan maksimal 15 digit!',
            'nomor_hp.unique' => 'Tidak dapat menggunakan Nomor Handphone yang sudah ada!',
        ]);
        try {
            if ($request->hasFile('foto')) {
                if ($mitra->foto !== null) @unlink(public_path($mitra->foto));
                $foto = "fotomitra-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
                $send = $request->file('foto')->storeAs('public/mitra/foto', $foto);
                $path = Storage::url($send);
            }else {
                $path = $mitra->foto;
            }
            $validated['nama_mitra'] = $validated['nama'];
            unset($validated['nama']);
            $validated['foto'] = $path;
            $mitra->update($validated);
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengubah profil mitra!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengubah profil mitra!',
                'errors' => $th->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
    public function updateAccount(Request $request)
    {
        $valid = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);
        $mitra = auth()->guard('mitra')->user();
        if (!Hash::check($valid['old_password'], $mitra->password)) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah password",
                "errors" => "Password lama anda salah"
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $mitra->update([
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
