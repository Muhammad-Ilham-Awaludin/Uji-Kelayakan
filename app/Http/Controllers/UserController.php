<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        //compact = mangirim data pada view
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'role' => 'staff', // Anda bisa menyesuaikan role sesuai kebutuhan
        ]);

        return redirect()->route('user.index')->with('success', 'Berhasil menambahkan pengguna!');
    }

    // User berfungsi untuk menampilkan data user dan where ('id) berfungsi untuk 
    public function destroy($id)
    {
        //
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function logout()
    {
        //Auth::logout berfungsi untuk melogout atau menghapus data
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }

    public function reset($id)
    {
        $user = User::findOrFail($id);

        $newPassword = 'password123';

        $user->password = bcrypt($newPassword);
        $user->save();

        return redirect()->back()->with('success', "Password untuk {$user->email} berhasil di-reset ke: {$newPassword}");
    }


    public function resetPassword(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Set password baru (contoh: "password123")
        $newPassword = 'password123';

        // Update password di database (hashed)
        $user->password = bcrypt($newPassword);
        $user->save();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', "Password untuk {$user->email} berhasil di-reset ke: {$newPassword}");
    }
}
