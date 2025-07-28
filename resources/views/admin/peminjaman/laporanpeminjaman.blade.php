<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Laporan Peminjaman - Sarpras Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #2163a5;
            overflow-y: auto;
        }
        .sidebar a {
            color: #fff;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .sidebar a:hover {
            background-color: #2b5885;
            border-left: 3px solid #fff;
            color: #fff;
        }
        .sidebar-section {
            margin: 20px 0;
        }
        .sidebar-header {
            color: #b8d4f0;
            font-size: 0.85rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
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
        .sidebar a.active {
            background-color: #2b5885;
            border-left: 3px solid #fff;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    @include('sidebar', ['active' => 'laporanpeminjaman'])

    <!-- Main content -->
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Halaman Laporan Peminjaman</span>
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
            <h2>Laporan Peminjaman</h2>

            <div class="mb-3">
                <a href="{{ route('laporanpeminjaman.export') }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Download Excel
                </a>
            </div>


            <table id="laporanTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Nama Barang</th>
                        <th>Jumlah Barang</th>
                        <th>Admin</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjamans as $index => $peminjaman)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $peminjaman->user->name ?? 'Tidak diketahui' }}</td>
                            <td>{{ $peminjaman->item->nama ?? 'Tidak diketahui' }}</td>
                            <td>{{ $peminjaman->jumlah ?? '-' }}</td>
                            <td>{{ $peminjaman->admin->name ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d-m-Y H:i') }}</td>
                            <td>{{ $peminjaman->tanggal_pengembalian ? \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d-m-Y H:i') : '-' }}</td>
                            <td>{{ $peminjaman->keterangan ?? '-' }}</td>
                            <td>
                                @php
                                    $status = strtolower($peminjaman->status);
                                    $badgeClass = 'bg-secondary';
                                    if ($status === 'approve' || $status === 'approved') {
                                        $badgeClass = 'bg-success';
                                    } elseif ($status === 'reject' || $status === 'rejected') {
                                        $badgeClass = 'bg-danger';
                                    } elseif ($status === 'dipinjam') {
                                        $badgeClass = 'bg-primary';
                                    } elseif ($status === 'pending') {
                                        $badgeClass = 'bg-warning text-dark';
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#laporanTable').DataTable({
            order: [[5, 'desc']]  // Urutkan berdasarkan tanggal peminjaman terbaru
        });
    });
</script>

</body>
</html>
