<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // $totalPeminjaman = Peminjaman::count();
        // $totalPengembalian = Pengembalian::count();
        // $totalPengguna = User::count();
        return view('dashboard');
    }

    public function akunuser()
{
    // $userCount = User::count();
    return view('dashboard');
}
}
