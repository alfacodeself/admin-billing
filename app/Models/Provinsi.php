<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    use HasFactory;
    protected $table = 'provinsi';
    protected $guarded = [];
    protected $primaryKey = 'id_provinsi';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function kabupaten()
    {
        return $this->hasMany(Kabupaten::class, 'id_provinsi');
    }
}
