<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBagiHasil extends Model
{
    use HasFactory;
    protected $table = 'detail_bagi_hasil';
    protected $guarded = [];
    protected $primaryKey = 'id_detail_bagi_hasil';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }
    public function pengaturan_bagi_hasil()
    {
        return $this->belongsTo(PengaturanBagiHasil::class, 'id_pengaturan_bagi_hasil');
    }
    public function dana_mitra()
    {
        return $this->hasMany(DanaMitra::class, 'id_detail_bagi_hasil');
    }
}
