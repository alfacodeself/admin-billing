<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LanggananResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id_langganan,
            'id_langganan' => $this->kode_langganan,
            'produk' => $this->produk->nama_produk,
            'kategori' => $this->produk->kategori->nama_kategori,
            'harga' => $this->produk->withmargin,
            'status' => $this->status,
            'tanggal_instalasi' => $this->tanggal_instalasi ?? 'Belum Instalasi',
            'tanggal_verifikasi' => $this->tanggal_verifikasi ?? 'Belum Disetujui'
        ];
    }
}
