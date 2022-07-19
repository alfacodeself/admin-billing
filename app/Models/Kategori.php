<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategori';
    protected $guarded = [];
    protected $primaryKey = 'id_kategori';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori');
    }
}
