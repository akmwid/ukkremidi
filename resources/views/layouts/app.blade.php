<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Aspirasi | Sistem Aspirasi Sekolah</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            letter-spacing: -0.01em;
        }

        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color) !important;
            font-size: 1.4rem;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-muted);
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: rgba(13, 110, 253, 0.05);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background: rgba(13, 110, 253, 0.1);
        }

        /* Content & Footer */
        .main-content {
            min-height: calc(100vh - 180px);
            padding: 2.5rem 0;
        }

        .footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding: 2rem 0;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        .user-profile-nav {
            padding: 4px 12px;
            background: #f1f5f9;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="bi bi-megaphone-fill me-2"></i>E-ASPIRASI
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    @if(Session::has('nis'))
                    {{-- MENU KHUSUS SISWA --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">
                            <i class="bi bi-plus-square me-1"></i> Kirim Laporan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('histori') ? 'active' : '' }}" href="/histori">
                            <i class="bi bi-journal-text me-1"></i> Histori Saya
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <div class="user-profile-nav text-primary">
                            <i class="bi bi-person-circle"></i> {{ Session::get('nis') }}
                        </div>
                    </li>

                    @elseif(Session::get('role') == 'admin')
                    {{-- MENU KHUSUS ADMIN --}}
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('admin/kategori') ? 'active' : '' }}" href="/admin/kategori">
                            <i class="bi bi-tags me-1"></i> Kelola Kategori
                        </a>
                    </li>

                    {{-- TOMBOL CETAK LANGSUNG DI NAVBAR --}}
                    <li class="nav-item">
                        <a class="nav-link text-success" href="/admin/cetak-laporan" target="_blank">
                            <i class="bi bi-printer-fill me-1"></i> Cetak Laporan
                        </a>
                    </li>

                    <li class="nav-item ms-lg-2">
                        <div class="user-profile-nav text-dark">
                            <i class="bi bi-shield-check"></i> Administrator
                        </div>
                    </li>
                    @endif

                    {{-- TOMBOL LOGOUT (Muncul jika sudah login sebagai siapapun) --}}
                    @if(Session::has('nis') || (Session::get('role') == 'admin'))
                    <li class="nav-item ms-lg-3">
                        <a href="/logout" class="btn btn-danger btn-sm rounded-pill px-4 shadow-sm fw-bold"
                            onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                            <i class="bi bi-box-arrow-right me-1"></i> Keluar
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer text-center">
        <div class="container">
            <p class="mb-1 fw-bold text-dark">Sistem Informasi Aspirasi Sekolah</p>
            <p class="mb-0">&copy; 2026 SMK Negeri 11 Malang. Built with XII RPL 1/04 for Better Education.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>