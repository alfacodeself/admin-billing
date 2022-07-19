<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        return view('app.kategori.index', [
            'kategori' => Kategori::paginate(10)
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'status' => 'required'
        ], [
            'kategori.required' => 'Nama kategori tidak boleh kosong!' ,
            'status.required' => 'Status tidak boleh kosong!' ,
        ]);
        try {
            $check = DB::table('kategori')->select(DB::raw('MAX(RIGHT(id_kategori, 3)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.03d", $temp);
                }
            } else {
                $code = "001";
            }
            Kategori::create([
                'id_kategori' => 'K'.$code,
                'nama_kategori' => $request->kategori,
                'status' => $request->status
            ]);

            return redirect()->route('kategori.index')->with('success', 'Berhasil menambah kategori ' . $request->kategori);
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index')->with('danger', 'Gagal menambah kategori! ' . $e->getMessage());
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'kategori' => 'required',
            'status' => 'required'
        ], [
            'kategori.required' => 'Nama kategori tidak boleh kosong!' ,
            'status.required' => 'Status tidak boleh kosong!' ,
        ]);
        try {
            $kategori = Kategori::where('id_kategori', $id)->firstOrFail();
            // dd($kategori, $request->all());
            $kategori->update([
                'nama_kategori' => $request->kategori,
                'status' => $request->status
            ]);
            return redirect()->route('kategori.index')->with('success', 'Berhasil mengubah kategori menjadi ' . $request->kategori);
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index')->with('danger', 'Gagal mengubah kategori! ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $kategori = Kategori::where('id_kategori', $id)->firstOrFail();
            $nama = "";
            $nama .= $kategori->nama_kategori;
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Berhasil menghapus kategori ' . $nama);
        } catch (\Throwable $e) {
            return redirect()->route('kategori.index')->with('danger', 'Gagal menghapus kategori! ' . $e->getMessage());
        }
    }
}
