<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Beranda - Sarpras Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
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
        html {
            font-size: 14px;
        }
        .card h2 {
            font-size: 1.5rem;
        }
        .card h5 {
            font-size: 0.9rem;
        }
        .card i {
            font-size: 1.5rem;
        }
        .navbar .navbar-brand {
            font-size: 1.25rem;
        }
        .table th, .table td {
            font-size: 0.85rem;
            padding: 0.4rem;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
                <div class="container-fluid">
                    <span class="navbar-brand mb-0 h1">Beranda</span>
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
                <h2>Selamat Datang di Librinet</h2>
                <p>Silakan pilih menu di sebelah kiri untuk mulai menggunakan sistem.</p>
            </div>
        </div>
    </div>
</body>
</html>
