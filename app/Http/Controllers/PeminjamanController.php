<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    // semua data peminjaman
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku', 'pengembalian'])->get();

        if (request()->wantsJson()) {
            $data = $peminjamans->map(function ($peminjaman) {
                $pengembalian = $peminjaman->pengembalian;

                return [
                    'id' => $peminjaman->id,
                    'user_id' => $peminjaman->user_id,
                    'buku_id' => $peminjaman->buku_id,
                    'status' => $peminjaman->status,
                    'tanggal_peminjaman' => $peminjaman->tanggal_peminjaman,
                    'tanggal_pengembalian' => $peminjaman->tanggal_pengembalian,
                    'keterangan' => $peminjaman->keterangan,
                    'jumlah' => $peminjaman->jumlah,
                    'user' => $peminjaman->user,
                    'buku' => $peminjaman->buku,
                    'kondisi_barang' => $pengembalian ? $pengembalian->kondisi_barang : null,
                    'denda' => $pengembalian ? $pengembalian->denda : null,
                    'pengembalian' => $pengembalian,
                ];
            });

            return response()->json($data);
        }

        return view('admin.peminjaman.peminjaman', compact('peminjamans'));
    }

    public function laporan()
    {
        $peminjamans = \App\Models\Peminjaman::with(['user', 'buku', 'admin'])->get();

        return view('laporanpeminjaman', compact('peminjamans'));
    }

    // pengajuan peminjaman baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'tanggal_peminjaman' => 'required|date',
            'keterangan' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi.'
            ], 401);
        }

        $buku = \App\Models\Buku::find($validated['buku_id']);
        $jumlah = $validated['jumlah'];

        if ($buku->stock < $jumlah) {
            return response()->json([
                'success' => false,
                'message' => "Stok buku tidak mencukupi. Sisa stok: {$buku->stock}"
            ], 400);
        }

        try {
            $buku->stock -= $jumlah;
            $buku->save();

            $peminjaman = Peminjaman::create([
                'user_id' => $user->id,
                'buku_id' => $validated['buku_id'],
                'jumlah' => $jumlah,
                'tanggal_peminjaman' => $validated['tanggal_peminjaman'],
                'keterangan' => $validated['keterangan'] ?? null,
                'status' => 'pending',
                'tanggal_pengembalian' => null,
                'admin_id' => null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil diajukan, menunggu persetujuan admin.',
                'data' => $peminjaman
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function storeBatch(Request $request)
    {
        $request->validate([
            'peminjaman' => 'required|array',
            'peminjaman.*.buku_id' => 'required|exists:bukus,id',
            'peminjaman.*.tanggal_peminjaman' => 'required|date',
            'peminjaman.*.jumlah' => 'required|integer|min:1',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak terautentikasi.'
            ], 401);
        }

        foreach ($request->peminjaman as $data) {
            $buku = \App\Models\Buku::find($data['buku_id']);
            $jumlah = $data['jumlah'];

            if ($buku->stock < $jumlah) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok buku dengan ID {$buku->id} tidak mencukupi. Sisa stok: {$buku->stock}"
                ], 400);
            }
        }

        foreach ($request->peminjaman as $data) {
            $buku = \App\Models\Buku::find($data['buku_id']);
            $jumlah = $data['jumlah'];

            $buku->stock -= $jumlah;
            $buku->save();

            Peminjaman::create([
                'user_id' => $user->id,
                'buku_id' => $data['buku_id'],
                'tanggal_peminjaman' => $data['tanggal_peminjaman'],
                'jumlah' => $jumlah,
                'status' => 'pending',
                'tanggal_pengembalian' => null,
                'admin_id' => null,
                'keterangan' => $data['keterangan'] ?? null,
            ]);
        }

        return response()->json(['message' => 'Berhasil mengajukan semua peminjaman'], 201);
    }

    // Update status dan tanggal pengembalian
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($request->status === 'Approve') {
            $request->validate([
                'tanggal_pengembalian' => 'required|date',
            ]);

            $peminjaman->status = 'Approve';
            $peminjaman->tanggal_pengembalian = $request->tanggal_pengembalian;
            $peminjaman->admin_id = Auth::id();
            $peminjaman->save();

            Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'user_id' => $peminjaman->user_id,
                'buku_id' => $peminjaman->buku_id,
                'tanggal_peminjaman' => $peminjaman->tanggal_peminjaman,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'waktu_kembali' => null,
                'jumlah' => $peminjaman->jumlah,
                'denda' => 0,
            ]);

            return back()->with('success', 'Peminjaman disetujui dan dicatat di pengembalian.');
        }

        if ($request->status === 'Reject') {
            $peminjaman->status = 'Reject';
            $peminjaman->save();

            return back()->with('success', 'Peminjaman ditolak.');
        }

        return back()->with('error', 'Status tidak valid.');
    }

    // Setujui peminjaman dan buat entri pengembalian
    public function approve(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'Approve';
        $peminjaman->save();

        // Catat pengembalian
        \App\Models\Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => $peminjaman->user_id,
            'buku_id' => $peminjaman->buku_id,
            'tanggal_peminjaman' => $peminjaman->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'waktu_kembali' => null,
            'denda' => 0,
        ]);

        return redirect()->back()->with('success', 'Peminjaman disetujui dan pengembalian dicatat.');
    }

    // Tolak peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Peminjaman sudah diproses.');
        }

        $peminjaman->status = 'Reject';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    // Riwayat peminjaman untuk user login
    public function histori(Request $request)
    {
        $user = $request->user();
        $peminjaman = Peminjaman::where('user_id', $user->id)->with('buku')->get();

        return response()->json($peminjaman);
    }

    // Tandai buku sudah diambil oleh user
    public function markAsBorrowed($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Approve') {
            return redirect()->back()->with('error', 'Hanya peminjaman yang sudah disetujui yang bisa diambil.');
        }

        $peminjaman->status = 'Dipinjam';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Status peminjaman diubah menjadi Dipinjam.');
    }

    public function kembalikan($request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'Dipinjam') {
            return response()->json(['message' => 'Buku sudah dikembalikan.'], 400);
        }

        $peminjaman->status = 'Dikembalikan';
        $peminjaman->tanggal_pengembalian = $request->tanggal_pengembalian;
        $peminjaman->save();

        return response()->json(['message' => 'Pengembalian berhasil'], 200);
    }

    public function belumDikembalikan(Request $request)
    {
        $user = $request->user();

        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', $user->id)
            ->whereNull('tanggal_pengembalian')
            ->get();

        return response()->json($peminjaman);
    }
}
