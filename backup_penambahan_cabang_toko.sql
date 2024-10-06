/*
SQLyog Community v13.1.9 (64 bit)
MySQL - 10.4.22-MariaDB : Database - pos_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `bank` */

DROP TABLE IF EXISTS `bank`;

CREATE TABLE `bank` (
  `id_bank` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `keterangan` varchar(225) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bank`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `bank` */

/*Table structure for table `barang` */

DROP TABLE IF EXISTS `barang`;

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_active` int(11) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_barang`),
  KEY `ID_KATEGORI` (`id_kategori`),
  KEY `ID_SATUAN` (`id_satuan`),
  KEY `ID_SUPPLIER` (`id_supplier`),
  CONSTRAINT `ITEM_SUPPLIER` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `KATEGORI_BARANG` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `SATUAN_BARANG` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id_satuan`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

/*Data for the table `barang` */

insert  into `barang`(`id_barang`,`kode_barang`,`barcode`,`nama_barang`,`gambar`,`id_kategori`,`id_satuan`,`id_supplier`,`harga_beli`,`harga_jual`,`harga_pelanggan`,`harga_toko`,`harga_sales`,`stok`,`is_active`,`cabang`) values (81,'BRG-00089','6938208916080','Loyang Teflon Segi 26x26x4','default.jpg',9,1,3,'40500','45000',45000,45000,45000,19,1,NULL);
insert  into `barang`(`id_barang`,`kode_barang`,`barcode`,`nama_barang`,`gambar`,`id_kategori`,`id_satuan`,`id_supplier`,`harga_beli`,`harga_jual`,`harga_pelanggan`,`harga_toko`,`harga_sales`,`stok`,`is_active`,`cabang`) values (82,'BRG-00090','6933308916080','Loyang Teflon Segi Tiga','default.jpg',NULL,1,NULL,'40500','45000',45000,45000,45000,13,1,NULL);

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id_cs` int(11) NOT NULL AUTO_INCREMENT,
  `kode_cs` varchar(20) DEFAULT NULL,
  `nama_cs` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `telp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `jenis_cs` varchar(50) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_cs`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

/*Data for the table `customer` */

insert  into `customer`(`id_cs`,`kode_cs`,`nama_cs`,`jenis_kelamin`,`telp`,`email`,`alamat`,`jenis_cs`,`cabang`) values (1,'CS-000001','Umum','Umum','Umum','Umum','Umum','Umum',NULL);
insert  into `customer`(`id_cs`,`kode_cs`,`nama_cs`,`jenis_kelamin`,`telp`,`email`,`alamat`,`jenis_cs`,`cabang`) values (2,'CS-000002','Bambang','Laki-Laki','08109257094','bambang@gmail.com','Bangorejo','Toko',NULL);
insert  into `customer`(`id_cs`,`kode_cs`,`nama_cs`,`jenis_kelamin`,`telp`,`email`,`alamat`,`jenis_cs`,`cabang`) values (6,'CS-000002','Untung','Laki-Laki','087367123654','untung12@gmail.com','Banyuwangi','Sales',NULL);
insert  into `customer`(`id_cs`,`kode_cs`,`nama_cs`,`jenis_kelamin`,`telp`,`email`,`alamat`,`jenis_cs`,`cabang`) values (7,'CS-000003','Bu Susiati','Perempuan','082781673645','susiati@gmail.com','Rogojampi','Pelanggan',NULL);

/*Table structure for table `detil_hutang` */

DROP TABLE IF EXISTS `detil_hutang`;

CREATE TABLE `detil_hutang` (
  `id_detil_hutang` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_bayar` datetime DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_hutang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detil_hutang`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `detil_hutang` */

/*Table structure for table `detil_pembelian` */

DROP TABLE IF EXISTS `detil_pembelian`;

CREATE TABLE `detil_pembelian` (
  `id_detil_beli` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_beli` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `kode_detil_beli` varchar(20) DEFAULT NULL,
  `hrg_beli` int(11) DEFAULT NULL,
  `hrg_jual` int(11) DEFAULT NULL,
  `qty_beli` int(11) DEFAULT NULL,
  `subtotal` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_detil_beli`),
  KEY `FK_BARANG_DETIL_PEMBELIAN` (`id_barang`),
  KEY `FK_PEMBELIAN_DETIL` (`id_beli`),
  CONSTRAINT `FK_BARANG_DETIL_PEMBELIAN` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  CONSTRAINT `FK_PEMBELIAN_DETIL` FOREIGN KEY (`id_beli`) REFERENCES `pembelian` (`id_beli`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

/*Data for the table `detil_pembelian` */

insert  into `detil_pembelian`(`id_detil_beli`,`id_beli`,`id_barang`,`kode_detil_beli`,`hrg_beli`,`hrg_jual`,`qty_beli`,`subtotal`) values (27,35,81,'DB-0000001',40500,45000,20,'810000');

/*Table structure for table `detil_penjualan` */

DROP TABLE IF EXISTS `detil_penjualan`;

CREATE TABLE `detil_penjualan` (
  `id_detil_jual` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_jual` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_servis` int(11) DEFAULT NULL,
  `id_karyawan` int(11) DEFAULT NULL,
  `kode_detil_jual` varchar(20) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `harga_item` int(11) DEFAULT NULL,
  `qty_jual` int(11) DEFAULT NULL,
  `subtotal` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_detil_jual`),
  KEY `FK_BARANG_PENJUALAN_DETIL` (`id_barang`),
  KEY `FK_PENJUALAN_DETIL` (`id_jual`),
  CONSTRAINT `FK_BARANG_PENJUALAN_DETIL` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  CONSTRAINT `FK_PENJUALAN_DETIL` FOREIGN KEY (`id_jual`) REFERENCES `penjualan` (`id_jual`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

/*Data for the table `detil_penjualan` */

insert  into `detil_penjualan`(`id_detil_jual`,`id_jual`,`id_barang`,`id_servis`,`id_karyawan`,`kode_detil_jual`,`diskon`,`harga_item`,`qty_jual`,`subtotal`) values (40,121,81,NULL,NULL,'DJ-0000001',0,45000,1,'45000');
insert  into `detil_penjualan`(`id_detil_jual`,`id_jual`,`id_barang`,`id_servis`,`id_karyawan`,`kode_detil_jual`,`diskon`,`harga_item`,`qty_jual`,`subtotal`) values (41,121,81,NULL,NULL,'DJ-0000002',0,45000,1,'45000');
insert  into `detil_penjualan`(`id_detil_jual`,`id_jual`,`id_barang`,`id_servis`,`id_karyawan`,`kode_detil_jual`,`diskon`,`harga_item`,`qty_jual`,`subtotal`) values (42,121,82,NULL,NULL,'DJ-0000003',0,45000,8,'360000');

/*Table structure for table `detil_piutang` */

DROP TABLE IF EXISTS `detil_piutang`;

CREATE TABLE `detil_piutang` (
  `id_detil_piutang` bigint(20) NOT NULL AUTO_INCREMENT,
  `tgl_bayar` datetime DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_piutang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_detil_piutang`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `detil_piutang` */

/*Table structure for table `gudang` */

DROP TABLE IF EXISTS `gudang`;

CREATE TABLE `gudang` (
  `id_gudang` int(11) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_gudang`),
  KEY `FK_Barang_Gudang` (`id_barang`),
  CONSTRAINT `FK_Barang_Gudang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `gudang` */

insert  into `gudang`(`id_gudang`,`id_barang`,`stok`,`cabang`) values (7,81,41,NULL);
insert  into `gudang`(`id_gudang`,`id_barang`,`stok`,`cabang`) values (8,82,21,NULL);

/*Table structure for table `hutang` */

DROP TABLE IF EXISTS `hutang`;

CREATE TABLE `hutang` (
  `id_hutang` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_beli` int(11) DEFAULT NULL,
  `tgl_hutang` datetime DEFAULT NULL,
  `jml_hutang` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `jatuh_tempo` varchar(15) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_hutang`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `hutang` */

/*Table structure for table `karyawan` */

DROP TABLE IF EXISTS `karyawan`;

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_karyawan` varchar(20) DEFAULT NULL,
  `nama_karyawan` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `telp_karyawan` varchar(15) DEFAULT NULL,
  `email_karyawan` varchar(50) DEFAULT NULL,
  `status_karyawan` varchar(20) DEFAULT NULL,
  `tmpt_lahir` varchar(50) DEFAULT NULL,
  `tgl_lahir` varchar(20) DEFAULT NULL,
  `tgl_masuk` varchar(20) DEFAULT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `karyawan` */

insert  into `karyawan`(`id_karyawan`,`kode_karyawan`,`nama_karyawan`,`jenis_kelamin`,`telp_karyawan`,`email_karyawan`,`status_karyawan`,`tmpt_lahir`,`tgl_lahir`,`tgl_masuk`,`alamat`,`cabang`) values (3,'K-00002','Ciko Ciki Tita','Laki-Laki','082236578566','cikocik@gmail.com','Tetap','Banyuwangi','04 Oktober 1998','11/10/2019','Songgon',NULL);
insert  into `karyawan`(`id_karyawan`,`kode_karyawan`,`nama_karyawan`,`jenis_kelamin`,`telp_karyawan`,`email_karyawan`,`status_karyawan`,`tmpt_lahir`,`tgl_lahir`,`tgl_masuk`,`alamat`,`cabang`) values (16,'K-00003','Rio Febrianto','Laki-Laki','081092570948','riofebrianto@gmail.com','Tetap','Banyuwangi','03 Maret 1998','18/01/2020','Banyuwangi',NULL);
insert  into `karyawan`(`id_karyawan`,`kode_karyawan`,`nama_karyawan`,`jenis_kelamin`,`telp_karyawan`,`email_karyawan`,`status_karyawan`,`tmpt_lahir`,`tgl_lahir`,`tgl_masuk`,`alamat`,`cabang`) values (25,'K-00004','Lina Fitriyani','Perempuan','087898728987','lina@gmail.com','Tetap','Banyuwangi','3 Desember 1991','10/07/2020','Jl. Kepiting',NULL);
insert  into `karyawan`(`id_karyawan`,`kode_karyawan`,`nama_karyawan`,`jenis_kelamin`,`telp_karyawan`,`email_karyawan`,`status_karyawan`,`tmpt_lahir`,`tgl_lahir`,`tgl_masuk`,`alamat`,`cabang`) values (26,'K-00005','Dinda Nur Azahra','Perempuan','087893338990','dinda@gmail.com','Tetap','Malang','04 Maret 1981','10/07/2020','Jl. Udang',NULL);

/*Table structure for table `kas` */

DROP TABLE IF EXISTS `kas`;

CREATE TABLE `kas` (
  `id_kas` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `kode_kas` varchar(20) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` varchar(20) DEFAULT NULL,
  `nominal` varchar(50) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kas`),
  KEY `ID_USER` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

/*Data for the table `kas` */

insert  into `kas`(`id_kas`,`id_user`,`kode_kas`,`tanggal`,`jenis`,`nominal`,`keterangan`,`cabang`) values (76,1,'KS-0000001','2022-07-17 20:41:15','Pemasukan','450000','Penjualan',NULL);
insert  into `kas`(`id_kas`,`id_user`,`kode_kas`,`tanggal`,`jenis`,`nominal`,`keterangan`,`cabang`) values (77,1,'KS-0000002','2022-07-23 07:03:20','Pengeluaran','810000','Pembelian',NULL);

/*Table structure for table `kategori` */

DROP TABLE IF EXISTS `kategori`;

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(50) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `kategori` */

insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (1,'Minuman',NULL);
insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (3,'Makanan',NULL);
insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (4,'Bahan Produksi',NULL);
insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (7,'Plastik',NULL);
insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (8,'Mainan',NULL);
insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (9,'Perabot',NULL);
insert  into `kategori`(`id_kategori`,`kategori`,`cabang`) values (12,'Kecantikan',NULL);

/*Table structure for table `pajak_ppn` */

DROP TABLE IF EXISTS `pajak_ppn`;

CREATE TABLE `pajak_ppn` (
  `id_pajak` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_pajak` varchar(20) DEFAULT NULL,
  `jenis` varchar(70) DEFAULT NULL,
  `nominal` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pajak`),
  KEY `ID_USER` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `pajak_ppn` */

/*Table structure for table `pembelian` */

DROP TABLE IF EXISTS `pembelian`;

CREATE TABLE `pembelian` (
  `id_beli` int(11) NOT NULL AUTO_INCREMENT,
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
  `is_active` int(11) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_beli`),
  KEY `FK_MENCATAT_PEMBELIAN` (`id_user`),
  KEY `FK_TRANSAKSI_PEMBELIAN` (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

/*Data for the table `pembelian` */

insert  into `pembelian`(`id_beli`,`id_supplier`,`id_user`,`kode_beli`,`tgl_faktur`,`faktur_beli`,`diskon`,`method`,`total`,`bayar`,`kembali`,`tgl`,`is_active`,`cabang`) values (35,3,1,'PB-0000001','2022-07-23','234567',0,'Cash','810000',810000,0,'2022-07-23 07:03:20',1,NULL);

/*Table structure for table `penjualan` */

DROP TABLE IF EXISTS `penjualan`;

CREATE TABLE `penjualan` (
  `id_jual` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `id_cs` int(11) DEFAULT NULL,
  `kode_jual` varchar(20) DEFAULT NULL,
  `invoice` varchar(50) DEFAULT NULL,
  `method` varchar(30) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `kembali` int(11) DEFAULT NULL,
  `ppn` int(11) DEFAULT NULL,
  `tgl` datetime DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jual`),
  KEY `FK_MELAYANI` (`id_user`),
  KEY `FK_TRANSAKSI` (`id_cs`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=latin1;

/*Data for the table `penjualan` */

insert  into `penjualan`(`id_jual`,`id_user`,`id_cs`,`kode_jual`,`invoice`,`method`,`bayar`,`kembali`,`ppn`,`tgl`,`is_active`,`cabang`) values (121,1,7,'KJ-0000001','POS20220717204115','Cash',450000,0,0,'2022-07-17 20:41:15',1,NULL);

/*Table structure for table `piutang` */

DROP TABLE IF EXISTS `piutang`;

CREATE TABLE `piutang` (
  `id_piutang` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_jual` int(11) DEFAULT NULL,
  `tgl_piutang` datetime DEFAULT NULL,
  `jml_piutang` int(11) DEFAULT NULL,
  `bayar` int(11) DEFAULT NULL,
  `sisa` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `jatuh_tempo` varchar(15) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_piutang`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `piutang` */

/*Table structure for table `profil_perusahaan` */

DROP TABLE IF EXISTS `profil_perusahaan`;

CREATE TABLE `profil_perusahaan` (
  `id_toko` int(11) NOT NULL AUTO_INCREMENT,
  `nama_toko` varchar(100) DEFAULT NULL,
  `alamat_toko` varchar(100) DEFAULT NULL,
  `telp_toko` varchar(15) DEFAULT NULL,
  `fax_toko` varchar(15) DEFAULT NULL,
  `email_toko` varchar(50) DEFAULT NULL,
  `website_toko` varchar(50) DEFAULT NULL,
  `logo_toko` varchar(50) DEFAULT NULL,
  `IG` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_toko`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `profil_perusahaan` */

insert  into `profil_perusahaan`(`id_toko`,`nama_toko`,`alamat_toko`,`telp_toko`,`fax_toko`,`email_toko`,`website_toko`,`logo_toko`,`IG`) values (1,'Toko Barokah','Jln. Piere Tendean, Banyuwangi','085674893092','(0333) 094837','barokah@gmail.com','www.barokah.com','cart.png','brusedbykarin');

/*Table structure for table `satuan` */

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `id_satuan` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(50) DEFAULT NULL,
  `satuan_konversi` int(11) DEFAULT 1,
  PRIMARY KEY (`id_satuan`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `satuan` */

insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (1,'PCS',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (4,'Kg',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (5,'Gr',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (6,'BTL',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (7,'SLP',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (9,'Liter',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (15,'Pax',1);
insert  into `satuan`(`id_satuan`,`satuan`,`satuan_konversi`) values (18,'Lusin',1);

/*Table structure for table `servis` */

DROP TABLE IF EXISTS `servis`;

CREATE TABLE `servis` (
  `id_servis` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode` varchar(20) DEFAULT NULL,
  `nama_servis` varchar(200) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_servis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `servis` */

insert  into `servis`(`id_servis`,`kode`,`nama_servis`,`harga`,`keterangan`,`status`,`cabang`) values (1,'SV174609','Keramas',15000,'Keramas dengan menggunakan shampo pantene','Aktif',NULL);
insert  into `servis`(`id_servis`,`kode`,`nama_servis`,`harga`,`keterangan`,`status`,`cabang`) values (2,'SV176765','Potong Rambut',10000,'Potong Rambut Semua Model','Aktif',NULL);
insert  into `servis`(`id_servis`,`kode`,`nama_servis`,`harga`,`keterangan`,`status`,`cabang`) values (5,'SV130214','Krimbat',50000,'Krimbat dengan profesional','Aktif',NULL);

/*Table structure for table `stok` */

DROP TABLE IF EXISTS `stok`;

CREATE TABLE `stok` (
  `id_stok` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_stok`),
  KEY `id_barang` (`id_barang`),
  CONSTRAINT `stok_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `stok` */

/*Table structure for table `stok_opname` */

DROP TABLE IF EXISTS `stok_opname`;

CREATE TABLE `stok_opname` (
  `id_stok_opname` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_barang` int(11) DEFAULT NULL,
  `stok` varchar(10) DEFAULT NULL,
  `stok_nyata` varchar(10) DEFAULT NULL,
  `selisih` varchar(10) DEFAULT NULL,
  `nilai` varchar(50) DEFAULT NULL,
  `keterangan` varchar(250) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_stok_opname`),
  KEY `ID_BARANG` (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `stok_opname` */

/*Table structure for table `supplier` */

DROP TABLE IF EXISTS `supplier`;

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL AUTO_INCREMENT,
  `kode_supplier` varchar(20) DEFAULT NULL,
  `nama_supplier` varchar(100) DEFAULT NULL,
  `alamat_supplier` varchar(100) DEFAULT NULL,
  `telp_supplier` varchar(15) DEFAULT NULL,
  `fax_supplier` varchar(15) DEFAULT NULL,
  `email_supplier` char(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `rekening` varchar(30) DEFAULT NULL,
  `atas_nama` varchar(50) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_supplier`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

/*Data for the table `supplier` */

insert  into `supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telp_supplier`,`fax_supplier`,`email_supplier`,`bank`,`rekening`,`atas_nama`,`cabang`) values (3,'SP-00001','CV. Nusantara Packindo','Banyuwangi','-','-','nusantara@gmail.com','BRI','-','Yuda',NULL);
insert  into `supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telp_supplier`,`fax_supplier`,`email_supplier`,`bank`,`rekening`,`atas_nama`,`cabang`) values (4,'SP-00002','CV. Indo Visitama','Rogojampi','-','-','visitama@gmail.com','BCA','12092389201','Riyan',NULL);
insert  into `supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telp_supplier`,`fax_supplier`,`email_supplier`,`bank`,`rekening`,`atas_nama`,`cabang`) values (5,'SP-00003','CV. Karunia Jaya Perkasa','Banyuwangi','-','-','kperkasa@gmail.com','BCA','1209889201','Sinta',NULL);
insert  into `supplier`(`id_supplier`,`kode_supplier`,`nama_supplier`,`alamat_supplier`,`telp_supplier`,`fax_supplier`,`email_supplier`,`bank`,`rekening`,`atas_nama`,`cabang`) values (33,'SP-00004','CV. Jaya Makmur','Bangorejo','082716273821','-','jayamakmur@gmail.com','BNI','8938203842','Ridwan',NULL);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `password` varchar(225) DEFAULT NULL,
  `tipe` varchar(30) DEFAULT NULL,
  `alamat_user` varchar(100) DEFAULT NULL,
  `telp_user` varchar(15) DEFAULT NULL,
  `email_user` varchar(50) DEFAULT NULL,
  `is_active` int(11) DEFAULT NULL,
  `cabang` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `user` */

insert  into `user`(`id_user`,`username`,`nama_lengkap`,`password`,`tipe`,`alamat_user`,`telp_user`,`email_user`,`is_active`,`cabang`) values (1,'admin','Administrator','$2y$10$oagi0l6Q3v.bwPCCVgOQXOnWX1FPLAvIiIfMJwIrJjk4212ACLN7.','Administrator','Banyuwagi','085647382748','admin@gmail.com',1,NULL);
insert  into `user`(`id_user`,`username`,`nama_lengkap`,`password`,`tipe`,`alamat_user`,`telp_user`,`email_user`,`is_active`,`cabang`) values (3,'kasir','Kasir','$2y$10$nWBEdyFeReNQtbr4lGUWmuN9SXKRtpqdog2CtXPFcmqCzb6p5Bmp6','Kasir','Banyuwangi','082236578566','kasir@gmail.com',1,NULL);

/*Table structure for table `user_log` */

DROP TABLE IF EXISTS `user_log`;

CREATE TABLE `user_log` (
  `id_log` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `login` datetime DEFAULT NULL,
  `logout` datetime DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `ID_USER` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

/*Data for the table `user_log` */

insert  into `user_log`(`id_log`,`id_user`,`login`,`logout`) values (47,1,'2022-07-17 20:35:37',NULL);
insert  into `user_log`(`id_log`,`id_user`,`login`,`logout`) values (48,1,'2022-07-17 20:42:19',NULL);
insert  into `user_log`(`id_log`,`id_user`,`login`,`logout`) values (49,1,'2022-07-20 07:38:46',NULL);
insert  into `user_log`(`id_log`,`id_user`,`login`,`logout`) values (50,1,'2022-07-23 12:01:27',NULL);
insert  into `user_log`(`id_log`,`id_user`,`login`,`logout`) values (51,1,'2022-07-23 12:06:23',NULL);
insert  into `user_log`(`id_log`,`id_user`,`login`,`logout`) values (52,1,'2022-07-23 16:27:49',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
