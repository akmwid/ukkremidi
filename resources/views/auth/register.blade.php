@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-success">GABUNG SEKARANG</h2>
                <p class="text-muted text-sm">Daftarkan diri Anda untuk mulai menyampaikan aspirasi</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4">Buat Akun Siswa</h4>

                    @if(session('error'))
                    <div class="alert alert-danger border-0 small shadow-sm mb-4">
                        {{ session('error') }}
                    </div>
                    @endif

                    <form action="/register-proses" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Nomor Induk Siswa (NIS)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-card-list text-success"></i></span>
                                <input type="number" name="nis" class="form-control bg-light border-0 py-2" placeholder="Masukkan NIS Anda" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Kelas</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-mortarboard text-success"></i></span>
                                <input type="text" name="kelas" class="form-control bg-light border-0 py-2" placeholder="Contoh: XII RPL 1" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-mortarboard text-success"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Contoh: Password" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">
                            Daftar Sekarang <i class="bi bi-person-plus-fill ms-1"></i>
                        </button>
                    </form>

                    <div class="text-center mt-2">
                        <span class="small text-muted">Sudah punya akun?</span>
                        <a href="/login" class="small text-decoration-none fw-bold ms-1 text-success">Masuk di sini</a>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted small mt-4">
                Layanan Aspirasi Siswa Digital &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection