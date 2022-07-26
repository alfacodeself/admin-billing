<?php

namespace App\Http\Controllers\Pengaturan;

use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $profil = Petugas::first();
        return view('app.pengaturan.profil', compact('profil'));
    }
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ], [
            'foto.required' => 'Foto tidak boleh kosong!',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto hanya boleh memiliki format png,jpg,jpeg,gif,svg',
            'foto.max' => 'Foto maksimal sebesar 2MB (2048KB)'
        ]);
        try {
            $profil = Petugas::first();
            if ($profil->foto !== null) @unlink(public_path($profil->foto));
            $foto = "fotopetugas-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/petugas/foto', $foto);
            $path = Storage::url($send);
            $profil->update(['foto' => $path]);
            return redirect()->route('pengaturan.profil.index')->with('success', 'Berhasil mengubah foto profil!');
        } catch (\Throwable $th) {
            return redirect()->route('pengaturan.profil.index')->with('error', 'Gagal mengubah foto profil! ' . $th->getMessage());
        }
    }
    public function updateProfil(Request $request)
    {
        $profil = Petugas::first();
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:petugas,email,'. $profil->id_petugas . ',id_petugas',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:petugas,nomor_hp,'. $profil->id_petugas . ',id_petugas',
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email harus memiliki format email!',
            'email.unique' => 'Tidak dapat menggunakan Email yang sudah ada!',
            'nomor_hp.required' => 'Nomor Handphone tidak boleh kosong!',
            'nomor_hp.numeric' => 'Nomor Handphone harus berupa angka!',
            'nomor_hp.digits' => 'Nomor Handphone minimal 9 digit dan maksimal 15 digit!',
            'nomor_hp.unique' => 'Tidak dapat menggunakan Nomor Handphone yang sudah ada!',
        ]);
        try {
            $profil->update([
                'nama_petugas' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp
            ]);
            return redirect()->route('pengaturan.profil.index')->with('success', 'Berhasil mengubah profil!');
        } catch (\Throwable $th) {
            return redirect()->route('pengaturan.profil.index')->with('error', 'Gagal mengubah profil! ' . $th->getMessage());
        }
    }
    public function updatePassword(Request $request)
    {
        $valid = $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ], [
            'old_password.required' => 'Password lama harus di isi!',
            'new_password.required' => 'Password baru harus di isi!',
            'new_password.min' => 'Password baru minimal 8 karakter!',
            'new_password.confirmed' => 'Konfirmasi Password tidak sama!',
        ]);
        $profil = Petugas::first();
        if (!Hash::check($valid['old_password'], $profil->password)) {
            return back()->with('danger', 'Password lama anda salah!');
        }
        try {
            $profil->update([
                'password' => bcrypt($valid['new_password'])
            ]);
            return redirect()->route('pengaturan.profil.index')->with('success', 'Berhasil mengubah password!');
        } catch (\Throwable $th) {
            return redirect()->route('pengaturan.profil.index')->with('danger', 'Berhasil mengubah password! ' . $th->getMessage());
        }
    }
}
