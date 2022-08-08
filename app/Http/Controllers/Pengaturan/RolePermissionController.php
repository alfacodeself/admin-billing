<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\DetailJabatan;
use App\Models\JenisJabatan;
use App\Models\Permission;
use App\Models\Petugas;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $petugas = DetailJabatan::with('petugas', 'detail_permission', 'jenis_jabatan')->select('id_petugas', 'id_jenis_jabatan', 'id_detail_jabatan')->where('status', 'a')->get()->map(function($p){
            $data = [];
            $data['id_petugas'] = $p->petugas->id_petugas;
            $data['nama_petugas'] = $p->petugas->nama_petugas;
            $data['jabatan'] = $p->jenis_jabatan->nama_jabatan;
            $data['permission'] = $p->detail_permission->load('permission')->where('status', 'a')->map(function($dp){
                return $dp  ->permission->nama_permission;
            })->toArray();
            return $data;
        });
        return view('app.pengaturan.role', compact('petugas'));
    }
    public function show($id)
    {
        $detail = Petugas::with([
            'detail_jabatan' => function($q) {
                $q->with([
                    'jenis_jabatan' => function($q){
                        $q->select('id_jenis_jabatan', 'nama_jabatan');
                    },
                    'detail_permission' => function($q) {
                        $q->with([
                            'permission' => function($q) {
                                $q->select('id_permission', 'nama_permission');
                            }
                        ])->select('id_detail_permission', 'id_permission', 'id_detail_jabatan', 'status');
                    }
                ])->select('id_detail_jabatan', 'id_petugas', 'id_jenis_jabatan', 'tanggal_jabatan', 'status');
            },
            ])->select('id_petugas', 'nama_petugas')->findOrFail($id);
        return view('app.pengaturan.detail-role', compact('detail'));
    }
    public function edit($id)
    {
        $petugas = Petugas::with('detail_jabatan.jenis_jabatan', 'detail_jabatan.detail_permission.permission')->findOrFail($id);

        $jabatan = JenisJabatan::where('status', 'a')->get();

        $jabatanPetugas = $petugas->detail_jabatan->where('status', 'a')->first()->jenis_jabatan;
        $permission = Permission::where('status', 'a')->get();
        return view('app.pengaturan.edit-role', compact('petugas', 'jabatan', 'permission', 'jabatanPetugas'));
    }
    // public function store(Request $request)
    // {
    //     dd($request->all());
    // }
}
