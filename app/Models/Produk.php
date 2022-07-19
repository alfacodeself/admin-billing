<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $guarded = [];
    protected $primaryKey = 'id_produk';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $appends = ['withmargin'];

    public function getWithmarginAttribute()
    {
        $margin = DB::table('pengaturan_pembayaran')->select('harga_margin')->first();
        return $this->harga + $margin->harga_margin;
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    public function langganan()
    {
        return $this->hasMany(Langganan::class, 'id_produk');
    }
}
