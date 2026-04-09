@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-md-5 col-lg-4">
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">E-ASPIRASI</h2>
                <p class="text-muted">Suarakan aspirasimu untuk sekolah yang lebih baik</p>
            </div>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4">Portal Masuk</h4>

                    @if(session('error'))
                    <div class="alert alert-danger border-0 small shadow-sm mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </div>
                    @endif

                    <form action="/login-proses" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary">Username / NIS</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person text-primary"></i></span>
                                <input type="text" name="user_input" id="userInput" class="form-control bg-light border-0 py-2" placeholder="Masukkan NIS atau Username" required>
                            </div>
                            <div class="form-text" style="font-size: 0.75rem;">
                                *Siswa silakan masukkan NIS.
                            </div>
                        </div>

                        <div class="mb-4" id="passwordField">
                            <label class="form-label small fw-bold text-secondary">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-lock text-primary"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Masukkan Password Anda">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm mb-3">
                            Masuk ke Sistem <i class="bi bi-arrow-right-short"></i>
                        </button>
                    </form>

                    <div class="text-center mt-2">
                        <span class="small text-muted">Belum punya akun?</span>
                        <a href="/register" class="small text-decoration-none fw-bold ms-1 text-primary">Daftar Sekarang</a>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted small mt-4">
                &copy; {{ date('Y') }} E-Aspirasi Digital School
            </p>
        </div>
    </div>
</div>

<script>
    const userInput = document.getElementById('userInput');
    const passwordField = document.getElementById('passwordField');

    // Opsional: Jika ingin otomatis menyembunyikan password saat input terlihat seperti NIS (angka)
    userInput.addEventListener('input', function() {
        if (!isNaN(this.value) && this.value.length > 0) {
            // Jika input adalah angka (NIS), kita bisa beri petunjuk visual
            this.classList.add('border-primary');
        } else {
            this.classList.remove('border-primary');
        }
    });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endsection