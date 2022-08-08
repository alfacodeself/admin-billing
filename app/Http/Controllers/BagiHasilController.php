<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetailBagiHasil;
use Illuminate\Support\Facades\DB;
use App\Models\PengaturanBagiHasil;

class BagiHasilController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'besaran' => 'required|numeric|min:1',
            'jenis' => 'required'
        ], [
            'besaran.required' => 'Besaran harus di isi!',
            'besaran.numeric' => 'Besaran harus di berupa angka!',
            'besaran.min' => 'Besaran tidak boleh kurang dari 1!',
            'jenis.required' => 'Jenis harus di isi!',
        ]);
        try {
            $pengaturan = PengaturanBagiHasil::with('detail_bagi_hasil.mitra')->where('status', 'a')->first();
            // dd($pengaturan->toArray());
            $pengaturan->update(['status' => 'n']);

            $check = DB::table('pengaturan_bagi_hasil')->select(DB::raw('MAX(RIGHT(id_pengaturan_bagi_hasil, 4)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.04d", $temp);
                }
            } else {
                $code = "0001";
            }
            $baru = PengaturanBagiHasil::create([
                'id_pengaturan_bagi_hasil' => 'PBH' .  $code,
                'besaran' => $request->besaran,
                'status_jenis' => $request->jenis,
                'status' => 'a'
            ]);
            // dd($baru);

            foreach ($pengaturan->detail_bagi_hasil as $detail_bagi_hasil) {
                $detail_bagi_hasil->update(['status' => 'n']);
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
                    'id_mitra' => $detail_bagi_hasil->mitra->id_mitra,
                    'id_pengaturan_bagi_hasil' => $baru->id_pengaturan_bagi_hasil,
                    'status' => 'a'
                ]);
            }
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil mengubah pengaturan bagi hasil!');
        } catch (\Throwable $e) {
            return $e->getMessage();
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menambah pengaturan pembayaran! ' . $e->getMessage());
        }
    }
}
