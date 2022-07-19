<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPelanggan extends Model
{
    use HasFactory;
    protected $table = 'dokumen_pelanggan';
    protected $guarded = [];
    protected $primaryKey = 'id_dokumen_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function jenis_dokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen');
    }
}
