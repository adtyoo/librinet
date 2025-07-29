<?php

use App\Models\Kategori;
use App\Exports\ItemExport;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\GenreController;

//user
// Route::post('/loginuser', [UserController::class, 'login'])->name('login');

Route::get('/', function () {return view('admin.auth.login');})->name('get.login');
Route::post('/login', [AdminController::class, 'login'])->name('login.process');

Route::middleware('auth:admin')->group(function () {
//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/datauser', [UserController::class, 'datauser'])->name('datauser');
Route::get('/register', [UserController::class, 'show'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

//kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/tambahkategori', [KategoriController::class, 'show'])->name('tambahkategori');
Route::post('/tambahkategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');

//Genre
Route::resource('genre', GenreController::class);

// buku
// Route untuk menampilkan daftar buku
Route::get('/bukus', [BukuController::class, 'index'])->name('buku.index');

// Route untuk menampilkan form tambah buku
Route::get('/bukus/create', [BukuController::class, 'create'])->name('tambahbuku');

// Route untuk menyimpan buku baru
Route::post('/bukus', [BukuController::class, 'store'])->name('buku.store');

// Route untuk menampilkan form edit buku
Route::get('/bukus/{id}/edit', [BukuController::class, 'edit'])->name('buku.edit');

// Route untuk mengupdate buku
Route::put('/bukus/{id}', [BukuController::class, 'update'])->name('buku.update');

// Route untuk menghapus buku
Route::delete('/bukus/{id}', [BukuController::class, 'destroy'])->name('buku.destroy');

// laporan buku
Route::get('/peminjaman/buku', [BukuController::class, 'laporan'])->name('laporanbuku');

//admin
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

//peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::put('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
Route::put('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');

//laporan item
// Route::get('/peminjaman/item', [ItemController::class, 'laporan'])->name('laporanitem');

// Route::get('/laporan-item/export', function () {
//     return Excel::download(new ItemExport, 'laporan_item.xlsx');
// })->name('laporanitem.export');

//laporan peminjaman
Route::get('/peminjaman/laporan', [PeminjamanController::class, 'laporan'])->name('laporanpeminjaman');

// Route::get('/laporan-peminjaman/export', function () {
//     return Excel::download(new PeminjamanExport, 'laporan_peminjaman.xlsx');
// })->name('laporanpeminjaman.export');


//laporan pengembalian
Route::get('/pengembalian/laporan', [PengembalianController::class, 'laporan'])->name('laporanpengembalian');

// Route::get('/laporan-pengembalian/export', function () {
//     return Excel::download(new PengembalianExport, 'laporan_pengembalian.xlsx');
// })->name('laporanpengembalian.export');

Route::patch('/pengembalian/{id}/approve', [PengembalianController::class, 'approve'])->name('pengembalian.approve');
Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::post('/pengembalian/{id}/kembalikan', [PengembalianController::class, 'store'])->name('pengembalian.store');
Route::post('/pengembalian/{id}/ambil', [PengembalianController::class, 'markAsBorrowed'])->name('pengembalian.ambil');
Route::delete('/pengembalian/{id}', [PengembalianController::class, 'destroy'])->name('pengembalian.destroy');
Route::put('/peminjaman/{id}/kembalikan', [PengembalianController::class, 'kembalikan'])->name('peminjaman.kembalikan');
Route::patch('/pengembalian/{id}/status', [PengembalianController::class, 'updateStatus'])->name('pengembalian.updateStatus');


});
// Route::post('/logout', function () {
//     Auth::logout();
//     return redirect('/');
// })->name('logout');
