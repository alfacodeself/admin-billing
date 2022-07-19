<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisJabatan extends Model
{
    use HasFactory;
    protected $table = 'jenis_jabatan';
    protected $guarded = [];
    protected $primaryKey = 'id_jenis_jabatan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function jenis_jabatan()
    {
        return $this->hasMany(DetailJabatan::class, 'id_jenis_jabatan');
    }
}
