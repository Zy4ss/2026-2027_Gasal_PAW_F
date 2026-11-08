<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$transaksi_id = (int)($_POST['transaksi_id'] ?? 0);
$barang_id = (int)($_POST['barang_id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 0);

$kembali = 'index.php?id=' . $transaksi_id;

if ($transaksi_id < 1 || $barang_id < 1 || $qty < 1) {
    header('Location: index.php?jenis=danger&pesan=' . urlencode('Data detail tidak valid.'));
    exit;
}

$koneksi->begin_transaction();

try {
    // Memastikan transaksi tersedia
    $cekTransaksi = $koneksi->prepare("SELECT id FROM transaksi WHERE id = ?");
    $cekTransaksi->bind_param('i', $transaksi_id);
    $cekTransaksi->execute();

    if (!$cekTransaksi->get_result()->fetch_assoc()) {
        throw new Exception('Transaksi tidak ditemukan.');
    }

    // Mengambil harga barang sekaligus memastikan barang ada
    $cekBarang = $koneksi->prepare("SELECT harga FROM barang WHERE id = ?");
    $cekBarang->bind_param('i', $barang_id);
    $cekBarang->execute();

    $barang = $cekBarang->get_result()->fetch_assoc();

    if (!$barang) {
        throw new Exception('Barang tidak ditemukan.');
    }

    $harga = (int)$barang['harga'];

    // Barang yang sama tidak boleh masuk dua kali pada satu transaksi
    $cekGanda = $koneksi->prepare("
        SELECT 1
        FROM transaksi_detail
        WHERE transaksi_id = ? AND barang_id = ?
    ");
    $cekGanda->bind_param('ii', $transaksi_id, $barang_id);
    $cekGanda->execute();

    if ($cekGanda->get_result()->fetch_assoc()) {
        throw new Exception('Barang tersebut sudah ada pada transaksi ini.');
    }

    $insert = $koneksi->prepare("
        INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
        VALUES (?, ?, ?, ?)
    ");
    $insert->bind_param('iiii', $transaksi_id, $barang_id, $harga, $qty);
    $insert->execute();

    // Menghitung ulang total dari seluruh detail milik transaksi ini
    $update = $koneksi->prepare("
        UPDATE transaksi
        SET total = (
            SELECT COALESCE(SUM(harga * qty), 0)
            FROM transaksi_detail
            WHERE transaksi_id = ?
        )
        WHERE id = ?
    ");
    $update->bind_param('ii', $transaksi_id, $transaksi_id);
    $update->execute();

    $koneksi->commit();

    $jenis = 'success';
    $pesan = 'Detail berhasil disimpan. Total transaksi sudah diperbarui.';
} catch (Throwable $e) {
    $koneksi->rollback();

    $jenis = 'danger';

    if ($e instanceof mysqli_sql_exception && $e->getCode() == 1062) {
        $pesan = 'Barang tersebut sudah ada pada transaksi ini.';
    } else {
        $pesan = $e->getMessage();
    }
}

header('Location: ' . $kembali . '&jenis=' . $jenis . '&pesan=' . urlencode($pesan));
exit;
