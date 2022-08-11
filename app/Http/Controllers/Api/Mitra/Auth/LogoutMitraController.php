<?php

namespace App\Http\Controllers\Api\Mitra\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutMitraController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            Auth::guard('mitra')->logout();
            return response()->json([
                'status' => true,
                'message' => 'Logout Berhasil!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Logout Gagal!',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }
}
