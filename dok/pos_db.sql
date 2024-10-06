-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Sep 2021 pada 09.07
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_gudang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank`
--

CREATE TABLE `bank` (
  `id_bank` bigint(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `keterangan` varchar(225) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(20) DEFAULT NULL,
  `barcode` varchar(20) DEFAULT NULL,
  `nama_barang` varchar(50) DEFAULT NULL,
  `gambar` varchar(225) DEFAULT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `id_satuan` int(11) DEFAULT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `harga_beli` varchar(30) DEFAULT NULL,
  `harga_jual` varchar(30) DEFAULT NULL,
  `harga_pelanggan` int(11) DEFAULT NULL,
  `harga_toko` int(11) DEFAULT NULL,
  `harga_sales` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `kode_barang`, `barcode`, `nama_barang`, `gambar`, `id_kategori`, `id_satuan`, `id_supplier`, `harga_beli`, `harga_jual`, `harga_pelanggan`, `harga_toko`, `harga_sales`, `stok`, `is_active`) VALUES
(81, 'BRG-00089', '6938208916080', 'Loyang Teflon Segi 26x26x4', 'default.jpg', NULL, 1, NULL, '40500', '45000', 45000, 45000, 45000, 21, 1),
(82, 'BRG-00090', '6933308916080', 'Loyang Teflon Segi Tiga', 'default.jpg', NULL, 1, NULL, '40500', '45000', 45000, 45000, 45000, 21, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_cs` int(11) NOT NULL,
  `kode_cs` varchar(20) DEFAULT NULL,
  `nama_cs` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `jenis_cs` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_cs`, `kode_cs`, `nama_cs`, `jenis_kelamin`, `telp`, `email`, `alamat`, `jenis_cs`) VALUES
(1, 'CS-000001', 'Umum', 'Umum', 'Umum', 'Umum', 'Umum', 'Umum'),
(2, 'CS-000002', 'Bambang', 'Laki-Laki', '08109257094', 'bambang@gmail.com', 'Bangorejo', 'Toko'),
(6, 'CS-000002', 'Untung', 'Laki-Laki', '087367123654', 'untung12@gmail.com', 'Banyuwangi', 'Sales'),
(7, 'CS-000003', 'Bu Susiati', 'Perempuan', '082781673645', 'susiati@gmail.com', 'Rogojampi', 'Pelanggan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detil_hutang`
--

