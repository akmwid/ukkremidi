@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary text-white rounded-3 p-2 me-3 shadow-sm">
            <i class="bi bi-clock-history fs-4"></i>
        </div>
        <div>
            <h2 class="fw-bold mb-0 text-dark">Histori Aspirasi Saya</h2>
            <p class="text-muted mb-0">Pantau perkembangan laporan dan berikan tanggapan balik.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-secondary small fw-bold">ID LAPORAN</th>
                            <th class="py-3 text-secondary small fw-bold">KATEGORI</th>
                            <th class="py-3 text-secondary small fw-bold">RINGKASAN</th>
                            <th class="py-3 text-secondary small fw-bold text-center">STATUS</th>
                            <th class="text-center py-3 text-secondary small fw-bold pe-4">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aspirasi as $row)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold text-dark">#{{ $row->id_pelaporan }}</span>
                                <div class="text-muted small" style="font-size: 0.7rem;">
                                    {{ $row->created_at->format('d M Y') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 px-3 py-2">
                                    <i class="bi bi-tag me-1"></i>{{ $row->kategori->ket_kategori }}
                                </span>
                            </td>
                            <td>
                                <p class="mb-0 text-truncate text-dark" style="max-width: 250px;" title="{{ $row->ket }}">
                                    {{ $row->ket }}
                                </p>
                            </td>
                            <td class="text-center">
                                @php
                                $status = $row->aspirasi?->status ?? 'Menunggu';
                                $color = $status == 'Selesai' ? 'success' : ($status == 'Proses' ? 'warning' : 'secondary');
                                $icon = $status == 'Selesai' ? 'check-circle' : ($status == 'Proses' ? 'clock-history' : 'hourglass');
                                @endphp
                                <span class="badge rounded-pill bg-{{ $color }} bg-opacity-10 text-{{ $color }} border border-{{ $color }} border-opacity-25 px-3 py-2">
                                    <i class="bi bi-{{ $icon }} me-1"></i> {{ $status }}
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <button class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm fw-bold btn-hover-effect" data-bs-toggle="modal" data-bs-target="#detailModal{{ $row->id_pelaporan }}">
                                    Buka Detail
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Detail & Balas --}}
                        <div class="modal fade" id="detailModal{{ $row->id_pelaporan }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-0 bg-primary text-white p-4">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-info-circle me-2"></i>Rincian Laporan #{{ $row->id_pelaporan }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-4 bg-light">
                                        <div class="row g-4">
                                            {{-- Foto Bukti (Sekarang di dalam modal-body agar ada padding) --}}
                                            <div class="mb-4 text-center bg-light p-3 rounded-4 border border-dashed">
                                                <label class="small text-muted text-uppercase fw-bold d-block mb-2">Lampiran Foto Bukti</label>
                                                @if($row->foto)
                                                <a href="{{ asset('img/' . $row->foto) }}" target="_blank" class="d-inline-block shadow-sm rounded-3 overflow-hidden border">
                                                    <img src="{{ asset('img/' . $row->foto) }}" class="img-fluid" style="max-height: 250px; object-fit: contain;" alt="Bukti">
                                                </a>
                                                <p class="small text-muted mt-2 mb-0"><i class="bi bi-zoom-in me-1"></i> Klik gambar untuk memperbesar</p>
                                                @else
                                                <div class="py-3">
                                                    <i class="bi bi-image text-muted fs-2 d-block mb-1"></i>
                                                    <span class="small text-muted italic">Tidak ada foto bukti yang diunggah</span>
                                                </div>
                                                @endif
                                            </div>
                                            {{-- Laporan Asli --}}
                                            <div class="col-md-6">
                                                <div class="card border-0 rounded-3 shadow-sm h-100">
                                                    <div class="card-body">
                                                        <label class="small text-primary fw-bold mb-2 text-uppercase">Isi Laporan Anda</label>
                                                        <p class="text-dark mb-0 lh-base">{{ $row->ket }}</p>
                                                        <hr class="text-muted opacity-25">
                                                        <div class="small text-muted">
                                                            <i class="bi bi-geo-alt me-1"></i>{{ $row->lokasi }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Feedback Admin --}}
                                            <div class="col-md-6">
                                                <div class="card border-0 rounded-3 shadow-sm h-100 bg-white">
                                                    <div class="card-body">
                                                        <label class="small text-success fw-bold mb-2 text-uppercase">Tanggapan Admin</label>
                                                        @if($row->aspirasi && $row->aspirasi->feedback)
                                                        <p class="text-dark mb-0 lh-base">{{ $row->aspirasi->feedback }}</p>
                                                        @else
                                                        <p class="text-muted fst-italic mb-0">Laporan Anda sedang diproses. Mohon tunggu tanggapan admin.</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Form Balasan Siswa --}}
                                            @if($row->aspirasi)
                                            <div class="col-12 mt-4">
                                                <div class="bg-white p-4 rounded-3 shadow-sm border-top border-primary border-4">
                                                    <form action="/aspirasi/balas/{{ $row->aspirasi->id_aspirasi }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold text-dark"><i class="bi bi-reply-all me-1"></i> Berikan Balasan/Konfirmasi Kembali:</label>
                                                            <textarea name="balasan" class="form-control border-1 rounded-3" rows="3" placeholder="Tulis balasan di sini..." required>{{ $row->aspirasi->balasan }}</textarea>
                                                        </div>
                                                        <div class="d-flex justify-content-end">
                                                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow-sm">
                                                                <i class="bi bi-send me-1"></i> Simpan Balasan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada aspirasi yang dikirim.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-hover-effect {
        transition: all 0.3s;
    }

    .btn-hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3) !important;
    }

    .modal-header {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
</style>
@endsection