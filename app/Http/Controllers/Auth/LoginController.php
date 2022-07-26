<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('app.auth.login');
    }
    public function authenticate(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ], [
            'email.required' => 'Email tidak boleh kosong!',
            'email.email' => 'Format email salah!',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 5 karakter'
        ]);
        try {
            Auth::attempt($credential);
            return redirect()->intended(route('dashboard'));
        } catch (\Throwable $th) {
            return back()->with('danger', $th->getMessage());
        }
    }
}
