<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laporan Pengembalian - Sarpras Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background-color: #2163a5;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar a {
            color: #fff;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #2b5885;
            border-left: 3px solid #fff;
        }
        .sidebar-section {
            margin: 20px 0;
        }
        .sidebar-header {
            color: #b8d4f0;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            padding: 15px 20px 5px 20px;
            margin-bottom: 5px;
            border-bottom: 1px solid #4a7bb7;
        }
        .sidebar a.menu-item {
            padding-left: 25px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }
        .sidebar a.menu-item i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
            margin-left: 250px; /* supaya konten tidak di bawah sidebar */
        }
        img {
            width: 100px;
            height: 100px;
            margin: 20px auto;
            display: block;
        }
        .logo-container {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #4a7bb7;
            margin-bottom: 10px;
        }

        /* Navbar styling supaya tidak mengambang dan lebar sesuai konten */
        nav.navbar {
            margin-bottom: 15px;
            width: calc(100vw - 250px);
            margin-left: 250px;
            background-color: #f8f9fa;
            box-sizing: border-box;
            padding-left: 1rem;
            padding-right: 1rem;
            border-bottom: 1px solid #dee2e6;
            position: relative;
            z-index: 999;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        @include('sidebar', ['active' => 'laporanpengembalian'])
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Laporan Pengembalian Barang</span>
            <div class="d-flex">
                <span class="me-3">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</span>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="content">
        <h2>Laporan Pengembalian Barang</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('laporanpengembalian.export') }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Download Excel
            </a>
        </div>

        <div class="table-responsive">
            <table id="tabelLaporan" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Pmj ID</th>
                        <th>Pengguna</th>
                        <th>Admin</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Waktu Kembali</th>
                        <th>Kondisi</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengembalians as $index => $pengembalian)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ 'PMB' . str_pad($pengembalian->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ 'PMJ' . str_pad($pengembalian->peminjaman->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>{{ $pengembalian->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $pengembalian->admin->name ?? '-' }}</td>
                            <td>{{ $pengembalian->item->nama ?? 'Item telah dihapus' }}</td>
                            <td>{{ $pengembalian->jumlah }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengembalian->peminjaman->tanggal_peminjaman)->translatedFormat('d M Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->translatedFormat('d M Y H:i') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pengembalian->waktu_kembali)->translatedFormat('d M Y H:i') }}</td>
                            <td>{{ ucfirst($pengembalian->kondisi_barang) }}</td>
                            <td>Rp{{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#tabelLaporan').DataTable({
            scrollX: true
        });
    });
</script>

</body>
</html>
