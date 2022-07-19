<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    use HasFactory;
    protected $table = 'jenis_dokumen';
    protected $guarded = [];
    protected $primaryKey = 'id_jenis_dokumen';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function dokumen_pelanggan()
    {
        return $this->hasMany(DokumenPelanggan::class, 'id_jenis_dokumen');
    }
}
