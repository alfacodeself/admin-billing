<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        return view('app.produk.index', [
            'produk' => Produk::with('kategori')->paginate(10),
            'kategori' => Kategori::where('status', 'a')->get()
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'produk' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required|min:5',
            'harga' => 'required|numeric',
            'fitur.*' => 'required',
            'status' => 'required'
        ], [
            'produk.required' => 'Nama produk tidak boleh kosong!' ,
            'kategori.required' => 'Kategori tidak boleh kosong!' ,
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!' ,
            'deskripsi.min' => 'Deskripsi minimal 5 karakter!' ,
            'harga.required' => 'Harga tidak boleh kosong!' ,
            'harga.numeric' => 'Harga harus berupa angka!' ,
            'fitur.*.required' => 'Fitur tidak boleh kosong!' ,
            'status.required' => 'Status tidak boleh kosong!' ,
        ]);
        try {
            $kategori = Kategori::select('id_kategori')->where('id_kategori', $request->kategori)->first();
            if ($kategori == null) {
                return redirect()->back()->with('error', 'Kategori tidak ditemukan!');
            }
            $check = DB::table('produk')->select(DB::raw('MAX(RIGHT(id_produk, 3)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.03d", $temp);
                }
            } else {
                $code = "001";
            }
            $f = '';
            foreach ($request->fitur as $key => $fitur) {
                $key == count($request->fitur) - 1 ? $f .= $fitur : $f .= $fitur . '|';
            }
            Produk::create([
                'id_produk' => 'P'.$code,
                'id_kategori' => $kategori->id_kategori,
                'nama_produk' => $request->produk,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'fitur' => $f,
                'status' => $request->status
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil menambah produk ' . $request->produk);
        } catch (\Throwable $e) {
            return redirect()->route('produk.index')->with('danger', 'Gagal menambah produk! ' . $e->getMessage());
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'produk' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required|min:5',
            'harga' => 'required|numeric',
            'fitur.*' => 'required',
            'status' => 'required'
        ], [
            'produk.required' => 'Nama produk tidak boleh kosong!' ,
            'kategori.required' => 'Kategori tidak boleh kosong!' ,
            'deskripsi.required' => 'Deskripsi tidak boleh kosong!' ,
            'deskripsi.min' => 'Deskripsi minimal 5 karakter!' ,
            'harga.required' => 'Harga tidak boleh kosong!' ,
            'harga.numeric' => 'Harga harus berupa angka!' ,
            'fitur.*.required' => 'Fitur tidak boleh kosong!' ,
            'status.required' => 'Status tidak boleh kosong!' ,
        ]);
        try {
            $produk = Produk::where('id_produk', $id)->firstOrFail();
            $kategori = Kategori::select('id_kategori')->where('id_kategori', $request->kategori)->first();
            if ($kategori == null) {
                return redirect()->back()->with('error', 'Kategori tidak ditemukan!');
            }
            $f = '';
            foreach ($request->fitur as $key => $fitur) {
                $key == count($request->fitur) - 1 ? $f .= $fitur : $f .= $fitur . '|';
            }
            $produk->update([
                'id_kategori' => $kategori->id_kategori,
                'nama_produk' => $request->produk,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'fitur' => $f,
                'status' => $request->status
            ]);
            return redirect()->route('produk.index')->with('success', 'Berhasil mengubah produk ' . $request->produk);
        } catch (\Throwable $e) {
            return redirect()->route('produk.index')->with('danger', 'Gagal mengubah produk! ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $produk = Produk::where('id_produk', $id)->firstOrFail();
            $nama = '';
            $nama .= $produk->nama_produk;
            $produk->delete();
            return redirect()->route('produk.index')->with('success', 'Berhasil menghapus produk ' . $nama);
        } catch (\Throwable $e) {
            return redirect()->route('produk.index')->with('danger', 'Gagal menghapus produk! ' . $e->getMessage());
        }
    }
}
