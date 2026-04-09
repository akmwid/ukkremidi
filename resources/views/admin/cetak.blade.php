<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Aspirasi - {{ date('d-m-Y') }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            /* Lebih formal untuk laporan resmi */
            padding: 20px;
            color: #000;
            background-color: #fff;
            line-height: 1.4;
        }

        /* Kop Surat */
        .kop-surat {
            border-bottom: 4px solid #000;
            padding-bottom: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .kop-surat .text {
            text-align: center;
        }

        .kop-surat h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
        }

        .kop-surat h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .kop-surat p {
            margin: 5px 0 0 0;
            font-size: 12px;
            font-style: italic;
        }

        .judul-laporan {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-laporan h3 {
            text-decoration: underline;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        /* Tabel Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            /* Sedikit lebih kecil agar muat banyak data */
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px 6px;
        }

        th {
            background-color: #e9e9e9 !important;
            /* Warna abu halus untuk header */
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .fw-bold {
            font-weight: bold;
        }

        /* Tanda Tangan */
        .ttd-container {
            margin-top: 40px;
            width: 100%;
        }

        .ttd-table {
            width: 100%;
            border: none;
        }

        .ttd-table td {
            border: none;
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        /* Tombol Aksi */
        .no-print {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .btn-print {
            background: #28a745;
            color: white;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }

            @page {
                size: landscape;
                margin: 1.5cm;
            }

            /* Memastikan warna latar belakang tabel muncul saat diprint */
            th {
                background-color: #e9e9e9 !important;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <div>
            <button onclick="window.print()" class="btn btn-print">🖨️ Cetak Laporan (PDF)</button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-back">⬅️ Kembali</a>
        </div>
        <div style="font-family: Arial; font-size: 12px; color: #666;">
            Tips: Gunakan kertas <strong>A4</strong> dengan orientasi <strong>Landscape</strong>.
        </div>
    </div>

    <div class="kop-surat">
        <div class="text">
            <h2>PEMERINTAH PROVINSI JAWA TIMUR</h2>
            <h1>DINAS PENDIDIKAN SMK NEGERI 11 MALANG</h1>
            <p>Jl. Pelabuhan Bakahuni No. 1 Malang 65148 Telp. 0341-836330 Fax. 0341-837271 </p>
        </div>
    </div>

    <div class="judul-laporan">
        <h3>REKAPITULASI PENGADUAN ASPIRASI SISWA</h3>
        <span>Periode: {{ date('Y') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">NO</th>
                <th style="width: 80px;">TANGGAL</th>
                <th style="width: 100px;">NIS</th>
                <th style="width: 100px;">KATEGORI</th>
                <th style="width: 100px;">LOKASI</th>
                <th>ISI ASPIRASI</th>
                <th style="width: 80px;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $key => $row)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td class="text-center">{{ $row->created_at->format('d/m/Y') }}</td>
                <td class="text-center">{{ $row->nis }}</td>
                <td class="text-center">{{ $row->kategori->ket_kategori }}</td>
                <td>{{ $row->lokasi }}</td>
                <td>{{ $row->ket }}</td>
                <td class="text-center fw-bold">{{ strtoupper($row->aspirasi->status ?? 'Menunggu') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Data aspirasi tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td>
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah</p>
                    <br><br><br><br>
                    <p><strong>( ____________________ )</strong><br>NIP. ..............................</p>
                </td>
                <td>
                    <p>Malang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    <p>Petugas Administrator,</p>
                    <br><br><br><br>

                    {{-- Ini akan mengambil nama admin yang kamu input di Seeder tadi --}}
                    <p><strong>( {{ $admin->nama ?? 'Administrator' }} )</strong></p>

                    <p>NIP. ..............................</p>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>