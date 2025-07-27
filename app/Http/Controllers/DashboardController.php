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
        $totalPeminjaman = Peminjaman::count();
        $totalPengembalian = Pengembalian::count();
        $totalPengguna = User::count();


        $logs = DB::table('logs')
                  ->orderBy('logged_at', 'desc')
                  ->get();

        return view('dashboard', compact(
            'totalPeminjaman',
            'totalPengembalian',
            'totalPengguna',
            'logs'
        ));
    }

    public function akunuser()
{
    $userCount = User::count();
    return view('dashboard', compact('userCount'));
}
}
