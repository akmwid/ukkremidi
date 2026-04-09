<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('input_aspirasi', function (Blueprint $table) {
            $table->id('id_pelaporan');
            $table->string('nis');                     // Relasi ke siswa
            $table->integer('id_kategori');             // Relasi ke kategori
            $table->string('lokasi', 50);               // varchar(50)
            $table->string('ket', 50);   // varchar(50)
            $table->string('foto')->nullable();
            $table->timestamps();                
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_aspirasi');
    }
};
