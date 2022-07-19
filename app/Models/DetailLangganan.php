<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailLangganan extends Model
{
    use HasFactory;
    protected $table = 'detail_langganan';
    protected $guarded = [];
    protected $primaryKey = 'id_detail_langganan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function langganan()
    {
        return $this->belongsTo(Langganan::class, 'id_langganan');
    }
    public function jenis_langganan()
    {
        return $this->belongsTo(JenisLangganan::class, 'id_jenis_langganan');
    }
}
