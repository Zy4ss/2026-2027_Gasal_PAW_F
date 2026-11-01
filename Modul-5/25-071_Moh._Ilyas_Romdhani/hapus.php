<?php
session_start();
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);

try {
    $stmt = $koneksi->prepare('DELETE FROM supplier WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $terhapus = $stmt->affected_rows;
    $stmt->close();

    if ($terhapus > 0) {
        header('Location: index.php?status=sukses&aksi=hapus');
    } else {
        header('Location: index.php?status=gagal&aksi=hapus');
    }
    exit;
} catch (mysqli_sql_exception $e) {
    // Error 1451: supplier masih dipakai oleh tabel barang (foreign key)
    if ((int) $e->getCode() === 1451) {
        header('Location: index.php?status=gagal&aksi=hapus&alasan=dipakai');
    } else {
        header('Location: index.php?status=gagal&aksi=hapus&alasan=error');
    }
    exit;
}
