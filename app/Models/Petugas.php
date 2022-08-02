<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Petugas extends Authenticatable
{
    use HasFactory;
    protected $table = 'petugas';
    protected $guarded = [];
    protected $primaryKey = 'id_petugas';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $hidden = [
        'password',
        'verifikasi_email',
        'remember_token'
    ];

    public function detail_jabatan()
    {
        return $this->hasMany(DetailJabatan::class, 'id_petugas');
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_petugas');
    }

    public function hasAccess($permission)
    {
        $detail_jabatan = $this->detail_jabatan->where('status', 'a')->first();
        foreach ($detail_jabatan->detail_permission as $dp) {
            if ($dp->permission->nama_permission == $permission) {
                return true;
            }
        }
        return false;
    }
    public function isAdmin()
    {
        $detail_jabatan = $this->detail_jabatan->where('status', 'a')->first();
        if ($detail_jabatan->jenis_jabatan->nama_jabatan == 'superadmin' || $detail_jabatan->jenis_jabatan->id_jenis_jabatan == "JJ001") {
            return true;
        }
        return false;
    }
}
