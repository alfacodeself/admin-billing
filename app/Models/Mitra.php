<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;
    protected $table = 'mitra';
    protected $guarded = [];
    protected $primaryKey = 'id_mitra';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function dokumen_mitra()
    {
        return $this->hasMany(DokumenMitra::class, 'id_mitra');
    }
    public function detail_mitra_pelanggan()
    {
        return $this->hasMany(DetailMitraPelanggan::class, 'id_mitra');
    }
}
