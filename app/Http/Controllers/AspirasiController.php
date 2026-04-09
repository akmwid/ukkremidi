<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;
use App\Models\Aspirasi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Session;

class AspirasiController extends Controller
{
    // 1. Halaman Form Input
    public function index()
    {
        $kategori = Kategori::all();
        return view('siswa.input', compact('kategori'));
    }

    // 2. Simpan Aspirasi
    public function store(Request $request)
    {
        $nisSiswa = session('nis');

        // Tambahkan custom message di parameter kedua validate
        $request->validate([
            'id_kategori' => 'required',
            'lokasi'      => 'required',
            'ket'         => 'required',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'foto.max'    => 'Ukuran foto terlalu besar! Maksimal adalah 2MB.',
            'foto.image'  => 'File harus berupa gambar.',
            'foto.mimes'  => 'Format foto harus jpg, jpeg, atau png.',
        ]);

        $nama_foto = null;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_foto = time() . "_" . $file->getClientOriginalName();
            $file->move(public_path('img'), $nama_foto);
        }

        $input = InputAspirasi::create([
            'nis'         => $nisSiswa,
            'id_kategori' => $request->id_kategori,
            'lokasi'      => $request->lokasi,
            'ket'         => $request->ket,
            'foto'        => $nama_foto,
        ]);

        Aspirasi::create([
            'id_aspirasi' => $input->id_pelaporan,
            'status'      => 'Menunggu',
            'id_kategori' => $request->id_kategori,
            'feedback'    => ''
        ]);

        return back()->with('success', 'Aspirasi berhasil terkirim!');
    }

    // 3. Histori Aspirasi Siswa
    public function histori()
    {
        // 1. Ambil NIS dari session login (HANYA INI YANG JADI PATOKAN)
        $nisLogin = session('nis');

        // 2. Jika session kosong (antisipasi belum login), lempar ke login
        if (!$nisLogin) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 3. Query dikunci hanya untuk NIS yang sedang login
        $aspirasi = InputAspirasi::with(['aspirasi', 'kategori'])
            ->where('nis', $nisLogin) // Kunci di sini!
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.histori', compact('aspirasi'));
    }

    public function balasSiswa(Request $request, $id)
    {
        $request->validate([
            'balasan' => 'required'
        ]);

        $aspirasi = Aspirasi::find($id);

        if ($aspirasi) {
            $aspirasi->update([
                'balasan' => $request->balasan
            ]);
            return back()->with('success', 'Balasan Anda berhasil dikirim!');
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }
}
