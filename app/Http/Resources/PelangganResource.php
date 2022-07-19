<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PelangganResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return ["data" => [

            "id" => $this->id_pelanggan,
            "nama" => $this->nama_pelanggan,
            "nik" => $this->nik,
            "foto" => url($this->foto),
            "jenis_kelamin" => $this->jenis_kelamin == "l" ? "Laki-Laki" : "Perempuan",
            "nomor_hp" => '+' . $this->nomor_hp,
            "alamat" => $this->alamat,
            "desa" => $this->desa->nama_desa ?? null,
            "kecamatan" => $this->desa->kecamatan->nama_kecamatan ?? null,
            "kabupaten" => $this->desa->kecamatan->kabupaten->nama_kabupaten ?? null,
            "provinsi" => $this->desa->kecamatan->kabupaten->provinsi->nama_provinsi ?? null,
            "rt" => $this->rt,
            "rw" => $this->rw,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
        ]];
    }
}
