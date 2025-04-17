<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            dd(get_class($user)); 
            $user->is_online = true;
            $user->save();

            return match ($user->role) {
                'Admin' => redirect('/admin'),
                'AdminMD' => redirect('/admin-maindealers/index'),
                'Peserta' => redirect('/peserta/index'),
                'Juri' => redirect('/juri/index'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput();
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->is_online = false;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
