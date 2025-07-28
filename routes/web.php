<?php

use App\Models\Kategori;
use App\Exports\ItemExport;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

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

//item
// Route untuk menampilkan daftar item
Route::get('/items', [ItemController::class, 'index'])->name('item.index');

// Route untuk menampilkan form tambah item
Route::get('/items/create', [ItemController::class, 'create'])->name('tambahitem');

// Route untuk menyimpan item baru
Route::post('/items', [ItemController::class, 'store'])->name('item.store');

// Route untuk menampilkan form edit item
Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('item.edit');

// Route untuk mengupdate item
Route::put('/items/{id}', [ItemController::class, 'update'])->name('item.update');

// Route untuk menghapus item
Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('item.destroy');

//admin
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

//peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::put('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
Route::put('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
Route::put('/peminjaman/{id}', [PeminjamanController::class, 'update'])->name('peminjaman.update');

//laporan item
Route::get('/peminjaman/item', [ItemController::class, 'laporan'])->name('laporanitem');

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
