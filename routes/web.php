<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- GUEST ROUTES (Bisa diakses tanpa login) ---
Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login-proses', [AuthController::class, 'auth']);
Route::get('/register', [AuthController::class, 'registerPage']);
Route::post('/register-proses', [AuthController::class, 'registerProses']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// --- SISWA ROUTES (Hanya bisa diakses Siswa) ---
Route::middleware(['checkRole:siswa'])->group(function () {
    // Halaman Utama Siswa (Input Form)
    Route::get('/', [AspirasiController::class, 'index'])->name('siswa.index');
    Route::post('/aspirasi/store', [AspirasiController::class, 'store']);

    // Halaman Riwayat/Status
    Route::get('/histori', [AspirasiController::class, 'histori'])->name('siswa.histori');
    Route::post('/aspirasi/balas/{id}', [AspirasiController::class, 'balasSiswa']);
});


// --- ADMIN ROUTES (Hanya bisa diakses Admin) ---
Route::middleware(['checkRole:admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Update Status & Feedback
    Route::post('/admin/update/{id}', [AdminController::class, 'updateStatus']);

    // CRUD Kategori
    Route::get('/admin/kategori', [AdminController::class, 'kategoriIndex']);
    Route::post('/admin/kategori/store', [AdminController::class, 'kategoriStore']);
    Route::post('/admin/kategori/update/{id}', [AdminController::class, 'kategoriUpdate']);
    Route::get('/admin/kategori/delete/{id}', [AdminController::class, 'kategoriDestroy']);
    Route::get('/admin/cetak-laporan', [AdminController::class, 'cetakLaporan'])->name('admin.cetak');
});
