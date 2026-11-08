<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = new mysqli('localhost', 'root', '', 'db_penjualan');
} catch (mysqli_sql_exception $e) {
    die('Koneksi database gagal: ' . htmlspecialchars($e->getMessage()));
}

$koneksi->set_charset('utf8mb4');
