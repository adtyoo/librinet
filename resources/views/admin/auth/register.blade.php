<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

<div class="card shadow p-4" style="width: 100%; max-width: 500px;">
    <h3 class="text-center mb-4">Buat Akun Baru</h3>

    <form action="{{ route('register.submit') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Akun</label>
            <input type="text" class="form-control" id="name" name="name"required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Tambah</button>
        <a href="{{ route('datauser') }}" class="btn btn-secondary">Batal</a>
    </form>
    </form>
</div>

</body>
</html>
