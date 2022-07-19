<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenMitra extends Model
{
    use HasFactory;
    protected $table = 'dokumen_mitra';
    protected $guarded = [];
    protected $primaryKey = 'id_dokumen_mitra';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }
    public function jenis_dokumen()
    {
        return $this->belongsTo(JenisDokumen::class, 'id_jenis_dokumen');
    }
    
}
