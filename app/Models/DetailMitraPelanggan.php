<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailMitraPelanggan extends Model
{
    use HasFactory;
    protected $table = 'detail_mitra_pelanggan';
    protected $guarded = [];
    protected $primaryKey = 'id_detail_mitra_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }
}
