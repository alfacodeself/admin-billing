<?php

namespace App\Http\Controllers;

use App\Models\DetailJabatan;
use App\Models\DetailPermission;
use Carbon\Carbon;
use App\Models\Petugas;
use Illuminate\Support\Str;
use App\Models\JenisJabatan;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = DB::table('detail_jabatan')
                    ->join('petugas', 'detail_jabatan.id_petugas', '=', 'petugas.id_petugas')
                    ->join('jenis_jabatan', 'detail_jabatan.id_jenis_jabatan', '=', 'jenis_jabatan.id_jenis_jabatan')
                    ->select('petugas.id_petugas', 'petugas.nama_petugas', 'petugas.status', 'petugas.foto', 'detail_jabatan.tanggal_jabatan', 'jenis_jabatan.nama_jabatan')
                    ->where('detail_jabatan.status', 'a')
                    ->paginate(10);
        return view('app.petugas.index', compact('petugas'));
    }

    public function create()
    {
        $jabatan = JenisJabatan::where('status', 'a')->get();
        return view('app.petugas.create', compact('jabatan'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg,svg,gif,jfif|max:2048',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:mitra,nomor_hp',
            'email' => 'required|unique:petugas,email|email',
            'jabatan' => 'required'
        ], [
            'foto.required' => 'Foto harus di isi!',
            'foto.image' => 'Foto harus berupa gambar!',
            'foto.mimes' => 'Foto harus memiliki format png,jpg,jpeg,svg,gif,jfif!',
            'foto.max' => 'Foto maksimal sebesar 2MB (2048KB)!',
            'nama.required' => 'Nama harus di isi!',
            'jenis_kelamin.required' => 'Jenis kelamin harus di isi!',
            'nomor_hp.required' => 'Nomor telpon harus di isi!',
            'nomor_hp.numeric' => 'Nomor telpon harus berupa angka!',
            'nomor_hp.digits_between' => 'Nomor telpon minimal 9 digit dan maksimal 15 digit!',
            'nomor_hp.unique' => 'Nomor telpon telah terdaftar!',
            'email.required' => 'Email harus di isi!',
            'email.numeric' => 'Email harus berformat email!',
            'email.unique' => 'Email telah terdaftar!',
            'jabatan.required' => 'Jabatan tidak boleh kosong'
        ]);
        try {
            $jabatan = JenisJabatan::where('id_jenis_jabatan', $request->jabatan)->first();
            if ($jabatan == null) {
                return redirect()->back()->with('danger', 'Jabatan tidak ditemukan');
            }
            $check = DB::table('petugas')->select(DB::raw('MAX(RIGHT(id_petugas, 3)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.03d", $temp);
                }
            } else {
                $code = "001";
            }
            $foto = "fotopetugas-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/petugas/foto', $foto);
            $path = Storage::url($send);
            $petugas = Petugas::create([
                'id_petugas' => 'PTS' . $code,
                'foto' => $path,
                'nama_petugas' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'nomor_hp' => $request->nomor_hp,
                'status' => 'a',
                'email' => $request->email,
                'password' => bcrypt('petugas123')
            ]);
            // ===============> Detail Jabatab <===============
            $check2 = DB::table('detail_jabatan')->select(DB::raw('MAX(RIGHT(id_detail_jabatan, 4)) AS kode'));
            if ($check2->count() > 0) {
                foreach ($check2->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code2 = sprintf("%'.04d", $temp);
                }
            } else {
                $code2 = "0001";
            }
            DetailJabatan::create([
                'id_detail_jabatan' => 'DJ' . $code2,
                'id_jenis_jabatan' => $jabatan->id_jenis_jabatan,
                'id_petugas' => $petugas->id_petugas,
                'status' => 'a',
                'tanggal_jabatan' => Carbon::now()
            ]);
            return redirect()->route('petugas.index')->with('success', 'Berhasil menambah petugas ' . $petugas->nama_petugas);
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()->route('petugas.create')->with('danger', 'Gagal menambah petugas ' . $th->getMessage());
        }
    }
    public function show($id)
    {
        $petugas = DB::table('detail_jabatan')
                    ->join('petugas', 'detail_jabatan.id_petugas', '=', 'petugas.id_petugas')
                    ->join('jenis_jabatan', 'detail_jabatan.id_jenis_jabatan', '=', 'jenis_jabatan.id_jenis_jabatan')
                    ->select('petugas.id_petugas', 'petugas.nama_petugas', 'petugas.jenis_kelamin', 'petugas.nomor_hp', 'petugas.email', 'petugas.status', 'petugas.foto', 'detail_jabatan.tanggal_jabatan', 'jenis_jabatan.nama_jabatan')
                    ->where('detail_jabatan.status', 'a')
                    ->where('petugas.id_petugas', $id)
                    ->first();
        $history = DB::table('detail_jabatan')
                    ->join('jenis_jabatan', 'detail_jabatan.id_jenis_jabatan', '=', 'jenis_jabatan.id_jenis_jabatan')
                    ->select('jenis_jabatan.nama_jabatan AS jabatan', 'detail_jabatan.status', 'detail_jabatan.tanggal_jabatan')
                    ->where('detail_jabatan.id_petugas', $id)
                    ->get();
        $jabatan = DB::table('jenis_jabatan')->select('id_jenis_jabatan', 'nama_jabatan')->where('status', 'a')->get();
        // dd($petugas, $history);
        return view('app.petugas.show', compact('petugas', 'history', 'jabatan'));
    }
    public function updateFoto($id, Request $request)
    {
        $petugas = Petugas::where('id_petugas', $id)->firstOrFail();
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048'
        ], [
            'foto.required' => 'Foto tidak boleh kosong!',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto hanya boleh memiliki format png,jpg,jpeg,gif,svg',
            'foto.max' => 'Foto maksimal sebesar 2MB (2048KB)'
        ]);
        try {
            if ($petugas->foto !== null) @unlink(public_path($petugas->foto));
            $foto = "fotopetugas-". Str::random(5) . time() . '.' . $request->file('foto')->extension();
            $send = $request->file('foto')->storeAs('public/petugas/foto', $foto);
            $path = Storage::url($send);
            $petugas->update(['foto' => $path]);
            return redirect()->route('petugas.show', $petugas->id_petugas)->with('success', 'Berhasil mengubah foto petugas!');
        } catch (\Throwable $th) {
            // return $th->getMessage();
            return redirect()->route('petugas.show')->with('error', 'Gagal menambah petugas ' . $th->getMessage());
        }
    }
    public function updateJabatan($id, Request $request)
    {
        $petugas = DetailJabatan::with('detail_permission')->where('id_petugas', $id)->where('status', 'a')->firstOrFail();
        $request->validate([
            'jabatan' => 'required',
            'permission' => 'required'
        ], [
            'jabatan.required' => 'Jabatan tidak boleh kosong!',
        ]);
        $jabatan = JenisJabatan::where('id_jenis_jabatan', $request->jabatan)->first();
        $permission = Permission::whereIn('id_permission', $request->permission)->get();
        if ($jabatan == null) {
            return redirect()->back()->with('danger', 'Jabatan tidak di temukan!');
        }
        // elseif ($jabatan->id_jenis_jabatan == $petugas->id_jenis_jabatan) {
        //     return redirect()->back()->with('warning', 'Petugas saat ini sudah memiliki jabatan yang dipilih!');
        // }
        if ($permission->count() != count($request->permission)) {
            return redirect()->back()->with('danger', 'ID permission bermasalah!');
        }
        try {
            $petugas->update(['status' => 'n']);
            $nowPermission = $petugas->detail_permission->where('id_detail_jabatan', $petugas->id_detail_jabatan)->where('status', 'a');
            if ($nowPermission->count() != 0) {
                foreach ($nowPermission as $n) {
                    $n->update(['status' => 'n']);
                }
            }
            $check = DB::table('detail_jabatan')->select(DB::raw('MAX(RIGHT(id_detail_jabatan, 4)) AS kode'));
            if ($check->count() > 0) {
                foreach ($check->get() as $c) {
                    $temp = ((int) $c->kode) + 1;
                    $code = sprintf("%'.04d", $temp);
                }
            } else {
                $code = "0001";
            }
            $detail_jabatan = DetailJabatan::create([
                'id_detail_jabatan' => 'DJ' . $code,
                'id_jenis_jabatan' => $jabatan->id_jenis_jabatan,
                'id_petugas' => $petugas->id_petugas,
                'status' => 'a',
                'tanggal_jabatan' => Carbon::now()
            ]);
            foreach ($permission as $p) {
                $check2 = DB::table('detail_permission')->select(DB::raw('MAX(RIGHT(id_detail_permission, 5)) AS kode'));
                if ($check2->count() > 0) {
                    foreach ($check2->get() as $c) {
                        $temp = ((int) $c->kode) + 1;
                        $code = sprintf("%'.05d", $temp);
                    }
                } else {
                    $code = "00001";
                }
                DetailPermission::create([
                    'id_detail_permission' => 'DPERM' . $code,
                    'id_permission' => $p->id_permission,
                    'id_detail_jabatan' => $detail_jabatan->id_detail_jabatan,
                    'status' => 'a',
                    'tanggal_permission' => Carbon::now()
                ]);
            }
            return redirect()->route('pengaturan.rolepermission.index')->with('success', 'Berhasil mengubah jabatan petugas!');
        } catch (\Throwable $th) {
            return redirect()->route('pengaturan.rolepermission.edit', $petugas->id_petugas)->with('error', 'Gagal mengubah jabatan petugas! ' . $th->getMessage());
        }
    }
    public function offPermission($id)
    {
        $petugas = DetailJabatan::with('detail_permission')->where('id_petugas', $id)->where('status', 'a')->firstOrFail();
        try {
            $nowPermission = $petugas->detail_permission->where('status', 'a');
            if ($nowPermission->count() != 0) {
                foreach ($nowPermission as $n) {
                    $n->update(['status' => 'n']);
                }
            }
            return redirect()->route('pengaturan.rolepermission.index')->with('success', 'Berhasil menghapus semua permission petugas!');
        } catch (\Throwable $th) {
            return redirect()->route('pengaturan.rolepermission.edit', $petugas->id_petugas)->with('error', 'Gagal menghapus semua permission petugas! ' . $th->getMessage());
        }
    }
    public function updateProfil(Request $request, $id)
    {
        $petugas = Petugas::where('id_petugas', $id)->firstOrFail();
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email|unique:petugas,email,'. $petugas->id_petugas . ',id_petugas',
            'nomor_hp' => 'required|numeric|digits_between:9,15|unique:petugas,nomor_hp,'. $petugas->id_petugas . ',id_petugas',
            'status' => 'required'
        ], [
            'nama.required' => 'Nama tidak boleh kosong!',
            'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong!',
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Email harus memiliki format email!',
            'email.unique' => 'Tidak dapat menggunakan Email yang sudah ada!',
            'nomor_hp.required' => 'Nomor Handphone tidak boleh kosong!',
            'nomor_hp.numeric' => 'Nomor Handphone harus berupa angka!',
            'nomor_hp.digits' => 'Nomor Handphone minimal 9 digit dan maksimal 15 digit!',
            'nomor_hp.unique' => 'Tidak dapat menggunakan Nomor Handphone yang sudah ada!',
            'status.required' => 'Status tidak boleh kosong!',
        ]);
        try {
            $petugas->update([
                'nama_petugas' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'email' => $request->email,
                'nomor_hp' => $request->nomor_hp,
                'status' => $request->status,
            ]);
            return redirect()->route('petugas.show', $petugas->id_petugas)->with('success', 'Berhasil mengubah profil petugas!');
        } catch (\Throwable $th) {
            return $th->getMessage();
            return redirect()->route('petugas.show')->with('error', 'Gagal menambah petugas ' . $th->getMessage());
        }
    }
}
