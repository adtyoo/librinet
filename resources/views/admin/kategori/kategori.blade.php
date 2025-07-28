<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Kategori - Sarpras Sekolah</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
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

        </style>
    </head>
<body>

<div class="d-flex">
    @include('sidebar', ['active' => 'kategori'])

    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Halaman Kategori</span>
                <div class="d-flex align-items-center">
                    <span class="me-3">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Keluar</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="content">
            <h2>Halaman Kategori</h2>
            <a href="{{ route('tambahkategori') }}" class="btn btn-primary mb-3">Tambah Kategori</a>

            <table id="usersTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id</th>
                        <th>Admin</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategoris as $index => $kategori)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $kategori->id }}</td>
                            <td>{{ $kategori->admin->name ?? '-' }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>
                                <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" class="d-inline form-delete-kategori" data-nama="{{ $kategori->nama }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada kategori.</td>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    $('#usersTable').DataTable();

    $('.btn-delete').click(function(e){
        e.preventDefault();
        const form = $(this).closest('form');
        const kategoriNama = form.data('nama') || 'kategori ini';

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: `Anda akan menghapus ${kategoriNama}. Tindakan ini tidak bisa dibatalkan!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
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
