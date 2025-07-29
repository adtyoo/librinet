<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Kategori;
use App\Models\Genre; // ✅ Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function item(Request $request)
    {
        $items = Item::all()->map(function ($item) {
            $item->image_url = Storage::url($item->gambar);
            return $item;
        });

        return response()->json($items);
    }

    // Menampilkan daftar item
    public function index()
    {
        $items = Item::with(['kategori', 'genre', 'admin'])->get();
        return view('admin.item.item', compact('items'));
    }

    // Menampilkan form untuk menambah item
    public function create()
    {
        $kategoris = Kategori::all();
        $genres = Genre::all();
        return view('admin.item.tambahitem', compact('kategoris', 'genres'));
    }

    // Menyimpan item baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'description' => 'required',
            'total' => 'required',
            'stock' => 'required',
            'kategori_id' => 'required',
            'genre_id' => 'required',
            'gambar' => 'required',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('items', 'public');
        }

        Item::create([
            'nama' => $request->nama,
            'description' => $request->description,
            'total' => $request->total,
            'stock' => $request->stock,
            'kategori_id' => $request->kategori_id,
            'genre_id' => $request->genre_id,
            'gambar' => $gambarPath,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('item.index')->with('success', 'Item berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit item
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $kategoris = Kategori::all();
        $genres = Genre::all();
        return view('admin.item.edititem', compact('item', 'kategoris', 'genres'));
    }

    // update item yang sudah ada
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'description' => 'required',
            'total' => 'required',
            'stock' => 'required',
            'kategori_id' => 'required',
            'genre_id' => 'required', 
            'gambar' => 'nullable',
        ]);

        if ($request->hasFile('gambar')) {
            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }
            $item->gambar = $request->file('gambar')->store('items', 'public');
        }

        $item->update([
            'nama' => $request->nama,
            'description' => $request->description,
            'total' => $request->total,
            'stock' => $request->stock,
            'kategori_id' => $request->kategori_id,
            'genre_id' => $request->genre_id, // ✅
            'gambar' => $item->gambar,
        ]);

        return redirect()->route('item.index')->with('success', 'Item berhasil diperbarui.');
    }

    // Menghapus item
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('item.index')->with('success', 'Item berhasil dihapus.');
    }

    public function api_item()
    {
        $items = Item::with(['kategori', 'genre'])->get(); // ✅
        return response()->json($items);
    }

    public function laporan()
    {
        $items = Item::with(['kategori', 'genre'])->get(); // ✅
        return view('admin.item.laporanitem', compact('items'));
    }
}
