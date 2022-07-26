<?php

namespace App\Http\Controllers\Api\Pelanggan\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credential = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ], [
            'nik.required' => 'NIK tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!'
        ]);
        try {
            if (!$token = Auth::guard('pelanggan')->attempt($credential)) {
                return response(['errors' => 'Unauthorized'], 401);
            }
            if (Auth::guard('pelanggan')->user()->verifikasi_email == null) {
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Login gagal!',
                    'errors' => 'Harap melakukan verifikasi email terlebih dahulu!'
                ], Response::HTTP_BAD_REQUEST);
            }
            $cookie = cookie('token', $token, env('JWT_TTL'));
            return response()->json([
                'status' => true,
                'message' => 'Login berhasil!',
                'user' => Auth::guard('pelanggan')->user()->nama_pelanggan
            ], 200)->withCookie($cookie);
        } catch (JWTException $exception) {
            return response()->json(['errors' =>'Failed regenerate token!' . $exception->getMessage()], 500);
        }
    }
}
