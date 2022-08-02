<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPermission extends Model
{
    use HasFactory;
    protected $table = 'detail_permission';
    protected $guarded = [];
    protected $primaryKey = 'id_detail_permission';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'id_permission');
    }
    public function detail_jabatan()
    {
        return $this->belongsTo(DetailJabatan::class, 'id_detail_jabatan');
    }
}
