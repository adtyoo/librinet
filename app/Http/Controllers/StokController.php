<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Buku; // ubah import Item ke Buku
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StokController extends Controller
{
    public function index()
    {
        $stoks = Stok::with(['buku', 'kategori', 'admin'])->get();
        return view('stok.index', compact('stoks'));
    }

    public function create()
    {
        $bukus = Buku::all(); // ubah item ke buku
        $kategoris = Kategori::all();
        return view('stok.create', compact('bukus', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id', // ubah item_id ke buku_id dan tabel ke bukus
            'kategori_id' => 'required|exists:kategoris,id',
            'stok_total' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0|lte:stok_total',
        ]);

        Stok::create([
            'buku_id' => $request->buku_id,
            'kategori_id' => $request->kategori_id,
            'stok_total' => $request->stok_total,
            'stok_tersedia' => $request->stok_tersedia,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stok = Stok::findOrFail($id);
        $bukus = Buku::all();
        $kategoris = Kategori::all();
        return view('stok.edit', compact('stok', 'bukus', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
            'kategori_id' => 'required|exists:kategoris,id',
            'stok_total' => 'required|integer|min:0',
            'stok_tersedia' => 'required|integer|min:0|lte:stok_total',
        ]);

        $stok = Stok::findOrFail($id);
        $stok->update([
            'buku_id' => $request->buku_id,
            'kategori_id' => $request->kategori_id,
            'stok_total' => $request->stok_total,
            'stok_tersedia' => $request->stok_tersedia,
        ]);

        return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $stok = Stok::findOrFail($id);
        $stok->delete();

        return redirect()->route('stok.index')->with('success', 'Stok berhasil dihapus.');
    }
}
