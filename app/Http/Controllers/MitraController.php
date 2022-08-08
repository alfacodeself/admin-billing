<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MitraRequest;
use App\Models\DanaMitra;
use App\Models\DetailBagiHasil;
use App\Models\DokumenMitra;
use App\Models\PengaturanBagiHasil;
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
            $pengaturan_bagi_hasil = PengaturanBagiHasil::where('status', 'a')->firstOrFail();
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
                'password' => bcrypt('mitra123')
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
            // ===========> Detail Bagi Hasil Mitra <==========
            $check2 = DB::table('detail_bagi_hasil')->select(DB::raw('MAX(RIGHT(id_detail_bagi_hasil, 5)) AS kode'));
            if ($check2->count() > 0) {
                foreach ($check2->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code2 = sprintf("%'.05d", $temp);
                }
            } else {
                $code2 = "00001";
            }
            DetailBagiHasil::create([
                'id_detail_bagi_hasil' => 'DBH' . $code2,
                'id_mitra' => $mitra->id_mitra,
                'id_pengaturan_bagi_hasil' => $pengaturan_bagi_hasil->id_pengaturan_bagi_hasil,
                'status' => 'a'
            ]);
            return redirect()->route('mitra.index')->with('success', 'Berhasil menambah mitra ' . $mitra->nama_mitra);
        } catch (\Throwable $th) {
            return redirect()->route('mitra.create')->with('error', 'Gagal menambah mitra ' . $th->getMessage());
        }
    }
    public function show($id)
    {
        $mitra = Mitra::with('dokumen_mitra', 'detail_mitra_pelanggan', 'detail_bagi_hasil.pengaturan_bagi_hasil')->withCount('detail_mitra_pelanggan')->where('id_mitra', $id)->firstOrFail();
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get();
        $detail_bagi_hasil = $mitra->detail_bagi_hasil->where('status', 'a')->first();
        $dana_mitra = DB::table('dana_mitra')
                    ->join('detail_bagi_hasil', 'dana_mitra.id_detail_bagi_hasil', '=', 'detail_bagi_hasil.id_detail_bagi_hasil')
                    ->join('pengaturan_bagi_hasil', 'detail_bagi_hasil.id_pengaturan_bagi_hasil', '=', 'pengaturan_bagi_hasil.id_pengaturan_bagi_hasil')
                    ->join('mitra', 'detail_bagi_hasil.id_mitra', '=', 'mitra.id_mitra')
                    ->join('transaksi', 'dana_mitra.id_transaksi', '=', 'transaksi.id_transaksi')
                    ->join('langganan', 'transaksi.id_langganan', '=', 'langganan.id_langganan')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('transaksi.id_transaksi', 'langganan.kode_langganan', 'langganan.id_langganan', 'pelanggan.nama_pelanggan', 'pengaturan_bagi_hasil.besaran', 'pengaturan_bagi_hasil.status_jenis AS jenis_bagi', 'dana_mitra.hasil_dana_mitra', 'transaksi.tanggal_lunas')
                    ->where('mitra.id_mitra', $mitra->id_mitra)
                    ->get()->map(function($dm){
                        $dm->besaran = $dm->jenis_bagi == 'f' ?'Rp.' . number_format($dm->besaran) : $dm->besaran . '%';
                        $dm->jenis_bagi = $dm->jenis_bagi == 'f' ? 'Flat' : 'Persentase';
                        $dm->hasil_dana_mitra = 'Rp.' . number_format($dm->hasil_dana_mitra);
                        return $dm;
                    });
        // dd($dana_mitra);
        $bagi_hasil = PengaturanBagiHasil::where('status', 'a')->get();
        return view('app.mitra.show', compact('mitra', 'jenis_dokumen', 'detail_bagi_hasil', 'dana_mitra', 'bagi_hasil'));
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
    public function updateBagiHasil(Request $request, $id)
    {
        $request->validate([
            'bagi_hasil' => 'required'
        ]);
        try {
            $mitra = Mitra::findOrFail($id);
            $bagi_hasil = PengaturanBagiHasil::findOrFail($request->bagi_hasil);

            $detail_bagi_hasil = DetailBagiHasil::where('id_mitra', $mitra->id_mitra)->where('status', 'a')->first();
            if ($detail_bagi_hasil != null) {
                // Create Bagi Hasil
                $detail_bagi_hasil->update(['status' => 'n']);
            }
            $check = DB::table('detail_bagi_hasil')->select(DB::raw('MAX(RIGHT(id_detail_bagi_hasil, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            DetailBagiHasil::create([
                'id_detail_bagi_hasil' => 'DBH' . $code,
                'id_mitra' => $mitra->id_mitra,
                'id_pengaturan_bagi_hasil' => $bagi_hasil->id_pengaturan_bagi_hasil,
                'status' => 'a'
            ]);
            return redirect()->route('mitra.show', $mitra->id_mitra)->with('success', 'Berhasil mengubah bagi hasil mitra');
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        $mitra = Mitra::where('id_mitra', $id)->firstOrFail();
        try {
            // if ($mitra->foto !== null) @unlink(public_path($mitra->foto));
            // foreach ($mitra->dokumen_mitra as $dokumen) {
            //     if ($dokumen->path_dokumen !== null) @unlink(public_path($dokumen->path_dokumen));
            // }
            // $mitra->delete();
            $mitra->update([
                'status' => 'n'
            ]);
            return redirect()->route('mitra.index', $mitra->id_mitra)->with('success', 'Berhasil menonaktifkan mitra!');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
