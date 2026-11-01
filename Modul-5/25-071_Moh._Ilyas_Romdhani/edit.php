<?php
session_start();
require 'koneksi.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);

$stmt = $koneksi->prepare('SELECT id, nama, telp, alamat FROM supplier WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$supplier = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$supplier) {
    header('Location: index.php?status=gagal&aksi=edit');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama'] ?? '');
    $telp   = trim($_POST['telp'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');

    // tampilkan kembali isian terakhir jika ada error
    $supplier['nama'] = $nama;
    $supplier['telp'] = $telp;
    $supplier['alamat'] = $alamat;

    if ($nama === '') {
        $error = 'Nama supplier wajib diisi.';
    } elseif (mb_strlen($telp) > 12) {
        $error = 'Nomor telepon maksimal 12 karakter.';
    } else {
        $stmt = $koneksi->prepare('UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?');
        $stmt->bind_param('sssi', $nama, $telp, $alamat, $id);
        $stmt->execute();
        $stmt->close();

        header('Location: index.php?status=sukses&aksi=edit');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="header"><h1>Edit Data Master Supplier</h1></div>

    <?php if ($error): ?>
        <div class="alert alert-gagal"><?= e($error) ?></div>
    <?php endif; ?>

    <form method="post" class="form-data">
        <input type="hidden" name="id" value="<?= (int) $supplier['id'] ?>">
        <div class="baris">
            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" class="lebar" value="<?= e($supplier['nama']) ?>" required>
        </div>
        <div class="baris">
            <label for="telp">Telp</label>
            <input type="text" id="telp" name="telp" class="sedang" maxlength="12" value="<?= e($supplier['telp']) ?>">
        </div>
        <div class="baris">
            <label for="alamat">Alamat</label>
            <input type="text" id="alamat" name="alamat" class="sedang" value="<?= e($supplier['alamat']) ?>">
        </div>
        <div class="baris tombol">
            <button type="submit" class="btn btn-hijau">Update</button>
            <a href="index.php" class="btn btn-merah">Batal</a>
        </div>
    </form>
</div>
</body>
</html>
