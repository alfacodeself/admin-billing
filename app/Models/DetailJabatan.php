<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJabatan extends Model
{
    use HasFactory;
    protected $table = 'detail_jabatan';
    protected $guarded = [];
    protected $primaryKey = 'id_detail_jabatan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas');
    }
    public function jenis_jabatan()
    {
        return $this->belongsTo(JenisJabatan::class, 'id_jenis_jabatan');
    }
    public function detail_permission()
    {
        return $this->hasMany(DetailPermission::class, 'id_detail_jabatan');
    }
}
