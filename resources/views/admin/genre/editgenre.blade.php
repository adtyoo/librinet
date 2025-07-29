<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Genre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 500px;">
    <h3 class="text-center mb-4">Edit Genre</h3>

    <form action="{{ route('genre.update', $genre->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Genre</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $genre->nama) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('genre.index') }}" class="btn btn-secondary">Batal</a>
    </form>

</div>

</body>
</html>
