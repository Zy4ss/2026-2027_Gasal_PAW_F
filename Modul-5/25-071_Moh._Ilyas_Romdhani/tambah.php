<?php
session_start();
require 'koneksi.php';

$error = '';
$nama = $telp = $alamat = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    if ($nama === '') {
        $error = 'Nama supplier wajib diisi.';
    } elseif (mb_strlen($telp) > 12) {
        $error = 'Nomor telepon maksimal 12 karakter.';
    } else {
        $stmt = $koneksi->prepare('INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $nama, $telp, $alamat);
        $stmt->execute();
        $stmt->close();

        header('Location: index.php?status=sukses&aksi=tambah');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Data Master Supplier Baru</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="header"><h1>Tambah Data Master Supplier Baru</h1></div>

    <?php if ($error): ?>
        <div class="alert alert-gagal"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="form-data">
        <div class="baris">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="lebar" placeholder="Nama" value="<?= e($nama) ?>" required>
        </div>
        <div class="baris">
            <label for="telp">Telp</label>
            <input type="text" id="telp" name="telp" class="sedang" placeholder="telp" maxlength="12" value="<?= e($telp) ?>">
        </div>
        <div class="baris">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="sedang" placeholder="alamat" value="<?= e($alamat) ?>">
        </div>
        <div class="baris tombol">
            <button type="submit" class="btn btn-hijau">Simpan</button>
            <a href="index.php" class="btn btn-merah">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
