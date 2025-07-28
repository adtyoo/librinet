<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pengembalian - Sarpras Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0; /* hilangkan margin default */
        }
        .sidebar {
            width: 250px;
            height: auto;
            background-color: #2163a5;
            overflow-y: auto;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
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
            margin-left: 250px;
            padding: 20px;
        }
        img {
            width: 100px;
            height: 100px;
            margin: 20px auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        @include('layouts.sidebar', ['active' => 'pengembalian'])
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Pengembalian</span>
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
        <h2>Data Pengembalian Barang</h2>

        <div class="table-responsive">
            <table id="pengembalianTable" class="table table-bordered table-striped nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th><th>Id</th><th>Peminjaman ID</th><th>Pengguna</th><th>Admin</th>
                        <th>Barang</th><th>Jumlah</th><th>Tgl Pinjam</th><th>Tgl Kembali</th>
                        <th>Waktu Kembali</th><th>Kondisi</th><th>Denda</th><th>Status</th><th>Aksi</th>
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
                        <td>
                            @if($pengembalian->waktu_kembali)
                                {{ \Carbon\Carbon::parse($pengembalian->waktu_kembali)->translatedFormat('d M Y H:i') }}
                            @else
                                <span class="text-warning">Belum Dikembalikan</span>
                            @endif
                        </td>
                        @if ($pengembalian->admin_id === null)
                            <td>
                                <form action="{{ route('pengembalian.approve', $pengembalian->id) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="kondisi_barang" class="form-control form-control-sm" required>
                                        <option value="">Kondisi</option>
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Hilang">Hilang</option>
                                    </select>
                            </td>
                            <td>
                                    <input type="number" name="denda" class="form-control form-control-sm" placeholder="Denda (Rp)" required />
                            </td>
                            <td></td>
                            <td>
                                    <button type="submit" class="btn btn-sm btn-primary">Konfirmasi</button>
                                </form>
                            </td>
                        @else
                            <td>{{ ucfirst($pengembalian->kondisi_barang) }}</td>
                            <td>Rp{{ number_format($pengembalian->denda, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($pengembalian->peminjaman->status ?? '-') }}</td>
                            <td><span class="text-success">Terkonfirmasi</span></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function () {
        $('#pengembalianTable').DataTable({
            scrollX: true,
            responsive: true,
            autoWidth: false
        });
    });
    </script>
</body>
</html>
