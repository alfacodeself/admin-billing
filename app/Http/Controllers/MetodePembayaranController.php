<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MetodePembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MetodePembayaranController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg,gif,jfif,svg',
            'metode_bayar' => 'required',
            'via' => 'required',
            'status' => 'required'
        ], [
            'logo.required' => 'Logo harus di isi!',
            'logo.image' => 'Logo harus berupa gambar!',
            'logo.mimes' => 'Logo harus berformat png,jpg,jpeg,gif,jfif,svg',
            'metode_bayar.required' => 'Metode bayar harus di isi!',
            'via.required' => 'Via Metode Pembayaran harus di isi!',
            'status.required' => 'Status harus di isi!'
        ]);
        try {
            $check = DB::table('metode_pembayaran')->select(DB::raw('MAX(RIGHT(id_metode_pembayaran, 4)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.04d", $temp);
                }
            } else {
                $code = "0001";
            }
            $logo = "logo-". Str::random(5) . time() . '.' . $request->file('logo')->extension();
            $send = $request->file('logo')->storeAs('public/bank/', $logo);
            $path = Storage::url($send);
            MetodePembayaran::create([
                'id_metode_pembayaran'  => 'MP' . $code,
                'logo'  => $path,
                'metode_pembayaran' => $request->metode_bayar,
                'via' => $request->via,
                'status' => $request->status
            ]);
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil menambah pengaturan pembayaran ' . $request->metode_bayar);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menambah pengaturan pembayaran! ' . $e->getMessage());
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'logo' => 'image|mimes:png,jpg,jpeg,gif,jfif,svg',
            'metode_bayar' => 'required',
            'via' => 'required',
        ], [
            'logo.required' => 'Logo harus di isi!',
            'logo.image' => 'Logo harus berupa gambar!',
            'logo.mimes' => 'Logo harus berformat png,jpg,jpeg,gif,jfif,svg',
            'metode_bayar.required' => 'Metode bayar harus di isi!',
            'via.required' => 'Via Metode Pembayaran harus di isi!'
        ]);
        try {
            $metode = MetodePembayaran::where('id_metode_pembayaran', $id)->firstOrFail();
            if ($request->has('logo')) {
                if ($metode->logo !== null ) @unlink(public_path($metode->logo));
                $logo = "logo-". Str::random(5) . time() . '.' . $request->file('logo')->extension();
                $send = $request->file('logo')->storeAs('public/bank/', $logo);
                $path = Storage::url($send);
            }else {
                $path = $metode->logo;
            }
            $metode->update([
                'logo' => $path,
                'metode_pembayaran' => $request->metode_bayar,
                'via' => $request->via
            ]);
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil mengubah pengaturan pembayaran ' . $request->metode_bayar);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal mengubah pengaturan pembayaran! ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $metode = MetodePembayaran::where('id_metode_pembayaran', $id)->firstOrFail();
            if ($metode->logo !== null ) @unlink(public_path($metode->logo));
            $metode->delete();
            return redirect()->route('pengaturan.pembayaran.index')->with('success', 'Berhasil menghapus pengaturan pembayaran');
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.pembayaran.index')->with('danger', 'Gagal menghapus pengaturan pembayaran! ' . $e->getMessage());
        }
    }
}
