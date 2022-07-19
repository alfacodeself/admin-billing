<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    use HasFactory;
    protected $table = 'petugas';
    protected $guarded = [];
    protected $primaryKey = 'id_petugas';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function detail_jabatan()
    {
        return $this->hasMany(DetailJabatan::class, 'id_petugas');
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_petugas');
    }
}