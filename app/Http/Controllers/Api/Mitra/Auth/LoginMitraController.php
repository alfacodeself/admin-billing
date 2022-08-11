<?php

namespace App\Http\Controllers\Api\Mitra\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginMitraController extends Controller
{
    public function __invoke(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!'
        ]);
        try {
            if (!$token = Auth::guard('mitra')->attempt($credential)) {
                return response(['errors' => 'Unauthorized'], 401);
            }
            if (Auth::guard('mitra')->user()->verifikasi_email == null) {
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
                'user' => Auth::guard('mitra')->user()->nama_mitra
            ], 200)->withCookie($cookie);
        } catch (JWTException $exception) {
            return response()->json(['errors' =>'Failed regenerate token!' . $exception->getMessage()], 500);
        }
    }
}
