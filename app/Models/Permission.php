<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permission';
    protected $guarded = [];
    protected $primaryKey = 'id_permission';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function detail_permission()
    {
        return $this->hasMany(DetailPermission::class, 'id_permission');
    }
}
