<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable implements JWTSubject
{
    use HasFactory;
    protected $table = 'pelanggan';
    protected $guarded = [];
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'id_desa');
    }
    public function dokumen_pelanggan()
    {
        return $this->hasMany(DokumenPelanggan::class, 'id_pelanggan');
    }
    public function detail_mitra_pelanggan()
    {
        return $this->hasMany(DetailMitraPelanggan::class, 'id_pelanggan');
    }
    public function langganan()
    {
        return $this->hasMany(Langganan::class, 'id_pelanggan');
    }

    protected $hidden = [
        'password',
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

