<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPembayaran;
use Illuminate\Support\Facades\DB;

class JenisPembayaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jenis_bayar' => 'required',
            'besaran' => 'required|numeric',
            'jenis' => 'required'
        ], [
            'jenis_bayar.required' => 'Jenis bayar tidak boleh kosong!',
            'besaran.required' => 'Besaran tidak boleh kosong!',
            'besaran.numeric' => 'Besaran harus berupa angka!',
            'jenis' => 'Jenis Biaya tidak boleh kosong!'
        ]);
        try {
            $check = DB::table('jenis_langganan')->select(DB::raw('MAX(RIGHT(id_jenis_langganan, 3)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.03d", $temp);
                }
            } else {
                $code = "001";
            }
            JenisPembayaran::create([
                'id_jenis_pembayaran' => 'JP' . $code,
                'jenis_pembayaran' => $request->jenis_bayar,
                'harga' => $request->besaran,
                'jenis_biaya' => $request->jenis
            ]);
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil menambah jenis pembayaran ' . $request->jenis_bayar);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menambah jenis pembayaran! ' . $e->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_bayar' => 'required',
            'besaran' => 'required|numeric',
            'jenis' => 'required'
        ], [
            'jenis_bayar.required' => 'Jenis bayar tidak boleh kosong!',
            'besaran.required' => 'Besaran tidak boleh kosong!',
            'besaran.numeric' => 'Besaran harus berupa angka!',
            'jenis' => 'Jenis Biaya tidak boleh kosong!'
        ]);
        try {
            $jenis_bayar = JenisPembayaran::findOrFail($id);
            $jenis_bayar->update([
                'jenis_pembayaran' => $request->jenis_bayar,
                'harga' => $request->besaran,
                'jenis_biaya' => $request->jenis
            ]);
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil mengubah jenis pembayaran ' . $request->jenis_bayar);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal mengubah jenis pembayaran! ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $jenis_bayar = JenisPembayaran::findOrFail($id);
            $jenis_bayar->delete();
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil menghapus jenis pembayaran!');
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menghapus jenis pembayaran! ' . $e->getMessage());
        }
    }
}
