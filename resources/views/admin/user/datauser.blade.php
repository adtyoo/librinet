<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Akun Pengguna - Sarpras Sekolah</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />

    <style>
        /* Font dan body */
        body {
            font-family: Arial, sans-serif;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            background-color: #2163a5;
            overflow-y: auto;
            min-width: 220px;
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
            border-bottom: 1px solid #4a7bb7;
            margin-bottom: 5px;
        }

        .menu-item {
            padding-left: 25px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .menu-item i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }

        /* Konten utama */
        .content {
            padding: 20px;
        }

        /* Logo di sidebar */
        .logo-container {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #4a7bb7;
            margin-bottom: 10px;
        }

        .logo-container img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar dipanggil dari layout terpisah -->
    @include('sidebar', ['active' => 'akun'])

    <!-- Main content -->
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Halaman Akun Pengguna</span>
                <div class="d-flex">
                    <span class="me-3">Halo, {{ Auth::user()->name ?? 'Pengguna' }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt me-1"></i>Keluar
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="content">
            <h4>Halaman Akun Pengguna</h4>
            <a href="{{ route('register') }}" class="btn btn-primary mb-3">Tambah Pengguna</a>

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
                    @forelse ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->admin->name ?? '-' }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <button class="btn btn-sm btn-danger btn-delete" data-user-id="{{ $user->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada akun pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        $('#usersTable').DataTable();

        // Event click tombol hapus dengan SweetAlert2
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            const userId = $(this).data('user-id');

            Swal.fire({
                title: 'Yakin ingin menghapus akun ini?',
                text: "Data yang sudah dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + userId).submit();
                }
            });
        });

        // Notifikasi sukses hapus
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false,
            timerProgressBar: true
        });
        @endif

        // Notifikasi error (jika ada)
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            timer: 2500,
            showConfirmButton: false,
            timerProgressBar: true
        });
        @endif
    });
</script>

</body>
</html>
