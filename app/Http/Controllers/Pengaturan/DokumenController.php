<?php

namespace App\Http\Controllers\Pengaturan;

use App\Models\JenisDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DokumenController extends Controller
{
    public function index()
    {
        $jenis_dokumen = JenisDokumen::paginate(10);
        return view('app.pengaturan.dokumen', compact('jenis_dokumen'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required',
            'status' => 'required'
        ], [
            'jenis_dokumen.required' => 'Jenis dokumen tidak boleh kosong',
            'status.required' => 'Status dokumen tidak boleh kosong'
        ]);
        try {
            $check = DB::table('jenis_dokumen')->select(DB::raw('MAX(RIGHT(id_jenis_dokumen, 3)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.03d", $temp);
                }
            } else {
                $code = "001";
            }
            JenisDokumen::create([
                'id_jenis_dokumen' => 'JD' . $code,
                'nama_dokumen' => $request->jenis_dokumen,
                'status' => 'a',
                'status_dokumen' => $request->status
            ]);
            return redirect()->route('pengaturan.dokumen.index')->with('success', 'Berhasil menambah pengaturan dokumen ' . $request->jenis_dokumen);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.dokumen.index')->with('danger', 'Gagal menambah pengaturan dokumen! ' . $e->getMessage());
        }
    }
    public function update($id, Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required',
            'status' => 'required'
        ], [
            'jenis_dokumen.required' => 'Jenis dokumen tidak boleh kosong',
            'status.required' => 'Status dokumen tidak boleh kosong'
        ]);
        try {
            $jenis = JenisDokumen::where('id_jenis_dokumen', $id)->firstOrFail();
            $jenis->update([
                'nama_dokumen' => $request->jenis_dokumen,
                'status_dokumen' => $request->status
            ]);
            return redirect()->route('pengaturan.dokumen.index')->with('success', 'Berhasil mengubah pengaturan dokumen ' . $request->jenis_dokumen);
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.dokumen.index')->with('danger', 'Gagal mengubah pengaturan dokumen! ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $jenis = JenisDokumen::where('id_jenis_dokumen', $id)->firstOrFail();
            $jenis->delete();
            return redirect()->route('pengaturan.dokumen.index')->with('success', 'Berhasil menghapus pengaturan dokumen!');
        } catch (\Throwable $e) {
            return redirect()->route('pengaturan.dokumen.index')->with('danger', 'Gagal menghapus pengaturan dokumen! ' . $e->getMessage());
        }
    }
}
