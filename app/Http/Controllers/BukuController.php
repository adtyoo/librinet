<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function buku(Request $request)
    {
        $bukus = Buku::all()->map(function ($buku) {
            $buku->image_url = Storage::url($buku->gambar);
            return $buku;
        });

        return response()->json($bukus);
    }

    // Menampilkan daftar buku
    public function index()
    {
        $bukus = Buku::with(['kategori', 'genre', 'admin'])->get();
        return view('admin.buku.buku', compact('bukus'));
    }

    // Menampilkan form untuk menambah buku
    public function create()
    {
        $kategoris = Kategori::all();
        $genres = Genre::all();
        return view('admin.buku.tambahbuku', compact('kategoris', 'genre'));
    }

    // Menyimpan buku baru
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'description' => 'required',
            'kategori_id' => 'required',
            'genre_id' => 'required',
            'gambar' => 'required|image|max:2048',
        ]);


        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('bukus', 'public');
        }

        $buku = Buku::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'description' => $request->description,
            'kategori_id' => $request->kategori_id,
            'genre_id' => $request->genre_id,
            'gambar' => $gambarPath,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit buku
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategoris = Kategori::all();
        $genres = Genre::all();
        return view('admin.buku.editbuku', compact('buku', 'kategoris', 'genres'));
    }

    // Update buku yang sudah ada
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'description' => 'required',
            'total' => 'required|integer',
            'stock' => 'required|integer',
            'kategori_id' => 'required',
            'genre_id' => 'required',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }
            $buku->gambar = $request->file('gambar')->store('bukus', 'public');
        }

        $buku->update([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'description' => $request->description,
            'total' => $request->total,
            'stock' => $request->stock,
            'kategori_id' => $request->kategori_id,
            'genre_id' => $request->genre_id,
            'gambar' => $buku->gambar,
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    // Menghapus buku
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }

    // API endpoint untuk buku
    public function api_buku()
    {
        $bukus = Buku::with(['kategori', 'genres'])->get();
        return response()->json($bukus);
    }

    // Laporan buku
    public function laporan()
    {
        $bukus = Buku::with(['kategori', 'genres'])->get();
        return view('admin.buku.laporanbuku', compact('bukus'));
    }
}
