<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisLangganan extends Model
{
    use HasFactory;
    protected $table = 'jenis_langganan';
    protected $guarded = [];
    protected $primaryKey = 'id_jenis_langganan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function detail_langganan()
    {
        return $this->hasMany(DetailLangganan::class, 'id_jenis_langganan');
    }
}
