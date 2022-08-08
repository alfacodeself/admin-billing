<?php

namespace App\Http\Controllers\Api\Pelanggan\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutApiController extends Controller
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
            Auth::guard('pelanggan')->logout();
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
