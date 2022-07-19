<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;
    protected $table = 'kecamatan';
    protected $guarded = [];
    protected $primaryKey = 'id_kecamatan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function desa()
    {
        return $this->hasMany(Desa::class, 'id_kecamatan');
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'id_kabupaten');
    }
}
