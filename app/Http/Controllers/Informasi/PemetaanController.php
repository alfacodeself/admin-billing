<?php

namespace App\Http\Controllers\Informasi;

use App\Http\Controllers\Controller;
use App\Models\{Desa, Kabupaten, Kecamatan, Langganan, Provinsi};
use Illuminate\Http\Request;

class PemetaanController extends Controller
{
    public function index()
    {
        return view('app.informasi.pemetaan');
    }
    public function get_alamat(Request $request)
    {
        $valid = $request->validate([
            'jenis' => 'required',
            'status' => 'required'
        ], [
            'jenis.required' => "Jenis pencarian tidak boleh kosong!",
            'status.required' => "Status pencarian tidak boleh kosong!",
        ]);
        try {
            $query = Langganan::query();
            $query->when($valid['jenis'] == 'status', function($q) use ($valid) {
                return $q->with('pelanggan')->where('status', $valid['status']);
            });
            $query->when($valid['jenis'] == 'provinsi', function($q) use ($valid) {
                return $q->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                        ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                        ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                        ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
                        ->where('provinsi.id_provinsi', $valid['status']);
            });
            $query->when($valid['jenis'] == 'kabupaten', function($q) use ($valid) {
                return $q->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                        ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                        ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                        ->where('kabupaten.id_kabupaten', $valid['status']);
            });
            $query->when($valid['jenis'] == 'kecamatan', function($q) use ($valid) {
                return $q->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                        ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                        ->where('kecamatan.id_kecamatan', $valid['status']);
            });
            $query->when($valid['jenis'] == 'desa', function($q) use ($valid) {
                return $q->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                        ->where('desa.id_desa', $valid['status']);
            });
            $query->when($valid['jenis'] == 'pelanggan', function($q) use ($valid){
                return $q->join('pelanggan', 'langganan.id_pelanggan', 'pelanggan.id_pelanggan')
                        ->where('pelanggan.status', $valid['status']);
            });
            $langganan = $query->get();
            $data = [];
            foreach ($langganan as $key => $l) {
                if ($l->status == 'a') {
                    $s = 'Aktif';
                }
                elseif ($l->status == 'n') {
                    $s = 'Nonaktif';
                }
                elseif ($l->status == 'pn') {
                    $s = 'Pengajuan';
                }
                elseif ($l->status == 'pni') {
                    $s = 'Pengajuan Instalasi';
                }
                elseif ($l->status == 'pmi') {
                    $s = 'Pemasangan Instalasi';
                }
                elseif ($l->status == 'dt') {
                    $s = 'Ditolak';
                }
                elseif ($l->status == 'dtr') {
                    $s = 'Diterima';
                }
                $d = [
                    $l->kode_langganan . ' | ' . $l->pelanggan->nama_pelanggan,
                    $l->latitude,
                    $l->longitude,
                    $key+1,
                    $l->produk->nama_produk,
                    $l->produk->kategori->nama_kategori,
                    $l->alamat_pemasangan . '. Kode Pos ' . $l->desa->kode_pos,
                    $l->tanggal_instalasi == null ? '-' : $l->tanggal_instalasi,
                    $l->tanggal_verifikasi == null ? false : true,
                    $l->status = $s 
                ];
                array_push($data, $d);
            }
            $data = json_encode($data);
            return view('app.informasi.pemetaan', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->route('pemetaan.index')->with('danger', $th->getMessage());
        }
    }
    public function set_status(Request $request)
    {
        if ($request->ajax()) {
            if ($request->jenis == 'provinsi') {
                $data = Provinsi::select('id_provinsi', 'nama_provinsi')->where('status', 'a')->get();
            }elseif ($request->jenis == 'kabupaten') {
                $data = Kabupaten::select('id_kabupaten', 'nama_kabupaten')->where('status', 'a')->get();
            }elseif ($request->jenis == 'kecamatan') {
                $data = Kecamatan::select('id_kecamatan', 'nama_kecamatan')->where('status', 'a')->get();
            }elseif ($request->jenis == 'desa') {
                $data = Desa::select('id_desa', 'nama_desa')->where('status', 'a')->get();
            }
            return response()->json($data);
        }
    }
}
