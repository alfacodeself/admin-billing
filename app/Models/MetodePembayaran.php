<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodePembayaran extends Model
{
    use HasFactory;
    protected $table = 'metode_pembayaran';
    protected $guarded = [];
    protected $primaryKey = 'id_metode_pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_metode_pembayaran');
    }
}
