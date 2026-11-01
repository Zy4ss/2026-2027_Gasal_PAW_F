<?php
session_start();
require 'koneksi.php';

$status = $_GET['status'] ?? '';
$alasan = $_GET['alasan'] ?? '';

$pesan = null;
if ($status === 'gagal') {
    if ($alasan === 'dipakai') {
        $teks = 'Supplier tidak dapat dihapus karena masih dipakai oleh data barang.';
    } elseif ($alasan === 'error') {
        $teks = 'Terjadi kesalahan saat menghapus data.';
    } else {
        $teks = 'Data supplier tidak ditemukan.';
    }
    $pesan = ['jenis' => 'gagal', 'teks' => $teks];
}

$hasil = $koneksi->query('SELECT id, nama, telp, alamat FROM supplier ORDER BY id ASC');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Data Master Supplier</h1>
        <a href="tambah.php" class="btn btn-hijau">Tambah Data</a>
    </div>

    <?php if ($pesan): ?>
        <div class="alert alert-<?= e($pesan['jenis']) ?>"><?= e($pesan['teks']) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th style="width:170px">Tindakan</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while ($row = $hasil->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= e($row['nama']) ?></td>
                <td><?= e($row['telp']) ?></td>
                <td><?= e($row['alamat']) ?></td>
                <td>
                    <a href="edit.php?id=<?= (int) $row['id'] ?>" class="btn btn-oranye btn-kecil">Edit</a>
                    <form action="hapus.php" method="post" class="form-inline"
                          onsubmit="return confirm('Anda yakin akan menghapus supplier ini?');">
                        <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
                        <button type="submit" class="btn btn-merah btn-kecil">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        <?php if ($no === 1): ?>
            <tr><td colspan="5" class="kosong">Belum ada data supplier.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
