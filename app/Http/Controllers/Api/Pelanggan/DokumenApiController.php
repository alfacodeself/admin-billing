<?php

namespace App\Http\Controllers\Api\Pelanggan;

use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use App\Models\DokumenPelanggan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DokumenApiController extends Controller
{
    public function index()
    {
        $pelanggan = auth()->guard('pelanggan')->user();
        try {
            $dok = [];
            foreach ($pelanggan->dokumen_pelanggan as $dokumen) {
                array_push($dok, [
                    "id_dokumen" => $dokumen->id_dokumen_pelanggan,
                    "jenis_dokumen" => [
                        "id_jenis_dokumen" => $dokumen->jenis_dokumen->id_jenis_dokumen,
                        "jenis_dokumen" => $dokumen->jenis_dokumen->nama_dokumen
                    ],
                    "url" => url($dokumen->path_dokumen)
                ]);
            }
            return response()->json([
                "status" => true,
                "message" => "Berhasil memuat dokumen pelanggan",
                "data" => [
                    "nama_pelanggan" => auth()->user()->nama_pelanggan,
                    "dokumen" => $dok
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal memuat dokumen pelanggan",
                "errors" => $th->getMessage()
            ]);
        }
    }
    public function store(Request $request)
    {
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'p')->get();
        foreach ($jenis_dokumen as $dokumen) {
            $request->validate([
                Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen)) => 'required'
            ]);
        }
        $pelanggan = auth()->guard('pelanggan')->user();
        try {
            foreach ($jenis_dokumen as $dokumen) {
                foreach ($pelanggan->dokumen_pelanggan as $dp) {
                    if ($dp->id_jenis_dokumen == $dokumen->id_jenis_dokumen) {
                        return response()->json([
                            "status" => false,
                            "message" => "Gagal menambah dokumen pelanggan",
                            "errors" => "Anda telah memiliki dokumen " . $dokumen->nama_dokumen . "!"
                        ]);
                    }
                }
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
            return response()->json([
                "status" => true,
                "message" => "Berhasil menambah dokumen pelanggan"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal menambah dokumen pelanggan",
                "errors" => $th->getMessage()
            ]);
        }
    }
    public function update(Request $request)
    {
        $pelanggan = auth()->guard('pelanggan')->user();
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
                        return response()->json([
                            "status" => true,
                            "message" => "Berhasil mengubah dokumen " . $dokumen->nama_dokumen . " pelanggan."
                        ]);
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
                        return response()->json([
                            "status" => true,
                            "message" => "Berhasil menambah dokumen ". $dokumen->nama_dokumen ." pelanggan"
                        ]);
                    }
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah dokumen pelanggan!",
                "errors" => $th->getMessage()
            ]);
        }
    }
}
