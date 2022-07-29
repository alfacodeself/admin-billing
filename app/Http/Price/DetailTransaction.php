<?php

namespace App\Http\Price;

use App\Models\DetailBagiHasil;
use Illuminate\Support\Facades\DB;
use App\Models\{Langganan, Pelanggan};

class DetailTransaction
{
    public $jenis_bayar, $detail_mitra;

    public function __construct($id_pelanggan)
    {
        $this->detail_mitra = DB::table('detail_mitra_pelanggan')->where('id_pelanggan', $id_pelanggan)->where('status', 'a')->first();
        $this->jenis_bayar = DB::table('jenis_pembayaran')->select('id_jenis_pembayaran', 'jenis_pembayaran', 'harga', 'jenis_biaya')->where('status', 'a')->get();
    }
    public function getDetailTransaction(Langganan $langganan, Pelanggan $pelanggan, $qty = 1)
    {
        $totalHarga = 0;
        $items = [];
        $detail = [];
        $pelanggan = [
            'first_name'    => $pelanggan->nama_pelanggan,
            'email'         => $pelanggan->email,
            'phone'         => $pelanggan->nomor_hp,
            'billing_address'   => [
                'address'       => $pelanggan->alamat,
                'postal_code'   => $pelanggan->desa->kode_pos
            ],
            'shipping_address'  => [
                'address'       => $langganan->alamat_pemasangan,
                'postal_code'   => $langganan->desa->kode_pos
            ]
        ];
        $langganan->tanggal_instalasi == null ? $index = 0 : $index = 1;
        foreach ($this->jenis_bayar as $key => $jenis) {
            // Validasikan berdasarkan $index dari penentuan biaya instalasi
            if ($key >= $index) {
                // Kalau tipe flat
                if ($jenis->jenis_biaya == 'f') {
                    $harga = $jenis->harga;
                }
                // Kalau presentase
                else {
                    // Harga jenis pembayaran :100 * harga langganan yang telah di margin
                    $x = $jenis->harga / 100 * $langganan->produk->withmargin;
                    $harga = $x;
                }
                // Push data ke variabel items
                array_push($items, [
                    'id'        => $key + 1,
                    'price'     => $harga,
                    'quantity'  => 1,
                    'name'      => $jenis->jenis_pembayaran
                ]);
                array_push($detail, [
                    'id_jenis_pembayaran'   => $jenis->id_jenis_pembayaran,
                    'harga'                 => $harga,
                    'qty'                   => 1,
                    'total_tanggungan'      => $harga,
                    'keterangan'            => $jenis->jenis_pembayaran
                ]);
                // Push total harga dengan harga yang di dapat pada tiap perulangan
                $totalHarga += $harga;
            }
        }
        $hargaBiayaMitra = 0;
        if ($this->detail_mitra != null) {
            // Cek bagi hasil mitra dan penaturannya
            $biaya_mitra = DetailBagiHasil::with('pengaturan_bagi_hasil', 'mitra')->where('id_mitra', $this->detail_mitra->id_mitra)->where('status', 'a')->first();
            // Kalau ada
            if ($biaya_mitra !== null) {
                // Cek apakah pengaturan mitranya flat atau presentase
                if ($biaya_mitra->pengaturan_bagi_hasil->status_jenis == 'f') {
                    // Push ke biaya admin
                    $hargaBiayaMitra += $biaya_mitra->pengaturan_bagi_hasil->besaran;
                }
                // Kalau pengaturan bagi hasil berupa presentase
                else {
                    // Hitung berdasarkan presentase
                    $hasilPersentase = $biaya_mitra->pengaturan_bagi_hasil->besaran / 100 * $langganan->produk->withmargin;
                    // Push ke biaya admin
                    $hargaBiayaMitra += $hasilPersentase;
                }
                // Push ke items
                array_push($items, [
                    'id'        => count($items) + 1,
                    'price'     => $hargaBiayaMitra,
                    'quantity'  => 1,
                    'name'      => 'Biaya Mitra'
                ]);
                array_push($detail, [
                    'id_jenis_pembayaran'   => null,
                    'harga'                 => $hargaBiayaMitra,
                    'qty'                   => 1,
                    'total_tanggungan'      => $hargaBiayaMitra,
                    'keterangan'            => 'Biaya Mitra'
                ]);
                // Push biaya admin ke total harga
                $totalHarga += $hargaBiayaMitra;
            }
        }
        // Harga produk yang sudah di margin + Tagihan yang akan dibayar
        $hargaProduk = $langganan->produk->withmargin * $qty;
        // Push Produk
        array_push($items, [
            'id'        => count($items) + 1,
            'price'     => $langganan->produk->withmargin,
            'quantity'  => $qty,
            'name'      => $langganan->produk->nama_produk . '|' . $langganan->produk->kategori->nama_kategori,
        ]);
        array_push($detail, [
            'id_jenis_pembayaran'   => null,
            'harga'                 => $langganan->produk->withmargin,
            'qty'                   => $qty,
            'total_tanggungan'      => $hargaProduk,
            'keterangan'            => $langganan->produk->nama_produk . '|' . $langganan->produk->kategori->nama_kategori
        ]);
        // Push total dari harga produk
        $totalHarga += $hargaProduk;
        return [
            'user' => $pelanggan,
            'items' => $items,
            'total' => $totalHarga,
            'detail' => $detail
        ];
    }
    public function getInvoice(Langganan $langganan)
    {
        $tagihan = [];
        $langganan->tanggal_instalasi == null ? $index = 0 : $index = 1;
        foreach ($this->jenis_bayar as $key => $jenis) {
            // Validasikan berdasarkan $index dari penentuan biaya instalasi
            if ($key >= $index) {
                // Kalau tipe flat
                if ($jenis->jenis_biaya == 'f') {
                    $harga = $jenis->harga;
                }
                // Kalau presentase
                else {
                    // Harga jenis pembayaran :100 * harga langganan yang telah di margin
                    $x = $jenis->harga / 100 * $langganan->produk->withmargin;
                    $harga = $x;
                }
                // Push data ke variabel items
                array_push($tagihan, [
                    'price'     => $harga,
                    'name'      => $jenis->jenis_pembayaran
                ]);
                // Push total harga dengan harga yang di dapat pada tiap perulangan
                // $totalHarga += $harga;
            }
        }
        $hargaBiayaMitra = 0;
        if ($this->detail_mitra != null) {
            // Cek bagi hasil mitra dan penaturannya
            $biaya_mitra = DetailBagiHasil::with('pengaturan_bagi_hasil', 'mitra')->where('id_mitra', $this->detail_mitra->id_mitra)->where('status', 'a')->first();
            // Kalau ada
            if ($biaya_mitra !== null) {
                // Cek apakah pengaturan mitranya flat atau presentase
                if ($biaya_mitra->pengaturan_bagi_hasil->status_jenis == 'f') {
                    // Push ke biaya admin
                    $hargaBiayaMitra += $biaya_mitra->pengaturan_bagi_hasil->besaran;
                }
                // Kalau pengaturan bagi hasil berupa presentase
                else {
                    // Hitung berdasarkan presentase
                    $hasilPersentase = $biaya_mitra->pengaturan_bagi_hasil->besaran / 100 * $langganan->produk->withmargin;
                    // Push ke biaya admin
                    $hargaBiayaMitra += $hasilPersentase;
                }
                // Push ke items
                array_push($tagihan, [
                    'price'     => $hargaBiayaMitra,
                    'name'      => 'Biaya Mitra'
                ]);
            }
        }
        // Push Produk
        array_push($tagihan, [
            'price'     => $langganan->produk->withmargin,
            'name'      => $langganan->produk->nama_produk . '|' . $langganan->produk->kategori->nama_kategori,
        ]);
        return $tagihan;
    }
}
