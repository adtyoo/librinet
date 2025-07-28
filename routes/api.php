<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthApiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;


Route::post('/register', [UserController::class, 'register']);
// Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/user', [UserController::class, 'user']);


Route::middleware('auth:api')->get('/dashboard', function (Request $request) {
    return response()->json(['message' => 'Welcome to the Dashboard']);
});

Route::get('/item', [ItemController::class, 'api_item']);

Route::middleware('auth:sanctum')->group(function () {
    // User bisa ajukan dan lihat peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::put('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::post('/peminjaman/batch', [PeminjamanController::class, 'storeBatch']);


    // Admin approval
    Route::post('/peminjaman/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{id}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');

// File: routes/api.php
    Route::post('/pengembalian', [PengembalianController::class, 'store']);
    Route::patch('/pengembalian/{id}', [PengembalianController::class, 'update']);
    Route::get('/pengembalian/belum-dikembalikan', [PengembalianController::class, 'belumDikembalikan']);
    Route::post('/pengembalian/{id}', [PeminjamanController::class, 'kembalikan']);
});