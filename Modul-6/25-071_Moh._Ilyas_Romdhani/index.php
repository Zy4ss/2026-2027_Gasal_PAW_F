<?php
require 'koneksi.php';

function e($nilai)
{
    return htmlspecialchars((string)$nilai, ENT_QUOTES, 'UTF-8');
}

function rupiah($angka)
{
    return 'Rp ' . number_format((int)$angka, 0, ',', '.');
}

// Daftar transaksi (master)
$transaksi = $koneksi->query("
    SELECT t.*, p.nama AS nama_pelanggan
    FROM transaksi t
    JOIN pelanggan p ON p.id = t.pelanggan_id
    ORDER BY t.id ASC
")->fetch_all(MYSQLI_ASSOC);

// Menentukan transaksi yang dipilih
$pilih = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$master = null;

foreach ($transaksi as $row) {
    if ((int)$row['id'] === $pilih) {
        $master = $row;
        break;
    }
}

if ($master === null && count($transaksi) > 0) {
    $master = $transaksi[0];
    $pilih = (int)$master['id'];
}

// Detail transaksi terpilih
$detail = [];

if ($master) {
    $stmt = $koneksi->prepare("
        SELECT d.barang_id, d.harga, d.qty, b.kode_barang, b.nama_barang
        FROM transaksi_detail d
        JOIN barang b ON b.id = d.barang_id
        WHERE d.transaksi_id = ?
        ORDER BY b.nama_barang
    ");
    $stmt->bind_param('i', $pilih);
    $stmt->execute();
    $detail = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Daftar barang untuk dropdown dan tabel barang
$barang = $koneksi->query("
    SELECT id, kode_barang, nama_barang, harga, stok
    FROM barang
    ORDER BY nama_barang
")->fetch_all(MYSQLI_ASSOC);

// Barang yang sudah ada pada transaksi terpilih
$dipakai = [];

foreach ($detail as $d) {
    $dipakai[(int)$d['barang_id']] = true;
}

$pesan = isset($_GET['pesan']) && is_string($_GET['pesan']) ? $_GET['pesan'] : null;
$jenis = isset($_GET['jenis']) && is_string($_GET['jenis']) ? $_GET['jenis'] : 'success';

if (!in_array($jenis, ['success', 'danger', 'warning'], true)) {
    $jenis = 'success';
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container py-4">

        <div class="mb-4">
            <h1>Data Transaksi</h1>
            <p class="text-muted mb-0">Halaman master-detail transaksi penjualan.</p>
        </div>

        <?php if ($pesan !== null): ?>
            <div class="alert alert-<?= e($jenis) ?>" role="alert">
                <?= e($pesan) ?>
            </div>
        <?php endif; ?>

        <div class="row">

            <div class="col-lg-7 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Tabel Transaksi</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Pelanggan</th>
                                    <th class="text-end">Total</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transaksi as $t): ?>
                                    <tr class="<?= ((int)$t['id'] === $pilih) ? 'table-active' : '' ?>">
                                        <td><?= (int)$t['id'] ?></td>
                                        <td><?= e($t['waktu_transaksi']) ?></td>
                                        <td><?= e($t['nama_pelanggan']) ?></td>
                                        <td class="text-end"><?= rupiah($t['total']) ?></td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-primary" href="?id=<?= (int)$t['id'] ?>">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (count($transaksi) === 0): ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            Belum ada data transaksi.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <?= $master ? 'Detail Transaksi #' . (int)$master['id'] : 'Detail Transaksi' ?>
                        </h2>
                    </div>

                    <div class="card-body">
                        <?php if ($master): ?>

                            <table class="table table-sm table-bordered mb-3">
                                <tbody>
                                    <tr>
                                        <th>Pelanggan</th>
                                        <td><?= e($master['nama_pelanggan']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td><?= e($master['waktu_transaksi']) ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th class="text-end">Harga</th>
                                            <th class="text-end">Qty</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($detail as $d): ?>
                                            <tr>
                                                <td><?= e($d['kode_barang'] . ' - ' . $d['nama_barang']) ?></td>
                                                <td class="text-end"><?= rupiah($d['harga']) ?></td>
                                                <td class="text-end"><?= (int)$d['qty'] ?></td>
                                                <td class="text-end"><?= rupiah((int)$d['harga'] * (int)$d['qty']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <?php if (count($detail) === 0): ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    Belum ada detail barang.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" class="text-end">Total</th>
                                            <th class="text-end"><?= rupiah($master['total']) ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <hr>

                            <h3 class="form-title">Tambah Detail</h3>

                            <form action="detail_tambah.php" method="post">
                                <input type="hidden" name="transaksi_id" value="<?= (int)$master['id'] ?>">

                                <div class="mb-3">
                                    <label for="barang_id" class="form-label">Barang</label>
                                    <select id="barang_id" name="barang_id" class="form-select" required>
                                        <option value="">-- Pilih Barang --</option>

                                        <?php foreach ($barang as $b): ?>
                                            <?php $sudahAda = isset($dipakai[(int)$b['id']]); ?>
                                            <option value="<?= (int)$b['id'] ?>" <?= $sudahAda ? 'disabled' : '' ?>>
                                                <?= e(
                                                    $b['kode_barang'] . ' - ' . $b['nama_barang'] .
                                                    ' (' . rupiah($b['harga']) . ')' .
                                                    ($sudahAda ? ' - sudah ditambahkan' : '')
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="qty" class="form-label">Qty</label>
                                    <input type="number" id="qty" name="qty" class="form-control" min="1" value="1"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    Simpan Detail
                                </button>
                            </form>

                        <?php else: ?>
                            <p class="text-muted mb-0">Belum ada data transaksi.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Tabel Barang</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Stok</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($barang as $b): ?>
                            <tr>
                                <td><?= e($b['kode_barang']) ?></td>
                                <td><?= e($b['nama_barang']) ?></td>
                                <td class="text-end"><?= rupiah($b['harga']) ?></td>
                                <td class="text-end"><?= (int)$b['stok'] ?></td>
                                <td class="text-end">
                                    <form action="barang_hapus.php" method="post" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                        <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <?php if (count($barang) === 0): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Belum ada data barang.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>
