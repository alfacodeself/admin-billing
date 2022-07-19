<?php

namespace App\Http\Controllers;

use App\Models\PengaturanBagiHasil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BagiHasilController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'besaran' => 'required|numeric|min:1',
            'jenis' => 'required'
        ], [
            'keterangan.required' => 'Keterangan harus di isi!',
            'besaran.required' => 'Besaran harus di isi!',
            'besaran.numeric' => 'Besaran harus di berupa angka!',
            'besaran.min' => 'Besaran tidak boleh kurang dari 1!',
            'jenis.required' => 'Jenis harus di isi!',
        ]);
        try {
            $check = DB::table('pengaturan_bagi_hasil')->select(DB::raw('MAX(RIGHT(id_pengaturan_bagi_hasil, 4)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.04d", $temp);
                }
            } else {
                $code = "0001";
            }
            PengaturanBagiHasil::create([
                'id_pengaturan_bagi_hasil' => 'PBH' .  $code,
                'besaran' => $request->besaran,
                'status_jenis' => $request->jenis,
                'status' => 'a',
                'keterangan' => $request->keterangan
            ]);
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil menambah pengaturan pembayaran ' . $request->keterangan);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menambah pengaturan pembayaran! ' . $e->getMessage());
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'besaran' => 'required|numeric|min:1',
            'jenis' => 'required'
        ], [
            'keterangan.required' => 'Keterangan harus di isi!',
            'besaran.required' => 'Besaran harus di isi!',
            'besaran.numeric' => 'Besaran harus di berupa angka!',
            'besaran.min' => 'Besaran tidak boleh kurang dari 1!',
            'jenis.required' => 'Jenis harus di isi!',
        ]);
        try {
            $bagi_hasil = PengaturanBagiHasil::where('id_pengaturan_bagi_hasil', $id)->firstOrFail();
            $bagi_hasil->update([
                'besaran' => $request->besaran,
                'status_jenis' => $request->jenis,
                'keterangan' => $request->keterangan
            ]);
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil mengubah pengaturan pembayaran ' . $request->keterangan);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal mengubah pengaturan pembayaran! ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $bagi_hasil = PengaturanBagiHasil::where('id_pengaturan_bagi_hasil', $id)->firstOrFail();
            $bagi_hasil->delete();
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil menghapus pengaturan pembayaran');
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menghapus pengaturan pembayaran! ' . $e->getMessage());
        }
    }
}
