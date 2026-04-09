<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false; // Karena NIS biasanya bukan auto-increment
    protected $fillable = ['nis', 'kelas', 'password'];
    public $timestamps = false;
}
