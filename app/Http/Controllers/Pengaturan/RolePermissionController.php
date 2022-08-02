<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\JenisJabatan;
use App\Models\Permission;
use App\Models\Petugas;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $jabatan = JenisJabatan::get();
        $permission = Permission::get();
        $petugas = Petugas::with('detail_jabatan.detail_permission.permission', 'detail_jabatan.jenis_jabatan')->select('nama_petugas', 'id_petugas')->get()->map(function($petugas){
            $petugas->jabatan = $petugas->detail_jabatan->where('status', 'a')->first();
            $petugas->permission = $petugas->jabatan->detail_permission->where('status', 'a');
            return $petugas;
        });
        // dd($petugas);
        return view('app.pengaturan.role', compact('jabatan', 'permission', 'petugas'));
    }
    public function edit($id)
    {
        $petugas = Petugas::with('detail_jabatan.jenis_jabatan', 'detail_jabatan.detail_permission.permission')->findOrFail($id);
        $jabatan = JenisJabatan::where('status', 'a')->get();
        $jabatanPetugas = $petugas->detail_jabatan->where('status', 'a')->first()->jenis_jabatan;
        $permission = Permission::where('status', 'a')->get();
        return view('app.pengaturan.edit-role', compact('petugas', 'jabatan', 'permission', 'jabatanPetugas'));
    }
    public function store(Request $request)
    {
        dd($request->all());
    }
}
