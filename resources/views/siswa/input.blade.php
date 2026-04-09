@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7 col-md-9">
        <div class="mb-4 text-center">
            <h3 class="fw-bold"><i class="bi bi-pencil-square text-primary me-2"></i>Form Pengaduan Aspirasi</h3>
            <p class="text-muted">Sampaikan keluhan atau saran Anda untuk kemajuan sekolah kita.</p>
        </div>

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-primary bg-gradient py-3 border-0">
                <div class="d-flex align-items-center justify-content-center text-white">
                    <i class="bi bi-shield-check fs-4 me-2"></i>
                    <h5 class="mb-0 fw-bold">Lengkapi Data Laporan</h5>
                </div>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <div>
                        <strong>Gagal Mengirim!</strong>
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="card-body p-4 p-md-5 bg-white">
                @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="/aspirasi/store" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold text-dark">
                                <i class="bi bi-person-fill me-1"></i> NIS Pelapor
                            </label>
                            <input type="text" class="form-control bg-light border-0 py-3 rounded-3"
                                value="{{ Session::get('nis') }}" disabled readonly
                                style="font-weight: 600; color: #495057;">
                            <small class="text-muted ms-1"><i class="bi bi-info-circle me-1"></i>NIS Anda sudah otomatis terisi oleh sistem.</small>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-dark">
                                <i class="bi bi-bookmark-star-fill me-1 text-primary"></i> Kategori Aspirasi
                            </label>
                            <select name="id_kategori" class="form-select border-1 py-3 rounded-3 shadow-sm" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-bold text-dark">
                                <i class="bi bi-geo-alt-fill me-1 text-primary"></i> Lokasi Kejadian
                            </label>
                            <input type="text" name="lokasi" class="form-control border-1 py-3 rounded-3 shadow-sm"
                                placeholder="Contoh: Lab RPL, Kantin, dll" required>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-bold text-dark">
                                <i class="bi bi-chat-dots-fill me-1 text-primary"></i> Isi Aspirasi / Keluhan
                            </label>
                            <textarea name="ket" class="form-control border-1 rounded-3 shadow-sm" rows="5"
                                placeholder="Jelaskan secara detail kejadian atau saran Anda..." required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Bukti (Opsional)</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                            <small class="text-muted">Format: jpg, jpeg, png. Maks: 2MB</small>
                        </div>

                        <div class="col-md-12">
                            <hr class="my-4 text-muted opacity-25">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg py-3 fw-bold shadow hover-translate">
                                    <i class="bi bi-send-check-fill me-2"></i> Kirim Aspirasi Sekarang
                                </button>
                            </div>
                            <p class="text-center mt-3 mb-0 text-muted small">
                                <i class="bi bi-lock-fill"></i> Data Anda tersimpan aman dalam database sekolah.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Tambahan animasi halus */
    .hover-translate {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .hover-translate:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2) !important;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
    }
</style>
@endsection