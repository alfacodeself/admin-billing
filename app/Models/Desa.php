<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;

    use HasFactory;
    protected $table = 'desa';
    protected $guarded = [];
    protected $primaryKey = 'id_desa';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->hasMany(Pelanggan::class, 'id_desa');
    }
    public function langganan()
    {
        return $this->hasMany(Langganan::class, 'id_desa');
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
    }
}