CREATE TABLE `detil_hutang` (
  `id_detil_hutang` bigint(20) NOT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_hutang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detil_pembelian`
--

CREATE TABLE `detil_pembelian` (
  `id_detil_beli` bigint(20) NOT NULL,
  `id_beli` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `kode_detil_beli` varchar(20) DEFAULT NULL,
  `hrg_beli` int(11) DEFAULT NULL,
  `hrg_jual` int(11) DEFAULT NULL,
  `qty_beli` int(11) DEFAULT NULL,
  `subtotal` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detil_penjualan`
--

CREATE TABLE `detil_penjualan` (
  `id_detil_jual` bigint(20) NOT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_servis` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `kode_detil_jual` varchar(20) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `harga_item` int(11) DEFAULT NULL,
  `qty_jual` int(11) DEFAULT NULL,
  `subtotal` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detil_piutang`
--

CREATE TABLE `detil_piutang` (
  `id_detil_piutang` bigint(20) NOT NULL,
  `tgl_bayar` datetime DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_piutang` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `id_barang`, `stok`) VALUES
(7, 81, 21),
(8, 82, 21);

-- --------------------------------------------------------

--
-- Struktur dari tabel `hutang`
--

CREATE TABLE `hutang` (
  `id_hutang` bigint(20) NOT NULL,
  `id_beli` int(11) DEFAULT NULL,
  `tgl_hutang` datetime DEFAULT NULL,
  `jml_hutang` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `jatuh_tempo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `kode_karyawan` varchar(20) DEFAULT NULL,
  `nama_karyawan` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `telp_karyawan` varchar(15) DEFAULT NULL,
  `email_karyawan` varchar(50) DEFAULT NULL,
  `status_karyawan` varchar(20) DEFAULT NULL,
  `tmpt_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` varchar(20) DEFAULT NULL,
  `tgl_masuk` varchar(20) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `kode_karyawan`, `nama_karyawan`, `jenis_kelamin`, `telp_karyawan`, `email_karyawan`, `status_karyawan`, `tmpt_lahir`, `tgl_lahir`, `tgl_masuk`, `alamat`) VALUES
(3, 'K-00002', 'Ciko Ciki Tita', 'Laki-Laki', '082236578566', 'cikocik@gmail.com', 'Tetap', 'Banyuwangi', '04 Oktober 1998', '11/10/2019', 'Songgon'),
(16, 'K-00003', 'Rio Febrianto', 'Laki-Laki', '081092570948', 'riofebrianto@gmail.com', 'Tetap', 'Banyuwangi', '03 Maret 1998', '18/01/2020', 'Banyuwangi'),
(25, 'K-00004', 'Lina Fitriyani', 'Perempuan', '087898728987', 'lina@gmail.com', 'Tetap', 'Banyuwangi', '3 Desember 1991', '10/07/2020', 'Jl. Kepiting'),
(26, 'K-00005', 'Dinda Nur Azahra', 'Perempuan', '087893338990', 'dinda@gmail.com', 'Tetap', 'Malang', '04 Maret 1981', '10/07/2020', 'Jl. Udang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kas`
--

CREATE TABLE `kas` (
  `id_kas` bigint(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `kode_kas` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `nominal` varchar(50) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(1, 'Minuman'),
(3, 'Makanan'),
(4, 'Bahan Produksi'),
(7, 'Plastik'),
(8, 'Mainan'),
(9, 'Perabot'),
(12, 'Kecantikan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pajak_ppn`
--

CREATE TABLE `pajak_ppn` (
  `id_pajak` bigint(20) NOT NULL,
  `kode_pajak` varchar(20) DEFAULT NULL,
  `jenis` varchar(70) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `id_beli` int(11) NOT NULL,
  `id_supplier` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `kode_beli` varchar(20) DEFAULT NULL,
  `tgl_faktur` varchar(20) DEFAULT NULL,
  `faktur_beli` varchar(20) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `method` varchar(30) DEFAULT NULL,
  `total` varchar(30) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembali` int(11) DEFAULT NULL,
  `tgl` datetime NOT NULL,
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_jual` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_cs` int(11) DEFAULT NULL,
  `kode_jual` varchar(20) DEFAULT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `method` varchar(30) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembali` int(11) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `piutang`
--

CREATE TABLE `piutang` (
  `id_piutang` bigint(20) NOT NULL,
  `id_jual` int(11) DEFAULT NULL,
  `tgl_piutang` datetime DEFAULT NULL,
  `jml_piutang` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `jatuh_tempo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_perusahaan`
--

CREATE TABLE `profil_perusahaan` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(100) DEFAULT NULL,
  `alamat_toko` varchar(100) DEFAULT NULL,
  `telp_toko` varchar(15) DEFAULT NULL,
  `fax_toko` varchar(15) DEFAULT NULL,
  `email_toko` varchar(50) DEFAULT NULL,
  `website_toko` varchar(50) DEFAULT NULL,
  `logo_toko` varchar(50) DEFAULT NULL,
  `IG` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `profil_perusahaan`
--

INSERT INTO `profil_perusahaan` (`id_toko`, `nama_toko`, `alamat_toko`, `telp_toko`, `fax_toko`, `email_toko`, `website_toko`, `logo_toko`, `IG`) VALUES
(1, 'Toko Barokah', 'Jln. Piere Tendean, Banyuwangi', '085674893092', '(0333) 094837', 'barokah@gmail.com', 'www.barokah.com', 'cart.png', 'brusedbykarin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `satuan`
--

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL,
  `satuan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `satuan`
--

INSERT INTO `satuan` (`id_satuan`, `satuan`) VALUES
(1, 'PCS'),
(4, 'Kg'),
(5, 'Gr'),
(6, 'BTL'),
(7, 'SLP'),
(9, 'Liter'),
(15, 'Pax'),
(18, 'Lusin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `servis`
--

CREATE TABLE `servis` (
  `id_servis` bigint(20) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `nama_servis` varchar(200) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `servis`
--

INSERT INTO `servis` (`id_servis`, `kode`, `nama_servis`, `harga`, `keterangan`, `status`) VALUES
(1, 'SV174609', 'Keramas', 15000, 'Keramas dengan menggunakan shampo pantene', 'Aktif'),
(2, 'SV176765', 'Potong Rambut', 10000, 'Potong Rambut Semua Model', 'Aktif'),
(5, 'SV130214', 'Krimbat', 50000, 'Krimbat dengan profesional', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `id_stok` bigint(20) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_opname`
--

CREATE TABLE `stok_opname` (
  `id_stok_opname` bigint(20) NOT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `stok` varchar(10) DEFAULT NULL,
  `stok_nyata` varchar(10) DEFAULT NULL,
  `selisih` varchar(10) DEFAULT NULL,
  `nilai` varchar(50) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `kode_supplier` varchar(20) DEFAULT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `alamat_supplier` varchar(100) DEFAULT NULL,
  `telp_supplier` varchar(15) DEFAULT NULL,
  `fax_supplier` varchar(15) DEFAULT NULL,
  `email_supplier` char(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `rekening` varchar(30) DEFAULT NULL,
  `atas_nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `kode_supplier`, `nama_supplier`, `alamat_supplier`, `telp_supplier`, `fax_supplier`, `email_supplier`, `bank`, `rekening`, `atas_nama`) VALUES
(3, 'SP-00001', 'CV. Nusantara Packindo', 'Banyuwangi', '-', '-', 'nusantara@gmail.com', 'BRI', '-', 'Yuda'),
(4, 'SP-00002', 'CV. Indo Visitama', 'Rogojampi', '-', '-', 'visitama@gmail.com', 'BCA', '12092389201', 'Riyan'),
(5, 'SP-00003', 'CV. Karunia Jaya Perkasa', 'Banyuwangi', '-', '-', 'kperkasa@gmail.com', 'BCA', '1209889201', 'Sinta'),
(33, 'SP-00004', 'CV. Jaya Makmur', 'Bangorejo', '082716273821', '-', 'jayamakmur@gmail.com', 'BNI', '8938203842', 'Ridwan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `tipe` varchar(30) DEFAULT NULL,
  `alamat_user` varchar(100) DEFAULT NULL,
  `telp_user` varchar(15) DEFAULT NULL,
  `email_user` varchar(50) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `nama_lengkap`, `password`, `tipe`, `alamat_user`, `telp_user`, `email_user`, `is_active`) VALUES
(1, 'admin', 'Administrator', '$2y$10$oagi0l6Q3v.bwPCCVgOQXOnWX1FPLAvIiIfMJwIrJjk4212ACLN7.', 'Administrator', 'Banyuwagi', '085647382748', 'admin@gmail.com', 1),
(3, 'kasir', 'Kasir', '$2y$10$nWBEdyFeReNQtbr4lGUWmuN9SXKRtpqdog2CtXPFcmqCzb6p5Bmp6', 'Kasir', 'Banyuwangi', '082236578566', 'kasir@gmail.com', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_log`
--

CREATE TABLE `user_log` (
  `id_log` bigint(20) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `login` datetime DEFAULT NULL,
  `logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `ID_KATEGORI` (`id_kategori`),
  ADD KEY `ID_SATUAN` (`id_satuan`),
  ADD KEY `ID_SUPPLIER` (`id_supplier`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_cs`);

--
-- Indeks untuk tabel `detil_hutang`
--
ALTER TABLE `detil_hutang`
  ADD PRIMARY KEY (`id_detil_hutang`);

--
-- Indeks untuk tabel `detil_pembelian`
--
ALTER TABLE `detil_pembelian`
  ADD PRIMARY KEY (`id_detil_beli`),
  ADD KEY `FK_BARANG_DETIL_PEMBELIAN` (`id_barang`),
  ADD KEY `FK_PEMBELIAN_DETIL` (`id_beli`);

--
-- Indeks untuk tabel `detil_penjualan`
--
ALTER TABLE `detil_penjualan`
  ADD PRIMARY KEY (`id_detil_jual`),
  ADD KEY `FK_BARANG_PENJUALAN_DETIL` (`id_barang`),
  ADD KEY `FK_PENJUALAN_DETIL` (`id_jual`);

--
-- Indeks untuk tabel `detil_piutang`
--
ALTER TABLE `detil_piutang`
  ADD PRIMARY KEY (`id_detil_piutang`);

--
-- Indeks untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`),
  ADD KEY `FK_Barang_Gudang` (`id_barang`);

--
-- Indeks untuk tabel `hutang`
--
ALTER TABLE `hutang`
  ADD PRIMARY KEY (`id_hutang`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`);

--
-- Indeks untuk tabel `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id_kas`),
  ADD KEY `ID_USER` (`id_user`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `pajak_ppn`
--
ALTER TABLE `pajak_ppn`
  ADD PRIMARY KEY (`id_pajak`),
  ADD KEY `ID_USER` (`id_user`);

--
-- Indeks untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_beli`),
  ADD KEY `FK_MENCATAT_PEMBELIAN` (`id_user`),
  ADD KEY `FK_TRANSAKSI_PEMBELIAN` (`id_supplier`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_jual`),
  ADD KEY `FK_MELAYANI` (`id_user`),
  ADD KEY `FK_TRANSAKSI` (`id_cs`);

--
-- Indeks untuk tabel `piutang`
--
ALTER TABLE `piutang`
  ADD PRIMARY KEY (`id_piutang`);

--
-- Indeks untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  ADD PRIMARY KEY (`id_toko`);

--
-- Indeks untuk tabel `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`id_satuan`);

--
-- Indeks untuk tabel `servis`
--
ALTER TABLE `servis`
  ADD PRIMARY KEY (`id_servis`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indeks untuk tabel `stok_opname`
--
ALTER TABLE `stok_opname`
  ADD PRIMARY KEY (`id_stok_opname`),
  ADD KEY `ID_BARANG` (`id_barang`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `ID_USER` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_cs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `detil_hutang`
--
ALTER TABLE `detil_hutang`
  MODIFY `id_detil_hutang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `detil_pembelian`
--
ALTER TABLE `detil_pembelian`
  MODIFY `id_detil_beli` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `detil_penjualan`
--
ALTER TABLE `detil_penjualan`
  MODIFY `id_detil_jual` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `detil_piutang`
--
ALTER TABLE `detil_piutang`
  MODIFY `id_detil_piutang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `hutang`
--
ALTER TABLE `hutang`
  MODIFY `id_hutang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `kas`
--
ALTER TABLE `kas`
  MODIFY `id_kas` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `pajak_ppn`
--
ALTER TABLE `pajak_ppn`
  MODIFY `id_pajak` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_beli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_jual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT untuk tabel `piutang`
--
ALTER TABLE `piutang`
  MODIFY `id_piutang` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `profil_perusahaan`
--
ALTER TABLE `profil_perusahaan`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `satuan`
--
ALTER TABLE `satuan`
  MODIFY `id_satuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `servis`
--
ALTER TABLE `servis`
  MODIFY `id_servis` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `id_stok` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `stok_opname`
--
ALTER TABLE `stok_opname`
  MODIFY `id_stok_opname` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id_log` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `ITEM_SUPPLIER` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `KATEGORI_BARANG` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `SATUAN_BARANG` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detil_pembelian`
--
ALTER TABLE `detil_pembelian`
  ADD CONSTRAINT `FK_BARANG_DETIL_PEMBELIAN` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `FK_PEMBELIAN_DETIL` FOREIGN KEY (`id_beli`) REFERENCES `pembelian` (`id_beli`);

--
-- Ketidakleluasaan untuk tabel `detil_penjualan`
--
ALTER TABLE `detil_penjualan`
  ADD CONSTRAINT `FK_BARANG_PENJUALAN_DETIL` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `FK_PENJUALAN_DETIL` FOREIGN KEY (`id_jual`) REFERENCES `penjualan` (`id_jual`);

--
-- Ketidakleluasaan untuk tabel `gudang`
--
ALTER TABLE `gudang`
  ADD CONSTRAINT `FK_Barang_Gudang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
