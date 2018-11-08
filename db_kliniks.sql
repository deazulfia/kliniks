-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2018 at 10:47 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kliniks`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(15) NOT NULL,
  `judul_berita` varchar(150) NOT NULL,
  `isi_berita` text NOT NULL,
  `image_berita` varchar(50) NOT NULL,
  `tanggal_berita` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bhp`
--

CREATE TABLE `bhp` (
  `id_bhp` int(30) NOT NULL,
  `nama_bhp` varchar(255) NOT NULL,
  `jumlah_bhp` int(10) NOT NULL,
  `harga_bhp` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `diagnosa`
--

CREATE TABLE `diagnosa` (
  `no_pendaftaran` int(11) NOT NULL,
  `id_pasien` int(30) NOT NULL,
  `diagnosa` text NOT NULL,
  `nama_obat` varchar(255) NOT NULL,
  `tanggal_periksa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` int(30) NOT NULL,
  `sip` int(15) NOT NULL,
  `nama_dokter` varchar(255) NOT NULL,
  `spesialis` varchar(255) NOT NULL,
  `active` enum('tidak aktif','aktif') NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `logistik`
--

CREATE TABLE `logistik` (
  `id_log` int(30) NOT NULL,
  `max_stok` int(10) NOT NULL,
  `stok_awal` int(10) NOT NULL,
  `stok_akhir` int(10) NOT NULL,
  `min_stok` int(10) NOT NULL,
  `repurchase` int(10) NOT NULL,
  `keluar` int(10) NOT NULL,
  `masuk` int(10) NOT NULL,
  `id_obat` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `master_tindakan`
--

CREATE TABLE `master_tindakan` (
  `tindakan_id` int(10) NOT NULL,
  `kode_tindakan` varchar(50) NOT NULL,
  `nama_tindakan` text NOT NULL,
  `biaya` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id_obat` int(30) NOT NULL,
  `kode_obat` int(30) NOT NULL,
  `nama_obat` varchar(60) NOT NULL,
  `total_stok` mediumint(1) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `exp_date` date NOT NULL,
  `id_kategori_barang` mediumint(1) NOT NULL,
  `id_merk_barang` mediumint(1) NOT NULL,
  `keterangan` text NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` mediumint(1) NOT NULL,
  `no_rm` varchar(255) NOT NULL,
  `no_ktp_pasien` varchar(30) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `tempat_lahir_pasien` varchar(255) NOT NULL,
  `tanggal_lahir_pasien` date NOT NULL,
  `jk_pasien` enum('laki-laki','perempuan') NOT NULL,
  `umur_pasien` int(11) NOT NULL,
  `goldar_pasien` enum('a','b','o','ab') NOT NULL,
  `telp` varchar(15) NOT NULL,
  `riwayat_alergi` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL,
  `keterangan` enum('karyawan','tamu') NOT NULL,
  `id_resep` int(30) NOT NULL,
  `id_rekam_medis` int(30) NOT NULL,
  `alamat` text NOT NULL,
  `info_tambahan` text NOT NULL,
  `kode_unik` varchar(30) NOT NULL,
  `waktu_input` datetime NOT NULL,
  `tampil` tinyint(1) NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(30) NOT NULL,
  `potongan_harga` int(255) NOT NULL,
  `total_pembayaran` int(255) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `id_tindakan` int(30) NOT NULL,
  `id_pasien` int(30) NOT NULL,
  `id_dokter` int(30) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksaan`
--

CREATE TABLE `pemeriksaan` (
  `id_pemeriksaan` int(15) NOT NULL,
  `nama_depan` varchar(50) NOT NULL,
  `nama_belakang` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `no_tlpn` varchar(20) NOT NULL,
  `tgl_pemeriksaan` datetime NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` mediumint(1) NOT NULL,
  `no_pendaftaran` varchar(25) NOT NULL,
  `keluhan` text NOT NULL,
  `tanggal_pendaftaran` date NOT NULL,
  `waktu_pendaftaran` time NOT NULL,
  `id_pasien` mediumint(1) NOT NULL,
  `no_rm` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_akses`
--

CREATE TABLE `pj_akses` (
  `id_akses` tinyint(1) UNSIGNED NOT NULL,
  `label` varchar(15) NOT NULL,
  `level_akses` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_akses`
--

INSERT INTO `pj_akses` (`id_akses`, `label`, `level_akses`) VALUES
(1, 'admin', 'Administrator'),
(2, 'kasir', 'Staff Kasir'),
(3, 'inventory', 'Staff Inventory'),
(4, 'keuangan', 'Staff Keuangan'),
(5, 'dokter', 'Dokter'),
(6, 'konten', 'konten'),
(7, 'marketing', 'Staff Marketing'),
(8, 'resepsionis', 'Resepsionis');

-- --------------------------------------------------------

--
-- Table structure for table `pj_ci_sessions`
--

CREATE TABLE `pj_ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_ci_sessions`
--

INSERT INTO `pj_ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('375a5a464d62594a4f94ebeace8a748684033432', '192.168.88.111', 1533540817, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534303534323b61705f69645f757365727c733a323a223137223b61705f70617373776f72647c733a34303a2238363931653466633533623939646135343463653836653232616362613632643133333532656666223b61705f6e616d617c733a31323a22506970657220526f6e696b61223b61705f6c6576656c7c733a353a226b61736972223b61705f6c6576656c5f63617074696f6e7c733a31313a225374616666204b61736972223b),
('55fe71573e2d772028dfde614c1f02e233883fb0', '192.168.88.111', 1533541098, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534303834393b61705f69645f757365727c733a323a223137223b61705f70617373776f72647c733a34303a2238363931653466633533623939646135343463653836653232616362613632643133333532656666223b61705f6e616d617c733a31323a22506970657220526f6e696b61223b61705f6c6576656c7c733a353a226b61736972223b61705f6c6576656c5f63617074696f6e7c733a31313a225374616666204b61736972223b),
('179a1d451bf28cdc555b8fedd4e3a065af9508c6', '192.168.88.111', 1533541683, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534313335393b61705f69645f757365727c733a323a223137223b61705f70617373776f72647c733a34303a2238363931653466633533623939646135343463653836653232616362613632643133333532656666223b61705f6e616d617c733a31323a22506970657220526f6e696b61223b61705f6c6576656c7c733a353a226b61736972223b61705f6c6576656c5f63617074696f6e7c733a31313a225374616666204b61736972223b),
('6fde48c88ab4a0c6863788b3c5e04953bd77e140', '192.168.88.111', 1533541966, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534313639313b61705f69645f757365727c733a323a223135223b61705f70617373776f72647c733a34303a2231333862633366663636303531663465643133316564616539616433323266323635376164663537223b61705f6e616d617c733a31323a224c656f20486173696275616e223b61705f6c6576656c7c733a363a22646f6b746572223b61705f6c6576656c5f63617074696f6e7c733a363a22446f6b746572223b),
('6681858581fa0ad4b9a225cd80b583a5e8d966d7', '192.168.88.111', 1533542198, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534323033333b61705f69645f757365727c733a323a223137223b61705f70617373776f72647c733a34303a2238363931653466633533623939646135343463653836653232616362613632643133333532656666223b61705f6e616d617c733a31323a22506970657220526f6e696b61223b61705f6c6576656c7c733a353a226b61736972223b61705f6c6576656c5f63617074696f6e7c733a31313a225374616666204b61736972223b),
('dde080e92f04f8a8548f84d523f6b16ebf4f936d', '192.168.88.111', 1533542913, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534323630383b61705f69645f757365727c733a313a2231223b61705f70617373776f72647c733a34303a2264303333653232616533343861656235363630666332313430616563333538353063346461393937223b61705f6e616d617c733a353a2261646d696e223b61705f6c6576656c7c733a353a2261646d696e223b61705f6c6576656c5f63617074696f6e7c733a31333a2241646d696e6973747261746f72223b),
('7a99ed9918915fadcdfb2ef7972ea7309ec5e35e', '192.168.88.111', 1533543232, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534323931353b61705f69645f757365727c733a313a2231223b61705f70617373776f72647c733a34303a2264303333653232616533343861656235363630666332313430616563333538353063346461393937223b61705f6e616d617c733a353a2261646d696e223b61705f6c6576656c7c733a353a2261646d696e223b61705f6c6576656c5f63617074696f6e7c733a31333a2241646d696e6973747261746f72223b),
('7a939af6c6c8f67a6cea10f1bbc9332db8c00eed', '192.168.88.111', 1533543347, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534333233363b61705f69645f757365727c733a323a223131223b61705f70617373776f72647c733a34303a2239643238373861626464353034643136666536323632663137633830646165356365633334343430223b61705f6e616d617c733a363a22646f6b746572223b61705f6c6576656c7c733a363a22646f6b746572223b61705f6c6576656c5f63617074696f6e7c733a363a22446f6b746572223b),
('a4d15266a1566f3fb451329ed36c5bfe3f8ab93b', '192.168.88.111', 1533543921, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534333634363b61705f69645f757365727c733a323a223137223b61705f70617373776f72647c733a34303a2238363931653466633533623939646135343463653836653232616362613632643133333532656666223b61705f6e616d617c733a31323a22506970657220526f6e696b61223b61705f6c6576656c7c733a353a226b61736972223b61705f6c6576656c5f63617074696f6e7c733a31313a225374616666204b61736972223b),
('dba88b2d84ebe2c2bb83fc75e02e60be1f9da0e3', '192.168.88.111', 1533544119, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534343035343b61705f69645f757365727c733a323a223137223b61705f70617373776f72647c733a34303a2238363931653466633533623939646135343463653836653232616362613632643133333532656666223b61705f6e616d617c733a31323a22506970657220526f6e696b61223b61705f6c6576656c7c733a353a226b61736972223b61705f6c6576656c5f63617074696f6e7c733a31313a225374616666204b61736972223b),
('8a57d4da2cf8e94e4abab347caa5c3f63f11243e', '192.168.88.111', 1533544403, 0x5f5f63695f6c6173745f726567656e65726174657c693a313533333534343339393b);

-- --------------------------------------------------------

--
-- Table structure for table `pj_kategori_barang`
--

CREATE TABLE `pj_kategori_barang` (
  `id_kategori_barang` mediumint(1) UNSIGNED NOT NULL,
  `kategori` varchar(40) NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_merk_barang`
--

CREATE TABLE `pj_merk_barang` (
  `id_merk_barang` mediumint(1) UNSIGNED NOT NULL,
  `merk` varchar(40) NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_pelanggan`
--

CREATE TABLE `pj_pelanggan` (
  `id_pelanggan` mediumint(1) UNSIGNED NOT NULL,
  `nama` varchar(40) NOT NULL,
  `alamat` text,
  `telp` varchar(40) DEFAULT NULL,
  `info_tambahan` text,
  `kode_unik` varchar(30) NOT NULL,
  `waktu_input` datetime NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_penjualan_detail`
--

CREATE TABLE `pj_penjualan_detail` (
  `id_penjualan_d` int(1) UNSIGNED NOT NULL,
  `id_penjualan_m` int(1) UNSIGNED NOT NULL,
  `id_obat` int(30) NOT NULL,
  `jumlah_beli` smallint(1) UNSIGNED NOT NULL,
  `harga_satuan` decimal(10,0) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_penjualan_master`
--

CREATE TABLE `pj_penjualan_master` (
  `id_penjualan_m` int(1) UNSIGNED NOT NULL,
  `nomor_nota` varchar(40) NOT NULL,
  `tanggal` datetime NOT NULL,
  `grand_total` decimal(10,0) NOT NULL,
  `pajak` decimal(10,0) NOT NULL,
  `bayar` decimal(10,0) NOT NULL,
  `keterangan_lain` text,
  `no_pendaftaran` text NOT NULL,
  `id_pasien` mediumint(1) NOT NULL,
  `id_user` mediumint(1) UNSIGNED NOT NULL,
  `id_dokter` mediumint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pj_user`
--

CREATE TABLE `pj_user` (
  `id_user` mediumint(1) UNSIGNED NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(60) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `id_akses` tinyint(1) UNSIGNED NOT NULL,
  `status` enum('Aktif','Non Aktif') NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pj_user`
--

INSERT INTO `pj_user` (`id_user`, `username`, `password`, `nama`, `id_akses`, `status`, `dihapus`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', 1, 'Aktif', 'tidak'),
(16, 'piper', '5c4ed7751ffe32c903ca9e8c7eee49ba66e4336b', 'Piper Ronika', 8, 'Aktif', 'ya'),
(14, 'marketing', 'a286075043d42dcdce8d6668944e827f7a64024f', 'Staff marketing', 7, 'Aktif', 'tidak'),
(13, 'dokters', '2fdab6412c90c6e4fc2d27dec88f12a8f2a8a399', 'dokter', 5, 'Aktif', 'ya'),
(12, 'konten', 'ecf8a4f59d8e2a2c283d1a3d93ab9c16410aa771', 'konten', 6, 'Aktif', 'tidak'),
(11, 'dokter', '9d2878abdd504d16fe6262f17c80dae5cec34440', 'dokter', 5, 'Aktif', 'tidak'),
(9, 'inventory', 'ec99b813fa064f7f7cfa1d35bc7cc3d743c61fd1', 'Staff Inventory', 3, 'Aktif', 'tidak'),
(10, 'keuangan', '1f931595786f2f178358d0af5fe4d75eaee46819', 'Staff Keuangan', 4, 'Aktif', 'tidak'),
(15, 'leo', '138bc3ff66051f4ed131edae9ad322f2657adf57', 'Leo Hasibuan', 5, 'Aktif', 'tidak'),
(17, 'kasir', '8691e4fc53b99da544ce86e22acba62d13352eff', 'Piper Ronika', 2, 'Aktif', 'tidak');

-- --------------------------------------------------------

--
-- Table structure for table `rekam_medis`
--

CREATE TABLE `rekam_medis` (
  `id_rekam_medis` int(30) NOT NULL,
  `tekanan_darah` varchar(10) NOT NULL,
  `suhu` varchar(10) NOT NULL,
  `denyut_nadi` varchar(10) NOT NULL,
  `keluhan` text NOT NULL,
  `diagnosa` text NOT NULL,
  `saran_tindakan` text NOT NULL,
  `id_resep` int(30) NOT NULL,
  `id_pasien` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE `resep` (
  `id_resep` int(30) NOT NULL,
  `keterangan` text NOT NULL,
  `nama_obat` text NOT NULL,
  `jumlah_obat` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `tindakan` text NOT NULL,
  `id_pasien` int(30) NOT NULL,
  `id_dokter` int(30) NOT NULL,
  `id_rekam_medis` int(30) NOT NULL,
  `id_obat` int(30) NOT NULL,
  `id_pendaftaran` mediumint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tindakan`
--

CREATE TABLE `tindakan` (
  `no_pendaftaran` varchar(20) NOT NULL,
  `id_pasien` mediumint(1) NOT NULL,
  `tindakan` varchar(50) NOT NULL,
  `tanggal_periksa` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tindakan_medis`
--

CREATE TABLE `tindakan_medis` (
  `id_tindakan` int(30) NOT NULL,
  `nama_tindakan` varchar(255) NOT NULL,
  `harga_tindakan` decimal(10,0) NOT NULL,
  `rincian_tindakan` text NOT NULL,
  `dihapus` enum('tidak','ya') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `level` enum('manager','karyawan','admin','bod','dokter','spv','accounting','','') DEFAULT NULL,
  `active` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `bhp`
--
ALTER TABLE `bhp`
  ADD PRIMARY KEY (`id_bhp`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `logistik`
--
ALTER TABLE `logistik`
  ADD PRIMARY KEY (`id_log`);

--
-- Indexes for table `master_tindakan`
--
ALTER TABLE `master_tindakan`
  ADD PRIMARY KEY (`tindakan_id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id_obat`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  ADD PRIMARY KEY (`id_pemeriksaan`);

--
-- Indexes for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`);

--
-- Indexes for table `pj_akses`
--
ALTER TABLE `pj_akses`
  ADD PRIMARY KEY (`id_akses`);

--
-- Indexes for table `pj_ci_sessions`
--
ALTER TABLE `pj_ci_sessions`
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `pj_kategori_barang`
--
ALTER TABLE `pj_kategori_barang`
  ADD PRIMARY KEY (`id_kategori_barang`);

--
-- Indexes for table `pj_merk_barang`
--
ALTER TABLE `pj_merk_barang`
  ADD PRIMARY KEY (`id_merk_barang`);

--
-- Indexes for table `pj_pelanggan`
--
ALTER TABLE `pj_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pj_penjualan_detail`
--
ALTER TABLE `pj_penjualan_detail`
  ADD PRIMARY KEY (`id_penjualan_d`);

--
-- Indexes for table `pj_penjualan_master`
--
ALTER TABLE `pj_penjualan_master`
  ADD PRIMARY KEY (`id_penjualan_m`);

--
-- Indexes for table `pj_user`
--
ALTER TABLE `pj_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  ADD PRIMARY KEY (`id_rekam_medis`);

--
-- Indexes for table `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id_resep`);

--
-- Indexes for table `tindakan_medis`
--
ALTER TABLE `tindakan_medis`
  ADD PRIMARY KEY (`id_tindakan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bhp`
--
ALTER TABLE `bhp`
  MODIFY `id_bhp` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id_dokter` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `logistik`
--
ALTER TABLE `logistik`
  MODIFY `id_log` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_tindakan`
--
ALTER TABLE `master_tindakan`
  MODIFY `tindakan_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id_obat` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` mediumint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemeriksaan`
--
ALTER TABLE `pemeriksaan`
  MODIFY `id_pemeriksaan` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` mediumint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pj_akses`
--
ALTER TABLE `pj_akses`
  MODIFY `id_akses` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pj_kategori_barang`
--
ALTER TABLE `pj_kategori_barang`
  MODIFY `id_kategori_barang` mediumint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `pj_merk_barang`
--
ALTER TABLE `pj_merk_barang`
  MODIFY `id_merk_barang` mediumint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `pj_pelanggan`
--
ALTER TABLE `pj_pelanggan`
  MODIFY `id_pelanggan` mediumint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pj_penjualan_detail`
--
ALTER TABLE `pj_penjualan_detail`
  MODIFY `id_penjualan_d` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=172;

--
-- AUTO_INCREMENT for table `pj_penjualan_master`
--
ALTER TABLE `pj_penjualan_master`
  MODIFY `id_penjualan_m` int(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT for table `pj_user`
--
ALTER TABLE `pj_user`
  MODIFY `id_user` mediumint(1) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `rekam_medis`
--
ALTER TABLE `rekam_medis`
  MODIFY `id_rekam_medis` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `id_resep` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tindakan_medis`
--
ALTER TABLE `tindakan_medis`
  MODIFY `id_tindakan` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
