<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $kategori = Kategori::all();

        // Eager Loading relasi agar tidak berat (N+1 Query)
        $query = InputAspirasi::with(['aspirasi', 'siswa', 'kategori']);

        // Filter Kategori
        if ($request->filled('id_kategori')) {
            $query->where('id_kategori', $request->id_kategori);
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('data', 'kategori'));
    }

    public function updateStatus(Request $request, $id)
    {
        // $id di sini adalah id_pelaporan yang sama dengan id_aspirasi
        $aspirasi = Aspirasi::where('id_aspirasi', $id)->first();

        $aspirasi->update([
            'status' => $request->status,
            'feedback' => $request->feedback
        ]);

        return back()->with('success', 'Status Berhasil Diperbarui!');
    }

    public function kategoriIndex()
    {
        $kategori = Kategori::all();
        return view('admin.kategori', compact('kategori'));
    }

    // Simpan Kategori Baru
    public function kategoriStore(Request $request)
    {
        $request->validate(['ket_kategori' => 'required|unique:kategori,ket_kategori']);

        Kategori::create([
            'ket_kategori' => $request->ket_kategori
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // Hapus Kategori
    public function kategoriDestroy($id)
    {
        Kategori::destroy($id);
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
    public function cetakLaporan()
    {
        // 1. Ambil data laporan
        $data = InputAspirasi::with(['siswa', 'kategori', 'aspirasi'])->get();

        // 2. Ambil data dari tabel 'admin' berdasarkan session 'nis' 
        // (Pastikan saat login, NIS admin disimpan di session)
        $admin = DB::table('admin')->where('nama', session('nama'))->first();

        // 3. Kirim ke view
        return view('admin.cetak', compact('data', 'admin'));
    }
}
