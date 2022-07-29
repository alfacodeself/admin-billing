<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\{Desa, Produk, Langganan, Pelanggan, JenisLangganan, DetailLangganan};
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LanggananRequest;

class LanggananController extends Controller
{
    public function index()
    {
        $langganan = DB::table('detail_langganan')->join('langganan', 'detail_langganan.id_langganan', '=', 'langganan.id_langganan')
                    ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                    ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('langganan.id_langganan', 'langganan.kode_langganan', 'langganan.alamat_pemasangan', 'langganan.status', 'langganan.histori', 'pelanggan.nama_pelanggan', 'produk.nama_produk', 'kategori.nama_kategori', 'jenis_langganan.lama_berlangganan')
                    ->where('detail_langganan.status', 'a')
                    ->where('langganan.status', '!=', 'pn')
                    ->get();
        return view('app.langganan.index', compact('langganan'));
    }
    public function create()
    {
        if ($nik = request()->nik) {
            try {
                $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
                $pelanggan = Pelanggan::with('desa', 'dokumen_pelanggan')->where('nik', $nik)->firstOrFail();
                if ($pelanggan->status == 'n') {
                    return redirect()->route('langganan.create')->with('danger', 'Pelanggan dengan NIK ' . $pelanggan->nik . ' atas nama ' . $pelanggan->nama_pelanggan . '    tidak aktif!');
                }elseif ($pelanggan->verifikasi_email == null) {
                    return redirect()->route('langganan.create')->with('danger', 'Pelanggan dengan NIK ' . $pelanggan->nik . ' atas nama ' . $pelanggan->nama_pelanggan . ' belum verifikasi email!');
                }
                $kategori = DB::table('kategori')
                                ->select('kategori.nama_kategori', 'kategori.id_kategori')
                                ->where('kategori.status', 'a')->get()->map(function($kategori) use ($margin){
                                    $kategori->produk = DB::table('produk')->select('id_produk', 'nama_produk', 'deskripsi', 'harga', 'fitur')->where('status', 'a')->where('id_kategori', $kategori->id_kategori)->get()->map(function($produk) use ($margin){
                                        $produk->fitur = explode('|', $produk->fitur);
                                        $produk->harga = 'Rp.' . number_format($produk->harga + $margin->harga_margin);
                                        return $produk;
                                    })->toArray();
                                    return $kategori;
                                });
                $provinsi = DB::table('provinsi')->where('status', 'a')->get();
                $jenis_langganan = DB::table('jenis_langganan')
                                    ->select('id_jenis_langganan', 'lama_berlangganan', 'banyak_tagihan')
                                    ->where('status', 'a')
                                    ->get();
                return view('app.langganan.create', compact('kategori', 'pelanggan', 'jenis_langganan', 'provinsi'));
            } catch (\Throwable $e) {
                return redirect()->route('langganan.create')->with('danger', 'Data pelanggan tidak ditemukan! ' . $e->getMessage());
            }
        }
        return view('app.langganan.create');
    }
    public function verifikasi()
    {
        $langganan = DB::table('detail_langganan')->join('langganan', 'detail_langganan.id_langganan', '=', 'langganan.id_langganan')
                    ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                    ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('langganan.id_langganan', 'langganan.kode_langganan', 'langganan.alamat_pemasangan', 'langganan.status', 'langganan.histori', 'pelanggan.nama_pelanggan', 'produk.nama_produk', 'kategori.nama_kategori', 'jenis_langganan.lama_berlangganan')
                    ->where('langganan.status', 'pn')
                    ->orWhere('langganan.status', 'dt')
                    ->get();
        return view('app.langganan.verifikasi', compact('langganan'));
    }
    public function store(LanggananRequest $request)
    {
        try {
            $pelanggan = Pelanggan::findOrFail($request->pelanggan);
            $this->middleware('complete.document:' . $pelanggan);
            $desa = Desa::findOrFail($request->desa);
            $jenis_langganan = JenisLangganan::findOrFail($request->jenis_langganan);
            $produk = Produk::findOrFail($request->produk);
            $check = DB::table('langganan')->select(DB::raw('MAX(RIGHT(id_langganan, 5)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.05d", $temp);
                }
            } else {
                $code = "00001";
            }
            $langganan = Langganan::create([
                'id_langganan' => 'L' . $code,
                'id_produk' => $produk->id_produk,
                'id_pelanggan' => $pelanggan->id_pelanggan,
                'kode_langganan' => Str::upper(Str::random(15)),
                'alamat_pemasangan' => $request->alamat,
                'id_desa' => $desa->id_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'tanggal_verifikasi' => Carbon::now(),
                'status' => 'a',
                'histori' => 'Terdaftar|Diterima|Melakukan Pembayaran',
                'pesan' => 'Selamat! Langganan anda telah didaftarkan dan disetujui.',
            ]);
            $check2 = DB::table('detail_langganan')->select(DB::raw('MAX(RIGHT(id_detail_langganan, 5)) AS kode'));
            if ($check2->count() > 0) {
                foreach ($check2->get() as $c) {
                    $temp2 = ((int) $c->kode) + 1;
                    $code2 = sprintf("%'.05d", $temp2);
                }
            } else {
                $code2 = "00001";
            }
            DetailLangganan::create([
                'id_detail_langganan' => 'DL' . $code2,
                'id_langganan' => $langganan->id_langganan,
                'id_jenis_langganan' => $jenis_langganan->id_jenis_langganan,
                'sisa_tagihan' => $jenis_langganan->banyak_tagihan,
                'status' => 'a',
                'status_pembayaran' => 'bl'
            ]);
            return redirect()->route('langganan.index')->with('success', 'Berhasil mendaftarkan langganan dengan ID Langganan ' . $langganan->kode_langganan);
        } catch (\Throwable $e) {
            return redirect()->route('langganan.create')->with('danger', 'Gagal mendaftarkan langganan! ' . $e->getMessage());
        }
    }
    public function show($id)
    {
        $langganan = DB::table('langganan')->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                    ->join('kategori', 'produk.id_kategori', '=', 'kategori.id_kategori')
                    ->join('desa', 'langganan.id_desa', '=', 'desa.id_desa')
                    ->join('kecamatan', 'desa.id_kecamatan', '=', 'kecamatan.id_kecamatan')
                    ->join('kabupaten', 'kecamatan.id_kabupaten', '=', 'kabupaten.id_kabupaten')
                    ->join('provinsi', 'kabupaten.id_provinsi', '=', 'provinsi.id_provinsi')
                    ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                    ->select('langganan.id_langganan', 'langganan.kode_langganan', 'produk.nama_produk', 'kategori.nama_kategori', 'langganan.status AS status_langganan', 'langganan.tanggal_verifikasi', 'langganan.tanggal_instalasi', 'langganan.histori', 'langganan.alamat_pemasangan', 'provinsi.nama_provinsi', 'kabupaten.nama_kabupaten', 'kecamatan.nama_kecamatan', 'desa.nama_desa', 'pelanggan.nama_pelanggan', 'pelanggan.nik', 'pelanggan.jenis_kelamin', 'pelanggan.status AS status_pelanggan', 'pelanggan.nomor_hp', 'pelanggan.email', 'pelanggan.id_pelanggan')
                    ->where('langganan.id_langganan', $id)
                    ->first();
        $detailLangganan = DB::table('detail_langganan')->where('id_langganan', $langganan->id_langganan)->where('status', 'a')->first();
        $semuaDetailLangganan = DB::table('detail_langganan')
                                ->join('jenis_langganan', 'detail_langganan.id_jenis_langganan', '=', 'jenis_langganan.id_jenis_langganan')
                                ->select('jenis_langganan.lama_berlangganan AS jenis_berlangganan', 'detail_langganan.*')
                                ->where('detail_langganan.id_langganan', $langganan->id_langganan)
                                ->get();
        // dd($detailLangganan);
        return view('app.langganan.show', compact('langganan', 'detailLangganan', 'semuaDetailLangganan'));
    }
    public function reject(Request $request, $id)
    {
        try {
            $langganan = Langganan::where('id_langganan', $id)->firstOrFail();
            $langganan->update([
                'pesan' => $request->pesan == null ? 'Pengajuan ditolak! Harap periksa kembali pengajuan dan syarat yang ditentukan!' : $request->pesan,
                'status' => 'dt'
            ]);
            return redirect()->route('langganan.verifikasi.index')->with('success', 'Berhasil menolak langganan!');
        } catch (\Throwable $th) {
            return back()->with('danger', 'Gagal menolak langganan! ' . $th->getMessage());
        }
    }
    public function verify($id)
    {
        try {
            $langganan = Langganan::where('id_langganan', $id)->firstOrFail();
            $langganan->update([
                'status' => 'dtr',
                'tanggal_verifikasi' => Carbon::now(),
                'histori' => $langganan->histori . '|Melakukan Pembayaran',
                'pesan' => 'Langganan telah disetujui! Harap segera melakukan pembayaran!'
            ]);
            return redirect()->route('langganan.verifikasi.index')->with('success', 'Berhasil menerima langganan!');
        } catch (\Throwable $th) {
            return back()->with('danger', 'Gagal menerima langganan! ' . $th->getMessage());
        }
    }
    public function schedule()
    {
        $schedule = Langganan::with('pelanggan', 'desa')->where('tanggal_instalasi', '!=', null)->where('status', 'pmi')->get();
        $data = [];
        $today = Carbon::parse(date_create(now('+0700')))->format('Y-m-d');
        foreach ($schedule as $s) {
            $color = '';
            $desc = '';
            if ($s->tanggal_instalasi < $today) {
                $color = '#FC766AFF';
                $desc = 'Harap lakukan instalasi!';
            }
            elseif($s->tanggal_instalasi > $today) {
                $color = '#184A45FF';
                $desc = 'Instalasi belum dimulai!';
            }else {
                $color = 'green';
                $desc = 'Ada jadwal instalasi hari ini!';
            }
            array_push($data, [
                'title' => $s->pelanggan->nama_pelanggan,
                'backgroundColor' => $color,
                'borderColor' => $s->tanggal_instalasi < $today ? 'red' : 'green',
                'start' => $s->tanggal_instalasi,
                'end' => $s->tanggal_instalasi,
                'address' => $s->alamat_pemasangan,
                'desa' => $s->desa->nama_desa,
                'kecamatan' => $s->desa->kecamatan->nama_kecamatan,
                'kabupaten' => $s->desa->kecamatan->kabupaten->nama_kabupaten,
                'provinsi' => $s->desa->kecamatan->kabupaten->provinsi->nama_provinsi,
                'rtrw' => $s->rt . '/' . $s->rw,
                'kodepos' => $s->desa->kode_pos,
                'lat' => $s->latitude,
                'long' => $s->longitude,
                'avatar' => url($s->pelanggan->foto),
                'subscription_id' => 'ID Langganan - ' . $s->kode_langganan,
                'note' => 'Catatan : ' . $desc,
            ]);
        }
        $data = json_encode($data);
        return view('app.langganan.jadwal', compact('data', 'today'));
    }
    public function searchSchedule(Request $request)
    {
        if ($request->ajax()) {
            $langganan = DB::table('langganan')
                        ->join('pelanggan', 'langganan.id_pelanggan', '=', 'pelanggan.id_pelanggan')
                        ->join('produk', 'langganan.id_produk', '=', 'produk.id_produk')
                        ->select('langganan.kode_langganan', 'pelanggan.nama_pelanggan', 'produk.nama_produk', 'langganan.status AS status_langganan')
                        ->where('langganan.kode_langganan', 'like',  '%' . $request->jenis . '%')
                        ->get()
                        ->map(function($langganan)
                        {
                            if ($langganan->status_langganan == 'a') {
                                $status = 'aktif';
                            }elseif ($langganan->status_langganan == 'n') {
                                $status = 'nonaktif';
                            }elseif ($langganan->status_langganan == 'pn') {
                                $status = 'pengajuan';
                            }elseif ($langganan->status_langganan == 'dt') {
                                $status = 'ditolak';
                            }elseif ($langganan->status_langganan == 'dtr') {
                                $status = 'diterima';
                            }elseif ($langganan->status_langganan == 'pni') {
                                $status = 'pengajuan instalasi';
                            }elseif ($langganan->status_langganan == 'pmi') {
                                $status = 'pemasangan instalasi';
                            }
                            $langganan->status_langganan = $status;
                            return $langganan;
                        });
            return response()->json($langganan);
        }
    }
    public function makeSchedule(Request $request)
    {
        $valid = $request->validate([
            'langganan' => 'required',
            'tanggal_pengajuan' => 'required|date'
        ], [
            'langganan.required' => 'ID Langganan tidak boleh kosong!',
            'tanggal_pengajuan.required' => 'Tanggal pengajuan tidak boleh kosong!',
            'tanggal_pengajuan.date' => 'Format tanggal pengajuan salah!',
        ]);
        try {
            $now = Carbon::parse(date_create(now('+0700')));
            // dd($request->all());
            if ($valid['tanggal_pengajuan'] < $now) {
                return redirect()->route('langganan.schedule')->with('danger', 'Tanggal pengajuan harus lebih besar dari tanggal sekarang!');
            }
            $langganan = Langganan::where('kode_langganan', $valid['langganan'])->firstOrFail();
            if ($langganan->status != 'pni') {
                return redirect()->route('langganan.schedule')->with('danger', 'Langganan yang diajukan tidak dalam pengajuan pemasangan instalasi!');
            }
            if ($langganan->tanggal_instalasi != null) {
                return redirect()->route('langganan.schedule')->with('danger', 'Langganan telah di instalasi!');
            }
            $langganan->update([
                'tanggal_instalasi' => Carbon::parse($valid['tanggal_pengajuan']),
                'status' => 'pmi'
            ]);
            return redirect()->route('langganan.schedule')->with('success', 'Berhasil mengajukan tanggal instalasi');
        } catch (\Throwable $th) {
            return redirect()->route('langganan.schedule')->with('danger', 'Gagal mengajukan tanggal instalasi! ' . $th->getMessage());
        }
    }
}
