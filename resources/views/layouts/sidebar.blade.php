<!-- resources/views/layouts/sidebar.blade.php -->
<div class="sidebar">
    <div class="logo-container">
        <img src="https://smktarunabhakti.net/wp-content/uploads/2020/07/logotbvector-copy.png" alt="Logo">
    </div>

    <!-- Menu Utama Section -->
    <div class="sidebar-section">
        <div class="sidebar-header">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>Dashboard
        </a>
        <a href="{{ route('peminjaman.index') }}" class="menu-item {{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
            <i class="fas fa-hand-holding"></i>Data Peminjaman
        </a>
        <a href="{{ route('pengembalian.index') }}" class="menu-item {{ request()->routeIs('pengembalian.index') ? 'active' : '' }}">
            <i class="fas fa-undo-alt"></i>Data Pengembalian
        </a>
    </div>

    <!-- Laporan Section -->
    <div class="sidebar-section">
        <div class="sidebar-header">Laporan</div>
        <a href="{{ route('laporanpeminjaman') }}" class="menu-item {{ request()->routeIs('laporanpeminjaman') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>Laporan Peminjaman
        </a>
        <a href="{{ route('laporanpengembalian') }}" class="menu-item {{ request()->routeIs('laporanpengembalian') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i>Laporan Pengembalian
        </a>
        <a href="{{ route('laporanbuku') }}" class="menu-item {{ request()->routeIs('laporanbuku') ? 'active' : '' }}">
            <i class="fas fa-book"></i>Laporan Buku
        </a>
    </div>

    <!-- Master Data Section -->
    <div class="sidebar-section">
        <div class="sidebar-header">Master Data</div>
        <a href="{{ route('buku.index') }}" class="menu-item {{ request()->routeIs('buku.index') ? 'active' : '' }}">
            <i class="fas fa-book-open"></i>Buku
        </a>
        <a href="{{ route('kategori.index') }}" class="menu-item {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>Kategori
        </a>
        <a href="{{ route('genre.index') }}" class="menu-item {{ request()->routeIs('genre.index') ? 'active' : '' }}">
            <i class="fas fa-music"></i>Genre
        </a>
    </div>

    <!-- Akun Section -->
    <div class="sidebar-section">
        <div class="sidebar-header">Akun</div>
        <a href="{{ route('datauser') }}" class="menu-item {{ request()->routeIs('datauser') ? 'active' : '' }}">
            <i class="fas fa-user-plus"></i>Membuat Akun User
        </a>
    </div>
</div>
