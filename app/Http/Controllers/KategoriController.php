<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::with(['admin'])->get();
        return view('admin.kategori.kategori', compact('kategoris'));
    }

    public function show ()
    {
        return view ('admin.kategori.tambahkategori');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $kategoris = Kategori::create([
            'nama' => $request->nama,
            'admin_id' => Auth::id()
        ]);

        DB::statement("ALTER TABLE kategoris AUTO_INCREMENT = " . (DB::table('kategoris')->max('id') + 1));

        return redirect('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('admin.kategori.editkategori', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->nama = $request->nama;
        $kategori->save();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        DB::statement("ALTER TABLE kategoris AUTO_INCREMENT = " . (DB::table('kategoris')->max('id') + 1));
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}


