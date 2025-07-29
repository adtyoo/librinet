<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah / Edit Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>{{ isset($buku) ? 'Edit Buku' : 'Tambah Buku Baru' }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ isset($buku) ? route('buku.update', $buku->id) : route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($buku))
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" {{ isset($buku) ? '' : 'required' }}>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Buku</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $buku->nama ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description', $buku->description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="" disabled {{ old('kategori_id', $buku->kategori_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id ?? '') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="genre_id" class="form-label">Genre</label>
                    <select name="genre_id" id="genre_id" class="form-select" required>
                        <option value="" disabled {{ old('genre_id', $buku->genre_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Genre --</option>
                        @foreach ($genres as $genre)
                            <option value="{{ $genre->id }}" {{ old('genre_id', $buku->genre_id ?? '') == $genre->id ? 'selected' : '' }}>
                                {{ $genre->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total" class="form-label">Total Buku</label>
                    <input type="number" name="total" id="total" class="form-control" value="{{ old('total', $buku->total ?? '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stok Tersedia</label>
                    <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $buku->stock ?? '') }}" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
