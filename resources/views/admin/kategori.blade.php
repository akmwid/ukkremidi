@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h3 class="fw-bold text-dark mb-0">Manajemen Kategori</h3>
            <p class="text-muted small mb-0">Kelola kategori aspirasi untuk memudahkan pengelompokan laporan.</p>
        </div>
        <div class="col-auto">
            <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase small fw-bold text-secondary" style="width: 100px;">No</th>
                            <th class="py-3 text-uppercase small fw-bold text-secondary">Keterangan Kategori</th>
                            <th class="py-3 text-uppercase small fw-bold text-secondary text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $k)
                        <tr>
                            <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-2 p-2 me-3">
                                        <i class="bi bi-tag-fill"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">{{ $k->ket_kategori }}</span>
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="/admin/kategori/delete/{{ $k->id_kategori }}" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('Hapus kategori ini?')">
                                    <i class="bi bi-trash3 me-1"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/admin/kategori/store" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold text-dark">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Nama Kategori</label>
                    <input type="text" name="ket_kategori" class="form-control form-control-lg border-1 rounded-3" placeholder="Misal: Sarana & Prasarana" required>
                </div>
            </div>
            <div class="modal-footer border-top-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<style>
    .table thead th {
        font-size: 0.7rem;
        letter-spacing: 0.08em;
    }

    .btn-outline-warning:hover {
        color: #fff;
    }

    .modal-content {
        overflow: hidden;
    }

    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
</style>
@endsection