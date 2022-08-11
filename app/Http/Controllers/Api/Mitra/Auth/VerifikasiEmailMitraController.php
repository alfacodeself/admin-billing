<?php

namespace App\Http\Controllers\Api\Mitra\Auth;

use Carbon\Carbon;
use App\Models\Mitra;
use App\Models\Petugas;
use App\Models\Pelanggan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\VerifikasiEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class VerifikasiEmailMitraController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email salah!'
        ]);
        try {
            $mitra = Mitra::where('email', $request->email)->first();
            if ($mitra == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal mengirim email verifikasi!',
                    'errors' => 'Email tidak terdaftar! Silakan periksa kembali!'
                ], Response::HTTP_BAD_REQUEST);
            }
            $tokenUsing = DB::table('verifikasi_email')
                            ->where('id_pemohon', $mitra->id_mitra)
                            ->where('status_pemohon', 'm')
                            ->where('status_token', 'using')
                            ->first();
            if ($tokenUsing == null) {
                $id = DB::table('verifikasi_email')->insertGetId([
                    'token' => Str::random(60),
                    'id_pemohon' => $mitra->id_mitra,
                    'status_pemohon' => 'm',
                    'status_token' => 'using'
                ]);
                $token = DB::table('verifikasi_email')
                        ->where('id_verifikasi_email', $id)
                        ->first();
                Mail::to($mitra->email)->send(new VerifikasiEmail($mitra->nama_mitra, $token->token));
            }else {
                Mail::to($mitra->email)->send(new VerifikasiEmail($mitra->nama_mitra, $tokenUsing->token));
            }
            return response()->json([
                'status' => true,
                'message' => 'Berhasil mengirim email verifikasi mitra!'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirim email verifikasi mitra!',
                'errors' => [$th->getMessage()]
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
