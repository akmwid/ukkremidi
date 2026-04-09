<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menghapus data admin lama agar tidak double saat di-run ulang
        DB::table('admin')->truncate();

        // Memasukkan data admin hardcode sesuai tabel di gambar
        DB::table('admin')->insert([
            'nama' => 'Pak imam',
            'username' => 'admin_sekolah',
            'password' => Hash::make('admin123'), // Ini password hardcode-nya
        ]);
    }
}