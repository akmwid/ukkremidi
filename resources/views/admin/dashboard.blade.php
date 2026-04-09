@extends('layouts.app')

@section('content')
<div class="container py-4">
    {{-- Header & Statistik Singkat --}}
    <div class="row align-items-center mb-4">
        <div class="col">
            <h2 class="fw-bold text-dark m-0">Dashboard Admin</h2>
            <p class="text-muted small">Kelola dan tanggapi aspirasi siswa dengan cepat.</p>
        </div>

        <div class="col-auto">
            <div class="bg-primary bg-opacity-10 text-primary px-4 py-2 rounded-4 border border-primary border-opacity-25 shadow-sm">
                <small class="d-block fw-bold text-uppercase" style="font-size: 0.7rem;">Total Laporan</small>
                <span class="h4 fw-bold m-0">{{ $data->count() }}</span>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <div>{{ session('success') }}</div>
    </div>
    @endif

    {{-- Bagian Filter Modern --}}
    <div class="card mb-4 border-0 shadow-sm rounded-4">
        <div class="card-body p-4">
            <form action="/admin/dashboard" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-tag text-muted"></i></span>
                        <select name="id_kategori" class="form-select border-0 bg-light">
                            <option value="">Semua Kategori</option>
                            @foreach($kategori as $k)
                            <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                {{ $k->ket_kategori }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted text-uppercase tracking-wider">Tanggal Lapor</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event text-muted"></i></span>
                        <input type="date" name="tanggal" class="form-control border-0 bg-light" value="{{ request('tanggal') }}">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-3 shadow-sm">
                        <i class="bi bi-filter me-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Data --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-uppercase small fw-bold text-muted">ID</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Siswa</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Waktu Kirim</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Laporan</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted">Status</th>
                            <th class="py-3 border-0 text-uppercase small fw-bold text-muted text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td class="ps-4 fw-bold text-primary">#{{ $row->id_pelaporan }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $row->siswa->kelas ?? 'Kelas Tidak Diketahui' }}</div>
                                <div class="text-muted" style="font-size: 0.8rem;"><i class="bi bi-person me-1"></i>{{ $row->nis }}</div>
                            </td>
                            <td>
                                <div class="text-dark fw-medium small">{{ $row->created_at->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>
                                <span class="badge bg-white text-primary border border-primary border-opacity-25 mb-1">{{ $row->kategori->ket_kategori ?? 'Umum' }}</span>
                                <p class="mb-0 text-dark small text-truncate" style="max-width: 250px;">{{ $row->ket }}</p>
                            </td>
                            <td>
                                @php
                                $status = $row->aspirasi?->status ?? 'Menunggu';
                                $config = [
                                'Menunggu' => ['color' => 'secondary', 'icon' => 'bi-clock'],
                                'Proses' => ['color' => 'warning', 'icon' => 'bi-gear'],
                                'Selesai' => ['color' => 'success', 'icon' => 'bi-check2-all']
                                ];
                                $current = $config[$status] ?? $config['Menunggu'];
                                @endphp
                                <span class="badge rounded-pill bg-{{ $current['color'] }} bg-opacity-10 text-{{ $current['color'] }} border border-{{ $current['color'] }} border-opacity-25 px-3 py-2">
                                    <i class="bi {{ $current['icon'] }} me-1"></i> {{ $status }}
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-white border shadow-sm px-3 rounded-3 fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $row->id_pelaporan }}">
                                    <i class="bi bi-pencil-square me-1"></i> Kelola
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DILETAKKAN DI LUAR CONTAINER TABEL --}}
@foreach($data as $row)
<div class="modal fade" id="modalEdit{{ $row->id_pelaporan }}" tabindex="-1" aria-labelledby="modalLabel{{ $row->id_pelaporan }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="/admin/update/{{ $row->id_pelaporan }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-0 bg-light p-4">
                <div class="d-flex flex-column">
                    <h5 class="modal-title fw-bold text-dark" id="modalLabel{{ $row->id_pelaporan }}">
                        Detail Aspirasi <span class="text-primary">#{{ $row->id_pelaporan }}</span>
                    </h5>
                    <small class="text-muted">Dari: {{ $row->siswa->kelas ?? 'Siswa' }} ({{ $row->nis }})</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
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

                {{-- Bagian Info Laporan --}}
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Lokasi</label>
                        <div class="p-3 bg-light rounded-3 fw-bold small"><i class="bi bi-geo-alt me-1 text-primary"></i>{{ $row->lokasi }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Kategori</label>
                        <div class="p-3 bg-light rounded-3 fw-bold small"><i class="bi bi-tag me-1 text-primary"></i>{{ $row->kategori->ket_kategori }}</div>
                    </div>
                    <div class="col-12">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Isi Laporan</label>
                        <div class="p-3 bg-light rounded-3 small border-start border-primary border-3" style="white-space: pre-line;">{{ $row->ket }}</div>
                    </div>
                </div>

                <hr class="my-4 opacity-50">

                {{-- Bagian Aksi Admin --}}
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-arrow-repeat me-1 text-primary"></i> Status Progres</label>
                        <select name="status" class="form-select border-0 bg-light py-2 shadow-sm">
                            <option value="Menunggu" {{ ($row->aspirasi?->status == 'Menunggu') ? 'selected' : '' }}>Menunggu</option>
                            <option value="Proses" {{ ($row->aspirasi?->status == 'Proses') ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ ($row->aspirasi?->status == 'Selesai') ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-chat-left-dots me-1 text-primary"></i> Tanggapan (Feedback) Anda</label>
                        <textarea name="feedback" class="form-control border-0 bg-light p-3 shadow-sm" rows="3" placeholder="Tuliskan instruksi atau balasan untuk siswa..." required>{{ $row->aspirasi?->feedback }}</textarea>
                    </div>
                </div>

                {{-- BAGIAN BARU: Menampilkan Balasan dari Siswa --}}
                <div class="pt-3 border-top">
                    @if($row->aspirasi?->balasan)
                    <label class="small text-muted fw-bold text-uppercase d-block mb-2">
                        <i class="bi bi-reply-all-fill text-info"></i> Balasan / Konfirmasi Siswa:
                    </label>
                    <div class="p-3 border-start border-info border-4 bg-info bg-opacity-10 rounded-3 text-dark shadow-sm">
                        <i class="bi bi-quote opacity-50 text-info fs-4"></i>
                        <span class="fst-italic">{{ $row->aspirasi->balasan }}</span>
                    </div>
                    @else
                    <div class="text-center p-2">
                        <span class="badge bg-light text-muted fw-normal italic px-3 py-2 border w-100">
                            <i class="bi bi-clock-history me-1"></i> Belum ada balasan dari siswa
                        </span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer border-0 p-4 pt-0">
                <button type="button" class="btn btn-light fw-bold px-4 rounded-3" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3 shadow">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach
<style>
    .tracking-wider {
        letter-spacing: 0.05em;
    }

    .btn-white:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.02);
    }

    /* Pastikan modal muncul di atas segalanya */
    .modal {
        z-index: 1060 !important;
    }

    .modal-backdrop {
        z-index: 1050 !important;
    }
</style>
@endsection