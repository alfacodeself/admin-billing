<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanaMitra extends Model
{
    use HasFactory;
    protected $table = 'dana_mitra';
    protected $guarded = [];
    protected $primaryKey = 'id_dana_mitra';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function detail_bagi_hasil()
    {
        return $this->belongsTo(DetailBagiHasil::class, 'id_detail_bagi_hasil');
    }
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
