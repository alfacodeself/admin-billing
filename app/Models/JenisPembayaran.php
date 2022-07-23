<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    use HasFactory;
    protected $table = 'jenis_pembayaran';
    protected $guarded = [];
    protected $primaryKey = 'id_jenis_pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function detail_transaksi()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_jenis_pembayaran');
    }
}
