<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Mail;

class VerifikasiEmailController extends Controller
{
    public function verifikasi()
    {
        return view('app.auth.verifikasi');
    }
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email salah!'
        ]);
        try {
            $petugas = Petugas::where('email', $request->email)->first();
            if ($petugas == null) {
                return back()->with('danger', 'Email anda tidak terdaftar! Periksa kembali');
            }
            $tokenUsing = DB::table('verifikasi_email')
                            ->where('id_pemohon', $petugas->id_petugas)
                            ->where('status_pemohon', 'pt')
                            ->where('status_token', 'using')
                            ->first();
            if ($tokenUsing == null) {
                $id = DB::table('verifikasi_email')->insertGetId([
                    'token' => Str::random(60),
                    'id_pemohon' => $petugas->id_petugas,
                    'status_pemohon' => 'pt',
                    'status_token' => 'using'
                ]);
                $token = DB::table('verifikasi_email')
                        ->where('id_verifikasi_email', $id)
                        ->first();
                Mail::to($petugas->email)->send(new VerifikasiEmail($petugas->nama_petugas, $token->token));
            }else {
                Mail::to($petugas->email)->send(new VerifikasiEmail($petugas->nama_petugas, $tokenUsing->token));
            }
            return back()->with('success', 'Email verifikasi telah di kirim ke ' . $petugas->email);
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
    public function proses_verifikasi($token)
    {
        try {
            $verify = DB::table('verifikasi_email')->where('token', $token)->first();
            if ($verify != null) {
                // Tentukan user berdasarkan status pemohon
                if ($verify->status_pemohon == 'pt') {
                    $user = Petugas::where('id_petugas', $verify->id_pemohon)->first();
                }elseif ($verify->status_pemohon == 'm') {
                    $user = Mitra::where('id_mitra', $verify->id_pemohon)->first();;
                }else {
                    $user = Pelanggan::where('id_mitra', $verify->id_pemohon)->first();
                }
                // Kalau belum verifikasi
                if ($user->verifikasi_email == null) {
                    $user->update(['verifikasi_email' => Carbon::now()]);
                    DB::table('verifikasi_email')->where('token', $token)->update(['status_token' => 'expired']);
                    return redirect()->route('login')->with('success', 'Berhasil memverifikasi email! Silakan login.');
                }
                // Kalau sudah terverifikasi
                else {
                    return redirect()->route('login')->with('danger', 'Email anda telah diverifikasi!');
                }
            }else {
                return redirect()->route('login')->with('danger', 'Something went wrong!');
            }
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('danger', $th->getMessage());
        }
    }
}
