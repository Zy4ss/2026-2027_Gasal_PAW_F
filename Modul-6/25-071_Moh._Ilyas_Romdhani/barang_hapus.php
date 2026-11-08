<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id < 1) {
    header('Location: index.php?jenis=danger&pesan=' . urlencode('Data barang tidak valid.'));
    exit;
}

try {
    // Memeriksa apakah barang sudah dipakai pada transaksi_detail
    $cek = $koneksi->prepare("
        SELECT
            (SELECT nama_barang FROM barang WHERE id = ?) AS nama_barang,
            COUNT(*) AS jumlah
        FROM transaksi_detail
        WHERE barang_id = ?
    ");
    $cek->bind_param('ii', $id, $id);
    $cek->execute();
    $hasil = $cek->get_result()->fetch_assoc();

    if (!$hasil || $hasil['nama_barang'] === null) {
        $jenis = 'danger';
        $pesan = 'Barang tidak ditemukan.';
    } elseif ((int)$hasil['jumlah'] > 0) {
        $jenis = 'danger';
        $pesan = 'Barang "' . $hasil['nama_barang'] . '" tidak dapat dihapus karena masih digunakan pada ' 
            . (int)$hasil['jumlah'] . ' detail transaksi.';
    } else {
        $hapus = $koneksi->prepare("DELETE FROM barang WHERE id = ?");
        $hapus->bind_param('i', $id);
        $hapus->execute();

        if ($hapus->affected_rows > 0) {
            $jenis = 'success';
            $pesan = 'Barang berhasil dihapus.';
        } else {
            $jenis = 'danger';
            $pesan = 'Barang tidak ditemukan.';
        }
    }
} catch (Throwable $e) {
    $jenis = 'danger';

    if ($e instanceof mysqli_sql_exception && $e->getCode() == 1451) {
        $pesan = 'Barang tidak dapat dihapus karena masih digunakan pada transaksi.';
    } else {
        $pesan = $e->getMessage();
    }
}

header('Location: index.php?jenis=' . $jenis . '&pesan=' . urlencode($pesan));
exit;
