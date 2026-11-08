<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required']);
        $user = DB::table('users')->where('email', $data['email'])->first();

        // Admin accounts must use the separate admin subdomain.
        if (!$user || $user->role !== 'customer' || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Email atau password customer tidak sesuai.'])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('user', ['id' => $user->id_user, 'nama' => $user->nama, 'email' => $user->email, 'role' => 'customer']);
        return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali!');
    }

    public function adminLogin(Request $request)
    {
        $data = $request->validate(['email' => 'required|email', 'password' => 'required']);
        $user = DB::table('users')->where('email', $data['email'])->first();

        if (!$user || $user->role !== 'admin' || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['email' => 'Akun admin tidak ditemukan atau password salah.'])->withInput();
        }

        $request->session()->regenerate();
        $request->session()->put('user', ['id' => $user->id_user, 'nama' => $user->nama, 'email' => $user->email, 'role' => 'admin']);
        return redirect()->intended(route('admin'))->with('success', 'Selamat datang di Admin LuxSkin.');
    }

    public function register(Request $request)
    {
        $data = $request->validate(['nama' => 'required|string|max:100', 'email' => 'required|email|max:150|unique:users,email', 'no_hp' => 'nullable|string|max:20', 'password' => 'required|min:8|confirmed']);
        $id = DB::table('users')->insertGetId(['nama' => $data['nama'], 'email' => $data['email'], 'no_hp' => $data['no_hp'] ?? null, 'password' => Hash::make($data['password']), 'role' => 'customer', 'created_at' => now(), 'updated_at' => now()]);
        $request->session()->put('user', ['id' => $id, 'nama' => $data['nama'], 'email' => $data['email'], 'role' => 'customer']);
        return redirect()->route('home')->with('success', 'Akun berhasil dibuat. Selamat berbelanja!');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda berhasil keluar.');
    }

    public function adminLogout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Anda berhasil keluar dari Admin LuxSkin.');
    }
}
