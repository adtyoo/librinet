<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
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

        .sidebar a.active {
            background-color: #2b5885;
            border-left: 3px solid #fff;
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
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    @include('layouts.sidebar', ['active' => 'item'])

    <!-- Main content -->
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Halaman Item</span>
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
            <h4>Halaman Item</h4>
            <a href="{{ route('tambahitem') }}" class="btn btn-primary mb-3">Tambah Item</a>

            <table id="itemsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Gambar</th>
                        <th>Admin</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Total</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->id }}</td>
                            <td>
                                <img src="{{ $item->image_url }}" class="item-thumbnail img-thumbnail" alt="{{ $item->nama }}">
                            </td>
                            <td>{{ $item->admin->name ?? '-' }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategori->nama ?? '-' }}</td>
                            <td>{{ $item->total }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>
                                <a href="{{ route('item.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>

                                <!-- Form hapus disembunyikan, submit pakai JS -->
                                <form id="delete-form-{{ $item->id }}" action="{{ route('item.destroy', $item->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button class="btn btn-sm btn-danger btn-delete-item" data-item-id="{{ $item->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada data item.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Bootstrap & jQuery & DataTables -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        $('#itemsTable').DataTable();

        $('.btn-delete-item').click(function(e) {
            e.preventDefault();
            const itemId = $(this).data('item-id');
            const itemName = $(this).closest('tr').find('td:nth-child(5)').text() || 'item ini';

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: `Anda akan menghapus ${itemName}. Tindakan ini tidak bisa dibatalkan!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + itemId).submit();
                }
            });
        });

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            timer: 2500,
            showConfirmButton: false,
            timerProgressBar: true,
        });
        @endif
    });
</script>

</body>
</html>
