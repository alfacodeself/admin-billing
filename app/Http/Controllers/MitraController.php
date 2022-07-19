<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MitraRequest;
use App\Models\DokumenMitra;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MitraController extends Controller
{
    public function index()
    {

        return view('app.mitra.index', [
            'mitra' => Mitra::with('dokumen_mitra')->withCount('detail_mitra_pelanggan')->paginate(10)
        ]);
    }
    public function create()
    {
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get();
        return view('app.mitra.create', compact('jenis_dokumen'));
    }
    public function store(MitraRequest $request)
    {
        // ============> Validasi Dokumen <=================
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get();
        foreach ($jenis_dokumen as $dokumen) {
            $request->validate([
                Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen)) => 'required'
            ]);
        }
        try {
            // =========> Data Insert Pelanggan <==============
            $check = DB::table('mitra')->select(DB::raw('MAX(RIGHT(id_mitra, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $foto = "fotomitra-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/mitra/foto', $foto);
            $path = Storage::url($send);

            $mitra = Mitra::create([
                'id_mitra' => 'M' . $code,
                'foto' => $path,
                'nama_mitra' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nomor_hp' => $request->nomor_hp,
                'status' => 'a',
                'email' => $request->email,
                'password' => bcrypt('mitra123'),
                'tanggal_verifikasi' => Carbon::now()
            ]);
            // ==========> Data Dokumen Pelanggan <=========

            foreach ($jenis_dokumen as $dokumen) {
                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                $checkDok = DB::table('dokumen_mitra')->select(DB::raw('MAX(RIGHT(id_dokumen_mitra, 5)) AS kode'));
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
                $store = $request->file($name)->storeAs('public/document/mitra', $doc);
                $path = Storage::url($store);
                DokumenMitra::create([
                    'id_dokumen_mitra' => 'DM' . $codeDok,
                    'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
                    'id_mitra' => $mitra->id_mitra,
                    'path_dokumen' => $path
                ]);
            }
            return redirect()->route('mitra.index')->with('success', 'Berhasil menambah mitra ' . $mitra->nama_mitra);
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('mitra.create')->with('error', 'Gagal menambah mitra ' . $th->getMessage());
        }
    }
    public function show($id)
    {
        $mitra = Mitra::with('dokumen_mitra', 'detail_mitra_pelanggan')->withCount('detail_mitra_pelanggan')->where('id_mitra', $id)->firstOrFail();
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get();
        return view('app.mitra.show', compact('mitra', 'jenis_dokumen'));
    }
    public function updateFoto(Request $request, $id)
    {
        $mitra = Mitra::where('id_mitra', $id)->firstOrFail();
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ], [
            'foto.required' => 'Foto tidak boleh kosong!',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto hanya boleh memiliki format png,jpg,jpeg,gif,svg',
            'foto.max' => 'Foto maksimal sebesar 2MB (2048KB)'
        ]);
        try {
            if ($mitra->foto !== null) @unlink(public_path($mitra->foto));
            $foto = "fotomitra-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/mitra/foto', $foto);
            $path = Storage::url($send);
            $mitra->update(['foto' => $path]);
            return redirect()->route('mitra.show', $mitra->id_mitra)->with('success', 'Berhasil mengubah foto mitra!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('mitra.show')->with('error', 'Gagal menambah mitra ' . $th->getMessage());
        }
    }
    public function updateProfil(Request $request, $id)
    {
        $mitra = Mitra::where('id_mitra', $id)->firstOrFail();
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:mitra,email,'. $mitra->id_mitra . ',id_mitra',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:mitra,nomor_hp,'. $mitra->id_mitra . ',id_mitra',
            'status' => 'required'
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
            'status.required' => 'Status tidak boleh kosong!',
        ]);
        try {
            $mitra->update([
                'nama_mitra' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'status' => $request->status,
            ]);
            return redirect()->route('mitra.show', $mitra->id_mitra)->with('success', 'Berhasil mengubah profil mitra!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('mitra.show')->with('error', 'Gagal menambah mitra ' . $th->getMessage());
        }
    }
    public function updateDokumen(Request $request, $id)
    {
        $mitra = Mitra::where('id_mitra', $id)->firstOrFail();
        try {
            $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get();
            foreach ($jenis_dokumen as $dokumen) {
                $name = Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen));
                if ($request->$name !== null) {
                    $d = DokumenMitra::where('id_jenis_dokumen', $dokumen->id_jenis_dokumen)->where('id_mitra', $mitra->id_mitra)->first();
                    if ($d !== null) {
                        if ($d->path_dokumen != null) @unlink(public_path($d->path_dokumen));
                        $ext = $request->file($name)->extension();
                        $doc = "document-". Str::random(5) . time() . '.' . $ext;
                        $store = $request->file($name)->storeAs('public/document/mitra', $doc);
                        $path = Storage::url($store);
                        $d->update(['path_dokumen' => $path]);
                    }else {
                        $checkDok = DB::table('dokumen_mitra')->select(DB::raw('MAX(RIGHT(id_dokumen_mitra, 5)) AS kode'));
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
                        $store = $request->file($name)->storeAs('public/document/mitra', $doc);
                        $path = Storage::url($store);
                        DokumenMitra::create([
                            'id_dokumen_mitra' => 'DM' . $codeDok,
                            'id_mitra' => $mitra->id_mitra,
                            'id_jenis_dokumen' => $dokumen->id_jenis_dokumen,
                            'path_dokumen' => $path
                        ]);
                    }
                }
            }
            return redirect()->route('mitra.show', $mitra->id_mitra)->with('success', 'Berhasil mengubah dokumen mitra!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('mitra.show')->with('error', 'Gagal menambah mitra ' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        $mitra = Mitra::where('id_mitra', $id)->firstOrFail();
        try {
            if ($mitra->foto !== null) @unlink(public_path($mitra->foto));
            foreach ($mitra->dokumen_mitra as $dokumen) {
                if ($dokumen->path_dokumen !== null) @unlink(public_path($dokumen->path_dokumen));
            }
            $mitra->delete();
            return redirect()->route('mitra.index', $mitra->id_mitra)->with('success', 'Berhasil menghapus mitra!');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
