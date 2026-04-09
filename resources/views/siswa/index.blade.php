@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-dark">Suarakan Aspirasimu</h2>
            <p class="text-muted">Laporan Anda membantu kami membangun lingkungan sekolah yang lebih baik.</p>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4 p-md-5">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="/aspirasi/store" method="POST">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-person-badge me-1"></i> Identitas Pelapor
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="bi bi-hash text-primary"></i>
                                </span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0" 
                                    value="{{ Session::get('nis') }}" readonly disabled>
                            </div>
                            <div class="form-text small">NIS terdeteksi otomatis oleh sistem.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-tag me-1"></i> Kategori Laporan
                            </label>
                            <select name="id_kategori" class="form-select border-1 rounded-3" required>
                                <option value="" selected disabled>Pilih kategori...</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-geo-alt me-1"></i> Lokasi Kejadian
                            </label>
                            <input type="text" name="lokasi" class="form-control rounded-3" 
                                placeholder="Misal: Kantin Lt. 2, Lapangan Basket, atau Ruang Kelas 12 RPL" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">
                                <i class="bi bi-chat-left-text me-1"></i> Detail Aspirasi
                            </label>
                            <textarea name="ket" class="form-control rounded-3" rows="5" 
                                placeholder="Jelaskan secara detail apa yang ingin Anda sampaikan..." required></textarea>
                        </div>

                        <div class="col-12 pt-2">
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-send-fill me-2"></i> Kirim Laporan Sekarang
                            </button>
                            <p class="text-center text-muted mt-3 small">
                                <i class="bi bi-shield-lock me-1"></i> Laporan Anda akan diproses secara rahasia.
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection