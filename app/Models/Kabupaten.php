<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;
    protected $table = 'kabupaten';
    protected $guarded = [];
    protected $primaryKey = 'id_kabupaten';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function kecamatan()
    {
        return $this->hasMany(Kecamatan::class, 'id_kabupaten');
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi');
    }
}
