<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $guarded = [];
    protected $primaryKey = 'id_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $hidden = [
        'kode_pesanan',
        'kode_toko'
    ];
    public function metode_pembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'id_metode_pembayaran');
    }
    public function langganan()
    {
        return $this->belongsTo(Langganan::class, 'id_langganan');
    }
    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }
    public function detail_transaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
    public function dana_mitra()
    {
        return $this->hasOne(DanaMitra::class, 'id_transaksi');
    }
}
