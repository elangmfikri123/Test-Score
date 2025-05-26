<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        $user = User::where('username', $credentials['username'])->first();

        if ($user && $user->login_token) {
            return back()->withErrors([
                'username' => 'Akun sudah login di Browser lain.',
            ])->withInput();
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $token = Str::uuid(); 
            User::where('id', Auth::id())->update(['login_token' => $token]);
            Session::put('user_id', Auth::id());
            Session::put('login_token', $token);
            $user = Auth::user();

            return match ($user->role) {
                'Admin' => redirect('/admin'),
                'AdminMD' => redirect('/admin-maindealers/index'),
                'Peserta' => redirect('/peserta/index'),
                'Juri' => redirect('/juri/index'),
                default => redirect('/'),
            };
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            User::where('id', Auth::id())->update(['login_token' => null]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax() || $request->isJson() || $request->input('is_ajax')) {
            return response()->json(['status' => 'success']);
        }
        return redirect()->route('login');
    }

    public function checkSession(Request $request)
    {
        if (auth()->check()) {
            return response()->json(['status' => 'active']);
        } else {
            if ($request->hasHeader('X-User-ID')) {
                User::where('id', $request->header('X-User-ID'))->update(['login_token' => null]);
            }
            return response()->json(['status' => 'expired']);
        }
    }
    public function forceLogout($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User tidak ditemukan'], 404);
        }

        $user->login_token = null;
        $user->save();
        DB::table('sessions')->where('user_id', $user->id)->delete();
        return response()->json(['success' => true, 'message' => 'User berhasil di-logout']);
    }
}
