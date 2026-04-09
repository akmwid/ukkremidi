<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InputAspirasi extends Model
{
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    public $incrementing = true;
    protected $fillable = ['nis', 'id_kategori', 'lokasi', 'ket','foto'];

    // INI RELASI YANG HILANG
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    // Relasi ke tabel aspirasi (untuk status & feedback)
    public function aspirasi()
    {
        return $this->hasOne(Aspirasi::class, 'id_aspirasi', 'id_pelaporan');
    }

    // Relasi ke tabel siswa (biar admin tahu nama/kelas siswanya)
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'nis', 'nis');
    }
}
