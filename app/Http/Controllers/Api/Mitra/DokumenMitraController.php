<?php

namespace App\Http\Controllers\Api\Mitra;

use Illuminate\Support\Str;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DokumenMitra;
use Illuminate\Support\Facades\Storage;

class DokumenMitraController extends Controller
{
    public function index()
    {
        $mitra = auth()->guard('mitra')->user();
        try {
            $dok = [];
            foreach ($mitra->dokumen_mitra as $dokumen) {
                array_push($dok, [
                    "id_dokumen" => $dokumen->id_dokumen_mitra,
                    "id_jenis_dokumen" => $dokumen->jenis_dokumen->id_jenis_dokumen,
                    "jenis_dokumen" => $dokumen->jenis_dokumen->nama_dokumen,
                    "url" => url($dokumen->path_dokumen)
                ]);
            }
            return response()->json([
                "status" => true,
                "message" => "Berhasil memuat dokumen mitra",
                "data" => [
                    "nama_mitra" => auth()->user()->nama_mitra,
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
    public function dokumen()
    {
        try {
            $jenis_dokumen = JenisDokumen::select('id_jenis_dokumen', 'nama_dokumen')->where('status', 'a')->where('status_dokumen', 'm')->get()->map(function($jenis) {
                $jenis->name = Str::lower(str_replace(' ', '_', $jenis->nama_dokumen));
                return $jenis;
            });
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengambil syarat dokumen!",
                "data" => $jenis_dokumen
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengambil syarat dokumen!",
                "errors" => $th->getMessage()
            ]);
        }
    }
    public function store(Request $request)
    {
        $jenis_dokumen = JenisDokumen::where('status', 'a')->where('status_dokumen', 'm')->get();
        foreach ($jenis_dokumen as $dokumen) {
            $request->validate([
                Str::lower(str_replace(' ', '_', $dokumen->nama_dokumen)) => 'required'
            ]);
        }
        $mitra = auth()->guard('mitra')->user();
        try {
            foreach ($jenis_dokumen as $dokumen) {
                foreach ($mitra->dokumen_mitra as $dp) {
                    if ($dp->id_jenis_dokumen == $dokumen->id_jenis_dokumen) {
                        return response()->json([
                            "status" => false,
                            "message" => "Gagal menambah dokumen mitra",
                            "errors" => "Anda telah memiliki dokumen " . $dokumen->nama_dokumen . "!"
                        ]);
                    }
                }
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
                    'id_mitra' => $mitra->id_mitra,
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
        $mitra = auth()->guard('mitra')->user();
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
            return response()->json([
                "status" => true,
                "message" => "Berhasil mengubah dokumen mitra"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => "Gagal mengubah dokumen mitra!",
                "errors" => $th->getMessage()
            ]);
        }
    }
}
