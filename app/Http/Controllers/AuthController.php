<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        // Validasi input dari pengguna
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:3',
        ]);

        // Cari pengguna yang sudah ada di database
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // jika pengguna ditemukan melakukan autentikasi
            if (Auth::attempt($request->only('email', 'password'))) {
                return redirect()->route('report.index')->with('success', 'Anda berhasil login!');
            } else {
                return redirect()->back()->with('failed', 'Email atau password salah!');
            }
        } else {
            // Jika pengguna tidak ditemukan, buat pengguna baru sebagai guest
            $guest = [
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ];

            $guestUser = User::create($guest);

            // Autentikasi pengguna baru sebagai guest
            Auth::login($guestUser);
            return redirect()->route('report.index')->with('success', 'Anda berhasil login!');
        }
        
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Menghapus sesi pengguna yang sedang login

        // Menghapus session untuk keamanan
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
