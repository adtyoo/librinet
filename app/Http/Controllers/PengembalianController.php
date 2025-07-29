<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Buku;  // Ganti Item ke Buku
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PengembalianExport;

class PengembalianController extends Controller
{
    // 1. Tampilkan halaman daftar pengembalian milik user (view Blade)
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Hanya tampilkan pengembalian yang sudah dikonfirmasi admin
        $pengembalians = Pengembalian::with(['buku', 'user'])
            ->where('user_id', $user->id)
            ->whereNotNull('waktu_kembali') // pastikan sudah benar-benar dikembalikan
            ->get();

        return view('admin.pengembalian.pengembalian', compact('pengembalians'));
    }

    public function laporan()
    {
        // Ambil semua data peminjaman beserta relasi user, buku, dan admin
        $pengembalians = \App\Models\Pengembalian::with(['user', 'buku', 'admin'])->get();

        return view('laporanpengembalian', compact('pengembalians'));
    }

    // 2. Simpan data pengembalian baru (API JSON)
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        if ($peminjaman->status == 'returned') {
            return response()->json(['message' => 'Buku sudah dikembalikan'], 400);
        }

        $pengembalian = Pengembalian::where('peminjaman_id', $peminjaman->id)->first();

        if (!$pengembalian) {
            return response()->json(['message' => 'Data pengembalian belum dibuat oleh admin.'], 404);
        }

        $pengembalian->waktu_kembali = now();
        $pengembalian->kondisi_barang = $request->input('kondisi_barang', 'Baik');
        $pengembalian->denda = $request->input('denda', 0);
        $pengembalian->save();

        $peminjaman->status = 'returned';
        $peminjaman->save();

        return response()->json(['message' => 'Pengembalian berhasil'], 200);
    }

    // 3. Konfirmasi pengembalian oleh admin
    public function approve(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->admin_id !== null) {
            return redirect()->back()->with('error', 'Data pengembalian ini sudah dikonfirmasi dan tidak bisa diubah.');
        }

        $request->validate([
            'kondisi_barang' => 'required|in:Baik,Rusak,Hilang',
            'denda' => 'required|numeric|min:0',
        ]);

        $pengembalian->kondisi_barang = $request->kondisi_barang;
        $pengembalian->denda = $request->denda;
        $pengembalian->admin_id = Auth::id();
        $pengembalian->save();

        // Update stok buku
        $buku = $pengembalian->peminjaman->buku;  // Ganti item ke buku
        if ($buku) {
            $jumlahKembali = $pengembalian->peminjaman->jumlah ?? 1; // default 1 jika tidak ada
            $buku->stock += $jumlahKembali;
            $buku->save();
        }

        return redirect()->back()->with('success', 'Pengembalian berhasil dikonfirmasi dan stok buku diperbarui.');
    }

    // 4. Ambil data peminjaman yang belum dikembalikan oleh user (API JSON)
    public function belumDikembalikan(Request $request)
    {
        $user = $request->user();

        $peminjaman = Peminjaman::with('buku')  // Ganti item ke buku
            ->where('user_id', $user->id)
            ->where('status', 'Approve')
            ->get();

        return response()->json($peminjaman);
    }
}
