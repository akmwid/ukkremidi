<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $user_input = $request->user_input; // Bisa NIS atau Username
        $password = $request->password;

        // 1. Cek apakah dia Admin
        $admin = Admin::where('username', $user_input)->first();
        // Di dalam AuthController.php bagian admin login
        if ($admin) {
            if (Hash::check($password, $admin->password)) {
                Session::put('role', 'admin');
                Session::put('admin', true);
                Session::put('username', $admin->username);

                // TAMBAHKAN BARIS INI
                Session::put('nama', $admin->nama);

                return redirect('/admin/dashboard');
            }
        }

        // 2. Cek apakah dia Siswa (Sekarang dengan Password)
        $siswa = Siswa::where('nis', $user_input)->first();
        if ($siswa) {
            // Kita gunakan Hash::check untuk memverifikasi password terenkripsi
            if (Hash::check($password, $siswa->password)) {
                Session::put('role', 'siswa');
                Session::put('nis', $siswa->nis);
                return redirect('/'); // Ke halaman input aspirasi
            } else {
                return back()->with('error', 'Password Siswa Salah!');
            }
        }

        return back()->with('error', 'User tidak ditemukan!');
    }

    public function registerPage()
    {
        return view('auth.register');
    }

    public function registerProses(Request $request)
    {
        // Validasi input ditambah password
        $request->validate([
            'nis'      => 'required|unique:siswa,nis|numeric',
            'kelas'    => 'required',
            'password' => 'required|min:5' // Minimal 5 karakter agar aman
        ]);

        // Simpan ke tabel Siswa dengan HASHING password
        Siswa::create([
            'nis'      => $request->nis,
            'kelas'    => $request->kelas,
            'password' => Hash::make($request->password) // WAJIB di-hash
        ]);

        return redirect('/login')->with('success', 'Registrasi Berhasil! Silahkan login dengan NIS dan Password anda.');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}
