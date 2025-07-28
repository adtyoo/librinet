<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Item</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="card mx-auto shadow" style="max-width: 600px;">
        <div class="card-header bg-primary text-white text-center">
            <h4>Tambah Item Baru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('item.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Barang</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="total" class="form-label">Total Barang</label>
                    <input type="number" name="total" id="total" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stok Tersedia</label>
                    <input type="number" name="stock" id="stock" class="form-control" required>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('item.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>