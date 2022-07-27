<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisLangganan;
use Illuminate\Support\Facades\DB;

class JenisLanggananController extends Controller
{
    public function index()
    {
        $jenis_langganan = JenisLangganan::paginate(10);
        return view('app.jenis-langganan.index', compact('jenis_langganan'));
    }
    public function store(Request $request)
    {
        $valid = $request->validate([
            'jenis' => 'required',
            'tagihan' => 'required|numeric|min:1',
            'status' => 'required',
            'status_langganan' => 'required'
        ], [
            'jenis.required' => 'Jenis langganan tidak boleh kosong!',
            'tagihan.required' => 'Tagihan tidak boleh kosong!',
            'tagihan.numeric' => 'Tagihan harus berupa angka!',
            'tagihan.min' => 'Tagihan minimal 1!',
            'status.required' => 'Status tidak boleh kosong!',
            'status_langganan.required' => 'Status langganan tidak boleh kosong!'
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
            JenisLangganan::create([
                'id_jenis_langganan' => 'JL' . $code,
                'lama_berlangganan' => $valid['jenis'],
                'banyak_tagihan' => $valid['tagihan'],
                'status' => $valid['status'],
                'status_berlangganan' => $valid['status_langganan'] == 0 ? false : true
            ]);
            return redirect()->route('jenis-langganan.index')->with('success', 'Berhasil membuat jenis langganan!');
        } catch (\Throwable $th) {
            return redirect()->route('jenis-langganan.index')->with('danger', 'Gagal membuat jenis langganan!' . $th->getMessage());
        }
    }
    public function update($id, Request $request)
    {
        $valid = $request->validate([
            'jenis' => 'required',
            'tagihan' => 'required|numeric|min:1',
            'status' => 'required',
            'status_langganan' => 'required'
        ], [
            'jenis.required' => 'Jenis langganan tidak boleh kosong!',
            'tagihan.required' => 'Tagihan tidak boleh kosong!',
            'tagihan.numeric' => 'Tagihan harus berupa angka!',
            'tagihan.min' => 'Tagihan minimal 1!',
            'status.required' => 'Status tidak boleh kosong!',
            'status_langganan.required' => 'Status langganan tidak boleh kosong!'
        ]);
        try {
            $jenis = JenisLangganan::where('id_jenis_langganan', $id)->firstOrFail();
            $jenis->update([
                'lama_berlangganan' => $valid['jenis'],
                'banyak_tagihan' => $valid['tagihan'],
                'status' => $valid['status'],
                'status_berlangganan' => $valid['status_langganan'] == 0 ? false : true
            ]);
            return redirect()->route('jenis-langganan.index')->with('success', 'Jenis langganan berhasil diubah!');
        } catch (\Throwable $th) {
            return redirect()->route('jenis-langganan.index')->with('danger', 'Jenis langganan gagal diubah!' . $th->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $jenis = JenisLangganan::where('id_jenis_langganan', $id)->firstOrFail();
            $jenis->delete();
            return redirect()->route('jenis-langganan.index')->with('success', 'Jenis langganan berhasil dihapus!');
        } catch (\Throwable $th) {
            return redirect()->route('jenis-langganan.index')->with('danger', 'Jenis langganan gagal dihapus!' . $th->getMessage());
        }
    }
}
