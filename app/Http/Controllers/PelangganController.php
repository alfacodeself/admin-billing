<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PelangganRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\{Provinsi, Pelanggan, JenisDokumen, DokumenPelanggan};

class PelangganController extends Controller
{
    public function index()
    {
        return view('app.pelanggan.index', [
            'pelanggan' => Pelanggan::with('dokumen_pelanggan')->paginate(10)
        ]);
    }
    public function create()
    {
        $provinsi = Provinsi::where('status', 'a')->get();
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'p')->get();
        return view('app.pelanggan.create', compact('provinsi', 'jenis_dokumen'));
    }
    public function store(PelangganRequest $request)
    {
        // ============> Validasi Dokumen <=================
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'p')->get();
        foreach ($jenis_dokumen as $dokumen) {
            $request->validate([
                Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen)) => 'required'
            ]);
        }
        // =========> Validasi Desa <============
        $desa = DB::table('desa')->select('id_desa')->where('id_desa', $request->desa)->where('status', 'a')->first();
        // dd($desa);
        if ($desa == null) {
            return redirect()->back()->with('danger', 'Desa tidak ditemukan');
        }
        try {
            // =========> Data Insert Pelanggan <==============
            $check = DB::table('pelanggan')->select(DB::raw('MAX(RIGHT(id_pelanggan, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $foto = "fotopelanggan-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/pelanggan/foto', $foto);
            $path = Storage::url($send);
            $pelanggan = Pelanggan::create([
                'id_pelanggan' => 'PL' . $code,
                'nik' => $request->nik,
                'foto' => $path,
                'nama_pelanggan' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nomor_hp' => $request->nomor_hp,
                'alamat' => $request->alamat,
                'id_desa' => $desa->id_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 'a',
                'email' => $request->email,
                'password' => bcrypt('pelanggan123')
            ]);
            // ==========> Data Dokumen Pelanggan <=========
            foreach ($jenis_dokumen as $dokumen) {
                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                $checkDok = DB::table('dokumen_pelanggan')->select(DB::raw('MAX(RIGHT(id_dokumen_pelanggan, 5)) AS kode'));
                if ($checkDok->count() > 0) {
                    foreach ($checkDok->get() as $c) {
                        $temp = ((int) $c->kode) + 1;
                        $codeDok = sprintf("%'.05d", $temp);
                    }
                } else {
                    $codeDok = "00001";
                }
                $ext = $request->file($name)->extension();
                $doc = "document-". Str::random(5) . time() . '.' . $ext;
                $store = $request->file($name)->storeAs('public/document/pelanggan', $doc);
                $path = Storage::url($store);
                DokumenPelanggan::create([
                    'id_dokumen_pelanggan' => 'DP' . $codeDok,
                    'id_pelanggan' => $pelanggan->id_pelanggan,
                    'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
                    'path_dokumen' => $path
                ]);
            }
            return redirect()->route('pelanggan.index')->with('success', 'Berhasil menambah pelanggan ' . $pelanggan->nama_pelanggan);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('pelanggan.create')->with('error', 'Gagal menambah pelanggan ' . $th->getMessage());
        }
    }
    public function show($id)
    {
        $pelanggan = Pelanggan::with('desa')->where('id_pelanggan', $id)->firstOrFail();
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'p')->get();
        $provinsi = Provinsi::where('status', 'a')->get();
        return view('app.pelanggan.show', compact('pelanggan', 'provinsi', 'jenis_dokumen'));
    }
    public function updateFoto(Request $request, $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ], [
            'foto.required' => 'Foto tidak boleh kosong!',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto hanya boleh memiliki format png,jpg,jpeg,gif,svg',
            'foto.max' => 'Foto maksimal sebesar 2MB (2048KB)'
        ]);
        try {
            if ($pelanggan->foto !== null) @unlink(public_path($pelanggan->foto));
            $foto = "fotopelanggan-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/pelanggan/foto', $foto);
            $path = Storage::url($send);
            $pelanggan->update(['foto' => $path]);
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('success', 'Berhasil mengubah foto pelanggan!');
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('error', 'Gagal mengubah foto pelanggan! ' . $th->getMessage());
        }
    }
    public function updateProfil(Request $request, $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|numeric|digits:16|unique:pelanggan,nik,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:pelanggan,email,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:pelanggan,nomor_hp,'. $pelanggan->id_pelanggan . ',id_pelanggan',
            'status' => 'required'
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
            'nomor_hp.digits' => 'Nomor Handphone minimal 9 digit dan maksimal 15 digit!',
            'nomor_hp.unique' => 'Tidak dapat menggunakan Nomor Handphone yang sudah ada!',
            'status.required' => 'Status tidak boleh kosong!',
        ]);
        try {
            $pelanggan->update([
                'nama_pelanggan' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'status' => $request->status,
            ]);
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('success', 'Berhasil mengubah profil pelanggan!');
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('error', 'mengubah profil pelanggan! ' . $th->getMessage());
        }
    }
    public function updateDokumen(Request $request, $id)
    {
        $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
        try {
            $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'p')->get();
            foreach ($jenis_dokumen as $dokumen) {
                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                if ($request->$name !== null) {
                    $d = DokumenPelanggan::where('id_jenis_dokumen', $dokumen->id_jenis_dokumen)->where('id_pelanggan', $pelanggan->id_pelanggan)->first();
                    if ($d !== null) {
                        if ($d->path_dokumen != null) @unlink(public_path($d->path_dokumen));
                        $ext = $request->file($name)->extension();
                        $doc = "document-". Str::random(5) . time() . '.' . $ext;
                        $store = $request->file($name)->storeAs('public/document/pelanggan', $doc);
                        $path = Storage::url($store);
                        $d->update(['path_dokumen' => $path]);
                    }else {
                        $checkDok = DB::table('dokumen_pelanggan')->select(DB::raw('MAX(RIGHT(id_dokumen_pelanggan, 5)) AS kode'));
                        if ($checkDok->count() > 0) {
                            foreach ($checkDok->get() as $c) {
                                $temp = ((int) $c->kode) + 1;
                                $codeDok = sprintf("%'.05d", $temp);
                            }
                        } else {
                            $codeDok = "00001";
                        }
                        $ext = $request->file($name)->extension();
                        $doc = "document-". Str::random(5) . time() . '.' . $ext;
                        $store = $request->file($name)->storeAs('public/document/pelanggan', $doc);
                        $path = Storage::url($store);
                        DokumenPelanggan::create([
                            'id_dokumen_pelanggan' => 'DP' . $codeDok,
                            'id_pelanggan' => $pelanggan->id_pelanggan,
                            'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
                            'path_dokumen' => $path
                        ]);
                    }
                }
            }
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('success', 'Berhasil mengubah dokumen pelanggan!');
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('error', 'Gagal mengubah dokumen pelanggan ' . $th->getMessage());
        }
    }
    public function updateAlamat(Request $request, $id)
    {
        $request->validate([
            'desa' => 'required',
            'rt' => 'required|numeric|min:1',
            'rw' => 'required|numeric|min:1',
            'alamat' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ], [
            'desa.required' => 'Desa tidak boleh kosong!',
            'rt.required' => 'RT tidak boleh kosong!',
            'rt.numeric' => 'RT harus berupa angka!',
            'rt.min' => 'RT minimal 1',
            'rw.required' => 'RW tidak boleh kosong!',
            'rw.numeric' => 'RW harus berupa angka!',
            'rw.min' => 'RW minimal 1',
            'alamat.required' => 'Alamat tidak boleh kosong!',
            'latitude' => 'Harap pilih tempat pada map!',
            'longitude' => 'Harap pilih tempat pada map!',
        ]);
        // dd($request->all());
        $desa = DB::table('desa')->select('id_desa')->where('id_desa', $request->desa)->where('status', 'a')->first();
        // dd($desa);
        if ($desa == null) {
            return redirect()->back()->with('danger', 'Desa tidak ditemukan');
        }
        try {
            $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
            // dd($pelanggan);
            $pelanggan->update([
                'id_desa' => $desa->id_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('success', 'Berhasil mengubah alamat pelanggan!');
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.show', $pelanggan->id_pelanggan)->with('error', 'Gagal mengubah alamat pelanggan ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $pelanggan = Pelanggan::where('id_pelanggan', $id)->firstOrFail();
            // if ($pelanggan->foto !== null) @unlink(public_path($pelanggan->foto));
            // foreach ($pelanggan->dokumen_pelanggan as $dokumen) {
            //     if ($dokumen->path_dokumen !== null) @unlink(public_path($dokumen->path_dokumen));
            // }
            $pelanggan->update(['status' => 'n']);
            return redirect()->route('pelanggan.index')->with('success', 'Berhasil menghapus pelanggan!');
        } catch (\Throwable $th) {
            return redirect()->route('pelanggan.index')->with('error', 'Gagal menghapus pelanggan ' . $th->getMessage());
        }
    }
}
