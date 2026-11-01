CREATE DATABASE IF NOT EXISTS penjualan
  CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE penjualan;

DROP TABLE IF EXISTS pembayaran;
DROP TABLE IF EXISTS transaksi_detail;
DROP TABLE IF EXISTS transaksi;
DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS supplier;
DROP TABLE IF EXISTS pelanggan;
DROP TABLE IF EXISTS user;


CREATE TABLE pelanggan (
  id            VARCHAR(20)  NOT NULL,
  nama          VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp          VARCHAR(12)  DEFAULT NULL,
  alamat        TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE supplier (
  id     INT(11)      NOT NULL AUTO_INCREMENT,
  nama   VARCHAR(100) NOT NULL,
  telp   VARCHAR(12)  DEFAULT NULL,
  alamat TEXT,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE barang (
  id          INT(11)      NOT NULL AUTO_INCREMENT,
  kode_barang VARCHAR(10)  NOT NULL,
  nama_barang VARCHAR(100) NOT NULL,
  harga       INT(11)      NOT NULL,
  stok        INT(11)      NOT NULL DEFAULT 0,
  supplier_id INT(11)      NOT NULL,
  PRIMARY KEY (id),
  KEY fk_barang_supplier (supplier_id),
  CONSTRAINT fk_barang_supplier FOREIGN KEY (supplier_id)
    REFERENCES supplier (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE user (
  id_user  TINYINT(2)   NOT NULL AUTO_INCREMENT,
  username VARCHAR(30)  NOT NULL,
  password VARCHAR(35)  NOT NULL,   -- disimpan sebagai hash MD5 (32 karakter)
  nama     VARCHAR(50)  NOT NULL,
  alamat   VARCHAR(150) DEFAULT NULL,
  hp       VARCHAR(20)  DEFAULT NULL,
  level    TINYINT(1)   NOT NULL DEFAULT 2,  -- 1 = admin, 2 = kasir
  PRIMARY KEY (id_user)
) ENGINE=InnoDB;


CREATE TABLE transaksi (
  id              INT(11)     NOT NULL AUTO_INCREMENT,
  waktu_transaksi DATE        NOT NULL,
  keterangan      TEXT,
  total           INT(11)     NOT NULL DEFAULT 0,
  pelanggan_id    VARCHAR(20) NOT NULL,
  PRIMARY KEY (id),
  KEY fk_transaksi_pelanggan (pelanggan_id),
  CONSTRAINT fk_transaksi_pelanggan FOREIGN KEY (pelanggan_id)
    REFERENCES pelanggan (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
  transaksi_id INT(11) NOT NULL,
  barang_id    INT(11) NOT NULL,
  harga        INT(11) NOT NULL,
  qty          INT(11) NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  KEY fk_detail_barang (barang_id),
  CONSTRAINT fk_detail_transaksi FOREIGN KEY (transaksi_id)
    REFERENCES transaksi (id) ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_detail_barang FOREIGN KEY (barang_id)
    REFERENCES barang (id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
  id           INT(11)  NOT NULL AUTO_INCREMENT,
  waktu_bayar  DATETIME NOT NULL,
  total        INT(11)  NOT NULL,
  metode       ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT(11)  NOT NULL,
  PRIMARY KEY (id),
  KEY fk_pembayaran_transaksi (transaksi_id),
  CONSTRAINT fk_pembayaran_transaksi FOREIGN KEY (transaksi_id)
    REFERENCES transaksi (id) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;


INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1,  'PT. Maju Bersama',      '08123456',    'Surabaya'),
(2,  'PT. Senang Sekali',     '081515563',   'Bangkalan'),
(3,  'PT. Segar Segar',       '0845454663',  'Surabaya'),
(4,  'CV. Aroma Nusantara',   '081234567801','Malang'),
(5,  'PT. Indo Pangan',       '031555010',   'Sidoarjo'),
(6,  'CV. Susu Sehat',        '081330012345','Pasuruan'),
(7,  'PT. Bersih Selalu',     '031777020',   'Gresik'),
(8,  'UD. Tani Makmur',       '085712345678','Mojokerto'),
(9,  'CV. Sumber Rejeki',     '082134567890','Jombang'),
(10, 'PT. Cahaya Abadi',      '031888030',   'Surabaya');

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1,  'BRG001', 'Beras Premium 5kg',   68000,  50, 1),
(2,  'BRG002', 'Minyak Goreng 2L',    38000,  40, 2),
(3,  'BRG003', 'Gula Pasir 1kg',      17000,  60, 1),
(4,  'BRG004', 'Telur Ayam 1kg',      29000,  30, 3),
(5,  'BRG005', 'Kopi Bubuk 200g',     22000,  45, 4),
(6,  'BRG006', 'Teh Celup 25s',        9000,  80, 4),
(7,  'BRG007', 'Mie Instan Goreng',    3500, 200, 5),
(8,  'BRG008', 'Susu UHT 1L',         19000,  35, 6),
(9,  'BRG009', 'Sabun Mandi',          4500,  90, 7),
(10, 'BRG010', 'Deterjen 800g',       21000,  55, 7);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001', 'Budi Santoso',    'L', '081200000001', 'Jl. Darmo No. 10, Surabaya'),
('P002', 'Siti Aminah',     'P', '081200000002', 'Jl. Rungkut Asri 5, Surabaya'),
('P003', 'Ahmad Fauzi',     'L', '081200000003', 'Jl. Merr 21, Surabaya'),
('P004', 'Dewi Lestari',    'P', '081200000004', 'Jl. Kenjeran 88, Surabaya'),
('P005', 'Rudi Hartono',    'L', '081200000005', 'Jl. Ahmad Yani 3, Sidoarjo'),
('P006', 'Rina Wulandari',  'P', '081200000006', 'Jl. Pemuda 17, Gresik'),
('P007', 'Eko Prasetyo',    'L', '081200000007', 'Jl. Diponegoro 45, Surabaya'),
('P008', 'Nur Hidayah',     'P', '081200000008', 'Jl. Gubeng 12, Surabaya'),
('P009', 'Hendra Wijaya',   'L', '081200000009', 'Jl. Raya Bangkalan 9, Bangkalan'),
('P010', 'Lilis Suryani',   'P', '081200000010', 'Jl. Wonokromo 30, Surabaya');

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1,  '2026-10-01', 'Belanja bulanan',        102000, 'P001'),
(2,  '2026-10-03', 'Kebutuhan dapur',         73000, 'P002'),
(3,  '2026-10-05', 'Beli telur',              58000, 'P003'),
(4,  '2026-10-08', 'Stok kopi dan teh',       40000, 'P004'),
(5,  '2026-10-10', 'Susu keluarga',           57000, 'P005'),
(6,  '2026-10-12', 'Perlengkapan mandi',      39000, 'P006'),
(7,  '2026-10-15', 'Beras 2 karung',         136000, 'P007'),
(8,  '2026-10-18', 'Stok mie warung',         87000, 'P008'),
(9,  '2026-10-21', 'Minyak dan telur',       105000, 'P009'),
(10, '2026-10-25', 'Belanja mingguan',        70000, 'P010');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1,  1, 68000,  1),
(1,  3, 17000,  2),
(2,  2, 38000,  1),
(2,  7,  3500, 10),
(3,  4, 29000,  2),
(4,  5, 22000,  1),
(4,  6,  9000,  2),
(5,  8, 19000,  3),
(6,  9,  4500,  4),
(6,  10,21000,  1),
(7,  1, 68000,  2),
(8,  7,  3500, 20),
(8,  3, 17000,  1),
(9,  2, 38000,  2),
(9,  4, 29000,  1),
(10, 10,21000,  2),
(10, 8, 19000,  1),
(10, 6,  9000,  1);

INSERT INTO pembayaran (id, waktu_bayar, total, metode, transaksi_id) VALUES
(1,  '2026-10-01 10:15:00', 102000, 'TUNAI',    1),
(2,  '2026-10-03 11:20:00',  73000, 'TRANSFER', 2),
(3,  '2026-10-05 09:05:00',  58000, 'TUNAI',    3),
(4,  '2026-10-08 14:40:00',  40000, 'EDC',      4),
(5,  '2026-10-10 16:10:00',  57000, 'TUNAI',    5),
(6,  '2026-10-12 13:30:00',  39000, 'TRANSFER', 6),
(7,  '2026-10-15 08:55:00', 136000, 'EDC',      7),
(8,  '2026-10-18 17:25:00',  87000, 'TUNAI',    8),
(9,  '2026-10-21 12:00:00', 105000, 'TRANSFER', 9),
(10, '2026-10-25 15:45:00',  70000, 'EDC',     10);

INSERT INTO user (id_user, username, password, nama, alamat, hp, level) VALUES
(1,  'admin',   MD5('admin123'),  'Administrator',   'Jl. Pahlawan 1, Surabaya',     '081300000001', 1),
(2,  'kasir1',  MD5('kasir123'),  'Andi Kasir',      'Jl. Basuki Rahmat 2, Surabaya','081300000002', 2),
(3,  'kasir2',  MD5('kasir123'),  'Bunga Kasir',     'Jl. Tunjungan 3, Surabaya',    '081300000003', 2),
(4,  'kasir3',  MD5('kasir123'),  'Candra Kasir',    'Jl. Embong Malang 4, Surabaya','081300000004', 2),
(5,  'gudang1', MD5('gudang123'), 'Dimas Gudang',    'Jl. Margomulyo 5, Surabaya',   '081300000005', 2),
(6,  'gudang2', MD5('gudang123'), 'Eka Gudang',      'Jl. Tandes 6, Surabaya',       '081300000006', 2),
(7,  'owner',   MD5('owner123'),  'Fajar Pemilik',   'Jl. Ngagel 7, Surabaya',       '081300000007', 1),
(8,  'staf1',   MD5('staf123'),   'Gita Staf',       'Jl. Wiyung 8, Surabaya',       '081300000008', 2),
(9,  'staf2',   MD5('staf123'),   'Hadi Staf',       'Jl. Sukolilo 9, Surabaya',     '081300000009', 2),
(10, 'staf3',   MD5('staf123'),   'Indah Staf',      'Jl. Mulyorejo 10, Surabaya',   '081300000010', 2);
