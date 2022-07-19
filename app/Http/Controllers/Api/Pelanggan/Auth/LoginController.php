<?php

namespace App\Http\Controllers\Api\Pelanggan\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credential = $request->validate([
            'nik' => 'required',
            'password' => 'required'
        ]);
        try {
            if (!$token = Auth::guard('pelanggan')->attempt($credential)) {
                return response(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $exception) {
            return response()->json('Failed regenerate token', 500);
        }
        return response()->json(compact('token'));
    }
}
