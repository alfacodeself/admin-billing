<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Mitra;
use App\Models\Petugas;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\EmailResetPassword;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    public function email_reset()
    {
        return view('app.auth.email-reset-password');
    }
    public function email_reset_post(Request $request)
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
            $tokenUsing = DB::table('reset_password')
                            ->where('id_pemohon', $petugas->id_petugas)
                            ->where('status_pemohon', 'pt')
                            ->where('status_token', 'using')
                            ->first();
            if ($tokenUsing == null) {
                $id = DB::table('reset_password')->insertGetId([
                    'token' => Str::random(60),
                    'id_pemohon' => $petugas->id_petugas,
                    'status_pemohon' => 'pt',
                    'status_token' => 'using',
                    'waktu_expired' => Carbon::now()->addHour()
                ]);
                $token = DB::table('reset_password')
                        ->where('id_reset_password', $id)
                        ->first();
                Mail::to($petugas->email)->send(new EmailResetPassword($petugas->nama_petugas, $token->token));
            }else {
                Mail::to($petugas->email)->send(new EmailResetPassword($petugas->nama_petugas, $tokenUsing->token));
            }
            return back()->with('success', 'Email reset password telah di kirim ke ' . $petugas->email);
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
    public function reset_password($token)
    {
        $reset = DB::table('reset_password')->where('token', $token)->first();
        if ($reset == null) {
            return redirect()->route('reset-password.email')->with('danger', 'Token anda salah! Harap ajukan reset password kembali!');
        }elseif ($reset->status_token == 'expired' || Carbon::now() > Carbon::parse($reset->waktu_expired)) {
            return redirect()->route('reset-password.email')->with('danger', 'Token anda expired! Harap ajukan reset password kembali!');
        }
        return view('app.auth.reset-password', compact('reset'));
    }
    public function reset_password_post(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:5|confirmed',
            'token' => 'required'
        ], [
            'new_password.required' => "Password Baru tidak bolek kosong!",
            'new_password.min' => "Password minimal 5 karakter!",
            'new_password.confirmed' => "Konfirmasi password tidak sama!",
            'token.required' => "Invalid Token"
        ]);
        try {
            $reset = DB::table('reset_password')->where('token', $request->token)->first();
            if ($reset == null) {
                return redirect()->route('reset-password.email')->with('danger', 'Token anda salah! Harap ajukan reset password kembali!');
            }elseif ($reset->status_token == 'expired' || Carbon::now() > Carbon::parse($reset->waktu_expired)) {
                return redirect()->route('reset-password.email')->with('danger', 'Token anda expired! Harap ajukan reset password kembali!');
            }
            // Tentukan user berdasarkan status pemohon
            if ($reset->status_pemohon == 'pt') {
                $user = Petugas::where('id_petugas', $reset->id_pemohon)->first();
            }elseif ($reset->status_pemohon == 'm') {
                $user = Mitra::where('id_mitra', $reset->id_pemohon)->first();;
            }else {
                $user = Pelanggan::where('id_mitra', $reset->id_pemohon)->first();
            }
            if ($user == null) {
                return redirect()->route('login')->with('danger', 'User tidak ditemukan!');
            }
            $user->update([
                'password' => bcrypt($request->new_password)
            ]);
            DB::table('reset_password')->where('token', $request->token)->update(['status_token' => 'expired']);
            return redirect()->route('login')->with('success', 'Berhasil mengganti password anda!');
        } catch (\Throwable $th) {
            return redirect()->route('login')->with('danger', $th->getMessage());
        }
    }
}
