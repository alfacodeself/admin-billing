<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mitra extends Authenticatable implements JWTSubject
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
    public function detail_bagi_hasil()
    {
        return $this->hasMany(DetailBagiHasil::class, 'id_mitra');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
