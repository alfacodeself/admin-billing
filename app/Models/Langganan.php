<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langganan extends Model
{
    use HasFactory;
    protected $table = 'langganan';
    protected $guarded = [];
    protected $primaryKey = 'id_langganan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
    public function detail_langganan()
    {
        return $this->hasMany(DetailLangganan::class, 'id_langganan');
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_langganan');
    }
}
