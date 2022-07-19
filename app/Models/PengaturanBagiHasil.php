<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanBagiHasil extends Model
{
    use HasFactory;
    protected $table = 'pengaturan_bagi_hasil';
    protected $guarded = [];
    protected $primaryKey = 'id_pengaturan_bagi_hasil';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
