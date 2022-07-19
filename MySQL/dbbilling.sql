-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2022 at 11:25 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbbilling`
--

-- --------------------------------------------------------

--
-- Table structure for table `dana_mitra`
--

CREATE TABLE `dana_mitra` (
  `id_dana_mitra` varchar(10) NOT NULL,
  `id_transaksi` varchar(15) NOT NULL,
  `id_detail_bagi_hasil` varchar(10) NOT NULL,
  `hasil_dana_mitra` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `desa`
--

CREATE TABLE `desa` (
  `id_desa` varchar(10) NOT NULL,
  `id_kecamatan` varchar(10) NOT NULL,
  `nama_desa` varchar(150) NOT NULL,
  `kode_pos` int(6) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `desa`
--

INSERT INTO `desa` (`id_desa`, `id_kecamatan`, `nama_desa`, `kode_pos`, `status`) VALUES
('DES001', 'KEC001', 'Karanganyar', 67291, 'a'),
('DES002', 'KEC001', 'Alas Tengah', 67291, 'a'),
('DES003', 'KEC001', 'Bhinor', 67291, 'a'),
('DES004', 'KEC001', 'Jabung Wetan', 67291, 'a'),
('DES005', 'KEC001', 'Jabung Candi', 67291, 'a'),
('DES006', 'KEC001', 'Jabung Sisir', 67291, 'a'),
('DES007', 'KEC001', 'Kalikajar Kulon', 67291, 'a'),
('DES008', 'KEC001', 'Kalikajar Wetan', 67291, 'a'),
('DES009', 'KEC001', 'Paiton', 67291, 'a'),
('DES010', 'KEC001', 'Pandean', 67291, 'a'),
('DES011', 'KEC001', 'Patunjungan', 67291, 'a'),
('DES012', 'KEC001', 'Plampang', 67291, 'a'),
('DES013', 'KEC001', 'Pondok Kelor', 67291, 'a'),
('DES014', 'KEC001', 'Randu Merak', 67291, 'a'),
('DES015', 'KEC001', 'Randu Tatah', 67291, 'a'),
('DES016', 'KEC001', 'Sidodadi', 67291, 'a'),
('DES017', 'KEC001', 'Sukodadi', 67291, 'a'),
('DES018', 'KEC001', 'Sumberanyar', 67291, 'a'),
('DES019', 'KEC001', 'Sumberejo', 67291, 'a'),
('DES020', 'KEC001', 'Taman', 67291, 'a'),
('DES021', 'KEC002', 'Alassumur Kulon', 67291, 'a'),
('DES022', 'KEC002', 'Asembagus', 67282, 'a'),
('DES023', 'KEC002', 'Asembakor', 67282, 'a'),
('DES024', 'KEC002', 'Bulu', 67282, 'a'),
('DES025', 'KEC002', 'Kalibuntu', 67282, 'a'),
('DES026', 'KEC002', 'Kandang Jati Kulon', 67282, 'a'),
('DES027', 'KEC002', 'Kandang Jati Wetan', 67282, 'a'),
('DES028', 'KEC002', 'Kebonagung', 67282, 'a'),
('DES029', 'KEC002', 'Kraksaan Wetan', 67282, 'a'),
('DES030', 'KEC002', 'Keregenan', 67282, 'a'),
('DES031', 'KEC002', 'Patokan', 67282, 'a'),
('DES032', 'KEC002', 'Rangang', 67282, 'a'),
('DES033', 'KEC002', 'Rondokuning', 67282, 'a'),
('DES034', 'KEC002', 'Semampir', 67282, 'a'),
('DES035', 'KEC002', 'Sidomukti', 67282, 'a'),
('DES036', 'KEC002', 'Sidopekso', 67282, 'a'),
('DES037', 'KEC002', 'Sumberlele', 67282, 'a'),
('DES038', 'KEC002', 'Taman Sari', 67282, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `detail_bagi_hasil`
--

CREATE TABLE `detail_bagi_hasil` (
  `id_detail_bagi_hasil` varchar(10) NOT NULL,
  `id_mitra` varchar(10) NOT NULL,
  `id_pengaturan_bagi_hasil` varchar(10) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `detail_jabatan`
--

CREATE TABLE `detail_jabatan` (
  `id_detail_jabatan` varchar(10) NOT NULL,
  `id_jenis_jabatan` varchar(10) NOT NULL,
  `id_petugas` varchar(10) NOT NULL,
  `status` enum('a','n') NOT NULL,
  `tanggal_jabatan` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_jabatan`
--

INSERT INTO `detail_jabatan` (`id_detail_jabatan`, `id_jenis_jabatan`, `id_petugas`, `status`, `tanggal_jabatan`) VALUES
('DJ0001', 'JJ003', 'PTS001', 'n', '2022-07-03'),
('DJ0002', 'JJ001', 'PTS001', 'n', '2022-07-04'),
('DJ0003', 'JJ002', 'PTS002', 'n', '2022-07-04'),
('DJ0004', 'JJ004', 'PTS002', 'a', '2022-07-05'),
('DJ0005', 'JJ003', 'PTS001', 'n', '2022-07-05'),
('DJ0006', 'JJ001', 'PTS001', 'a', '2022-07-05');

-- --------------------------------------------------------

--
-- Table structure for table `detail_langganan`
--

CREATE TABLE `detail_langganan` (
  `id_detail_langganan` varchar(10) NOT NULL,
  `id_langganan` varchar(10) NOT NULL,
  `id_jenis_langganan` varchar(10) NOT NULL,
  `tanggal_mulai` varchar(10) DEFAULT NULL,
  `tanggal_kadaluarsa` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `sisa_tagihan` int(3) NOT NULL,
  `status` enum('a','n') NOT NULL,
  `status_pembayaran` enum('l','bl') NOT NULL DEFAULT 'bl'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_langganan`
--

INSERT INTO `detail_langganan` (`id_detail_langganan`, `id_langganan`, `id_jenis_langganan`, `tanggal_mulai`, `tanggal_kadaluarsa`, `tanggal_selesai`, `sisa_tagihan`, `status`, `status_pembayaran`) VALUES
('DL00001', 'L00001', 'JL002', NULL, NULL, NULL, 6, 'a', 'bl'),
('DL00002', 'L00002', 'JL001', NULL, NULL, NULL, 0, 'n', 'l'),
('DL00003', 'L00002', 'JL003', NULL, NULL, NULL, 8, 'a', 'bl');

-- --------------------------------------------------------

--
-- Table structure for table `detail_mitra_pelanggan`
--

CREATE TABLE `detail_mitra_pelanggan` (
  `id_detail_mitra_pelanggan` varchar(10) NOT NULL,
  `id_mitra` varchar(10) NOT NULL,
  `id_pelanggan` varchar(10) CHARACTER SET utf8 NOT NULL,
  `status` enum('a','n') NOT NULL,
  `tanggal_masuk` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_mitra_pelanggan`
--

INSERT INTO `detail_mitra_pelanggan` (`id_detail_mitra_pelanggan`, `id_mitra`, `id_pelanggan`, `status`, `tanggal_masuk`) VALUES
('DMP00001', 'M00001', 'PL00001', 'a', '2022-07-02'),
('DMP00002', 'M00001', 'PL00002', 'a', '2022-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail_transaksi` varchar(10) NOT NULL,
  `id_transaksi` varchar(15) NOT NULL,
  `id_jenis_pembayaran` varchar(10) NOT NULL,
  `tanggungan` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_mitra`
--

CREATE TABLE `dokumen_mitra` (
  `id_dokumen_mitra` varchar(10) NOT NULL,
  `id_jenis_dokumen` varchar(10) CHARACTER SET utf8 NOT NULL,
  `id_mitra` varchar(10) NOT NULL,
  `path_dokumen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokumen_mitra`
--

INSERT INTO `dokumen_mitra` (`id_dokumen_mitra`, `id_jenis_dokumen`, `id_mitra`, `path_dokumen`) VALUES
('DM00001', 'JD003', 'M00001', '/storage/document/mitra/document-qiqQn1656772977.pdf'),
('DM00002', 'JD005', 'M00001', '/storage/document/mitra/document-Mj8Tf1656772977.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_pelanggan`
--

CREATE TABLE `dokumen_pelanggan` (
  `id_dokumen_pelanggan` varchar(10) NOT NULL,
  `id_pelanggan` varchar(10) NOT NULL,
  `id_jenis_dokumen` varchar(10) NOT NULL,
  `path_dokumen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dokumen_pelanggan`
--

INSERT INTO `dokumen_pelanggan` (`id_dokumen_pelanggan`, `id_pelanggan`, `id_jenis_dokumen`, `path_dokumen`) VALUES
('DP00001', 'PL00001', 'JD001', '/storage/document/pelanggan/document-hxhlx1656557635.pdf'),
('DP00002', 'PL00001', 'JD002', '/storage/document/pelanggan/document-gYfe81656557671.pdf'),
('DP00003', 'PL00002', 'JD001', '/storage/document/pelanggan/document-B5Q041656534649.jpg'),
('DP00004', 'PL00002', 'JD002', '/storage/document/pelanggan/document-GXc6v1656534649.jpg'),
('DP00005', 'PL00003', 'JD001', '/storage/document/pelanggan/document-tMvhN1656557364.jpg'),
('DP00006', 'PL00003', 'JD002', '/storage/document/pelanggan/document-brLmG1656557471.png'),
('DP00007', 'PL00003', 'JD004', '/storage/document/pelanggan/document-sEVX71656557558.jpg'),
('DP00008', 'PL00001', 'JD004', '/storage/document/pelanggan/document-fq2nt1656557698.docx'),
('DP00009', 'PL00002', 'JD004', '/storage/document/pelanggan/document-TgzMq1656557801.pdf'),
('DP00010', 'PL00004', 'JD001', '/storage/document/pelanggan/document-EnoNg1658033520.jpg'),
('DP00011', 'PL00004', 'JD002', '/storage/document/pelanggan/document-67EZG1658031564.jpg'),
('DP00012', 'PL00004', 'JD001', '/storage/document/pelanggan/document-2dUSb1658032590.jpg'),
('DP00013', 'PL00004', 'JD002', '/storage/document/pelanggan/document-KTifn1658032590.jpg'),
('DP00014', 'PL00004', 'JD006', '/storage/document/pelanggan/document-4wDdY1658033583.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dokumen`
--

CREATE TABLE `jenis_dokumen` (
  `id_jenis_dokumen` varchar(10) NOT NULL,
  `nama_dokumen` varchar(200) NOT NULL,
  `status` enum('a','n') NOT NULL,
  `status_dokumen` enum('p','m') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jenis_dokumen`
--

INSERT INTO `jenis_dokumen` (`id_jenis_dokumen`, `nama_dokumen`, `status`, `status_dokumen`) VALUES
('JD001', 'Foto KTP', 'a', 'p'),
('JD002', 'Foto KTP Bersama Pelanggan', 'a', 'p'),
('JD003', 'Foto Penghasilan per Bulan', 'a', 'm'),
('JD004', 'Foto Kode PLN', 'a', 'm'),
('JD005', 'Dokumen Pekerjaan', 'a', 'm'),
('JD006', 'Test', 'a', 'p');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_jabatan`
--

CREATE TABLE `jenis_jabatan` (
  `id_jenis_jabatan` varchar(10) NOT NULL,
  `nama_jabatan` varchar(150) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_jabatan`
--

INSERT INTO `jenis_jabatan` (`id_jenis_jabatan`, `nama_jabatan`, `status`) VALUES
('JJ001', 'superadmin', 'a'),
('JJ002', 'billing', 'a'),
('JJ003', 'sales', 'a'),
('JJ004', 'customer service', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_langganan`
--

CREATE TABLE `jenis_langganan` (
  `id_jenis_langganan` varchar(10) NOT NULL,
  `lama_berlangganan` varchar(100) NOT NULL,
  `banyak_tagihan` int(3) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_langganan`
--

INSERT INTO `jenis_langganan` (`id_jenis_langganan`, `lama_berlangganan`, `banyak_tagihan`, `status`) VALUES
('JL001', 'Tidak Berlangganan', 1, 'a'),
('JL002', '6 Bulan', 6, 'a'),
('JL003', '8 Bulan', 8, 'a'),
('JL004', '1 Tahun', 12, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pembayaran`
--

CREATE TABLE `jenis_pembayaran` (
  `id_jenis_pembayaran` varchar(10) NOT NULL,
  `jenis_pembayaran` varchar(150) NOT NULL,
  `harga` double NOT NULL,
  `jenis_biaya` enum('f','p') NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jenis_pembayaran`
--

INSERT INTO `jenis_pembayaran` (`id_jenis_pembayaran`, `jenis_pembayaran`, `harga`, `jenis_biaya`, `status`) VALUES
('JP001', 'Biaya Pemasangan Instalasi', 120000, 'f', 'a'),
('JP002', 'PPn', 10, 'p', 'a'),
('JP003', 'Test Jenis Pembayaran', 10000, 'f', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `kabupaten`
--

CREATE TABLE `kabupaten` (
  `id_kabupaten` varchar(10) NOT NULL,
  `id_provinsi` varchar(10) NOT NULL,
  `nama_kabupaten` varchar(150) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kabupaten`
--

INSERT INTO `kabupaten` (`id_kabupaten`, `id_provinsi`, `nama_kabupaten`, `status`) VALUES
('KAB001', 'PROV001', 'Probolinggo', 'a'),
('KAB002', 'PROV001', 'Situbondo', 'a'),
('KAB003', 'PROV001', 'Pasuruan', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` varchar(10) NOT NULL,
  `nama_kategori` varchar(150) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `status`) VALUES
('K001', 'Home', 'a'),
('K002', 'Premium', 'a'),
('K003', 'Business', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kecamatan` varchar(10) NOT NULL,
  `id_kabupaten` varchar(10) NOT NULL,
  `nama_kecamatan` varchar(150) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`, `id_kabupaten`, `nama_kecamatan`, `status`) VALUES
('KEC001', 'KAB001', 'Paiton', 'a'),
('KEC002', 'KAB001', 'Kraksaan', 'a'),
('KEC003', 'KAB002', 'Besuki', 'a'),
('KEC004', 'KAB002', 'Melandingan', 'a'),
('KEC005', 'KAB003', 'Bugul Kidul', 'a'),
('KEC006', 'KAB003', 'Rejoso', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `langganan`
--

CREATE TABLE `langganan` (
  `id_langganan` varchar(10) NOT NULL,
  `id_produk` varchar(10) CHARACTER SET utf8 NOT NULL,
  `id_pelanggan` varchar(10) CHARACTER SET utf8 NOT NULL,
  `kode_langganan` varchar(45) NOT NULL,
  `alamat_pemasangan` text DEFAULT NULL,
  `id_desa` varchar(10) CHARACTER SET utf8 NOT NULL,
  `rt` int(3) DEFAULT NULL,
  `rw` int(3) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `tanggal_verifikasi` date DEFAULT NULL,
  `tanggal_instalasi` date DEFAULT NULL,
  `status` enum('pn','dt','a','n') NOT NULL,
  `histori` text NOT NULL,
  `pesan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `langganan`
--

INSERT INTO `langganan` (`id_langganan`, `id_produk`, `id_pelanggan`, `kode_langganan`, `alamat_pemasangan`, `id_desa`, `rt`, `rw`, `latitude`, `longitude`, `tanggal_verifikasi`, `tanggal_instalasi`, `status`, `histori`, `pesan`) VALUES
('L00001', 'P001', 'PL00001', 'Z6RB5UArysiMDZI', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, quam!', 'DES001', 3, 1, '-7.74416163', '113.21582794', '2022-07-10', NULL, 'a', 'Terdaftar|Diterima|Melakukan Pembayaran', 'Selamat! Pengajuan anda telah diterima.'),
('L00002', 'P010', 'PL00003', 'PKDAGICI0CKJMQO', 'Pertamina Spbu Randu Pangger\r\n66PH+79R\r\nSukoharjo\r\nMayangan\r\nProbolinggo City, East Java 67215, Indonesia', 'DES006', 10, 2, '-7.76423245', '113.22835922', '2022-07-11', NULL, 'a', 'Terdaftar|Diterima|Melakukan Pembayaran', 'Selamat! Langganan anda telah didaftarkan dan disetujui.');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode_pembayaran` varchar(10) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `metode_pembayaran` enum('E Money','Bank Transfer','Direct Debit') NOT NULL,
  `via` varchar(150) DEFAULT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode_pembayaran`, `logo`, `metode_pembayaran`, `via`, `status`) VALUES
('MP0001', '/storage/bank/bca.png', 'Bank Transfer', 'bca', 'a'),
('MP0002', '/storage/bank/bni.png', 'Bank Transfer', 'bni', 'a'),
('MP0003', '/storage/bank/bri.png', 'Bank Transfer', 'bri', 'a'),
('MP0004', '/storage/bank/mandiri.png', 'Bank Transfer', 'echannel', 'a'),
('MP0005', '/storage/bank/permata.png', 'Bank Transfer', 'permata', 'a'),
('MP0006', '/storage/bank/gopay.png', 'E Money', 'gopay', 'a'),
('MP0007', '/storage/bank/bcaklikpay.png', 'Direct Debit', 'bca_klikpay', 'a'),
('MP0008', '/storage/bank/brimo.png', 'Direct Debit', 'bri_epay', 'a'),
('MP0009', '/storage/bank/danamon.png', 'Direct Debit', 'danamon_online', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mitra`
--

CREATE TABLE `mitra` (
  `id_mitra` varchar(10) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nama_mitra` varchar(150) NOT NULL,
  `jenis_kelamin` enum('l','p') NOT NULL,
  `nomor_hp` varchar(16) NOT NULL,
  `status` enum('a','n') NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_verifikasi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mitra`
--

INSERT INTO `mitra` (`id_mitra`, `foto`, `nama_mitra`, `jenis_kelamin`, `nomor_hp`, `status`, `email`, `password`, `tanggal_verifikasi`) VALUES
('M00001', '/storage/mitra/foto/fotomitra-4ILy41656772977.jpg', 'Mitra Nama', 'p', '628261787638', 'a', 'mitra@gmail.com', '$2y$10$aNsNoRByUou4zMFOY2ipoeXwIv83Far9AvOgGXyfWfrXml7MN7.gK', '2022-07-02');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` varchar(10) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `jenis_kelamin` enum('l','p') DEFAULT NULL,
  `nomor_hp` varchar(16) NOT NULL,
  `alamat` text DEFAULT NULL,
  `id_desa` varchar(10) DEFAULT NULL,
  `rt` varchar(3) DEFAULT NULL,
  `rw` varchar(3) DEFAULT NULL,
  `latitude` varchar(100) DEFAULT NULL,
  `longitude` varchar(100) DEFAULT NULL,
  `status` enum('a','n') NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL,
  `tanggal_verifikasi` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nik`, `foto`, `nama_pelanggan`, `jenis_kelamin`, `nomor_hp`, `alamat`, `id_desa`, `rt`, `rw`, `latitude`, `longitude`, `status`, `email`, `password`, `tanggal_verifikasi`) VALUES
('PL00001', '6106150412010001', '/storage/pelanggan/foto/fotopelanggan-0LCgM1656613465.jpg', 'Pelanggan 1', 'l', '6282139043512', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat, quam!', 'DES001', '001', '002', '098962398', '098962398', 'a', 'pelanggan1@example.com', '$2y$10$uRgr.Rhp6YGN2N7hvui06eD1vqNwyblPtQn411/wq1pUgt33xEEFe', NULL),
('PL00002', '6106150412010009', '/storage/pelanggan/foto/fotopelanggan-k0yUJ1656553902.jpg', 'Muhammad Nurul Hidayatullah', 'l', '6282139043511', 'Central Park Probolinggo\r\nJalan KH Mas Mansyur, Mangunharjo\r\nSukabumi\r\nKec. Mayangan\r\nKota Probolinggo, Jawa Timur 67219, Indonesia', 'DES001', '3', '2', '-7.744374252508315', '113.21231739154051', 'a', 'nurul@example.com', '$2y$10$zjxgAEOjxb0.KDmDfZPWZuDss0d/Es70vVetYZwBGTZesG8/RcnYi', NULL),
('PL00003', '6106150412010099', '/storage/pelanggan/foto/fotopelanggan-LimrY1656557443.jpg', 'Alfa Code Update', 'l', '6285158151199', 'Jalan KH Mas Mansyur, Mangunharjo\r\nSukabumi\r\nKec. Mayangan\r\nKota Probolinggo, Jawa Timur 67219, Indonesia', 'DES025', '3', '3', '-7.744161632859142', '113.21582794189453', 'a', 'alfa@example.com', '$2y$10$pJN1RvICdB4c8l4FOCPkf.KleS2Jc0VTCJcK7R1JShHIETlJBQj7y', NULL),
('PL00004', '6106150412010002', '/storage/pelanggan/foto/fotopelanggan-Gk9iZ1658024901.png', 'Test Update 5', 'p', '6282139043514', 'Desa Karanganyar Kecamatan Paiton Kabupaten Probolinggo', 'DES003', '3', '1', '-7.744161632859142', '113.21582794189453', 'a', 'alfa@email.com', '$2y$10$ykvmF0hOxHCaXxRzEYKMF.UtupVd7v80oCV7vfZRMFWr8FurXEm6W', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_bagi_hasil`
--

CREATE TABLE `pengaturan_bagi_hasil` (
  `id_pengaturan_bagi_hasil` varchar(10) NOT NULL,
  `besaran` int(6) NOT NULL,
  `status_jenis` enum('f','p') NOT NULL,
  `status` enum('a','n') NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengaturan_bagi_hasil`
--

INSERT INTO `pengaturan_bagi_hasil` (`id_pengaturan_bagi_hasil`, `besaran`, `status_jenis`, `status`, `keterangan`) VALUES
('PBH0001', 3, 'p', 'n', 'Mitra Umum'),
('PBH0002', 20000, 'f', 'a', 'Mitra Pelanggan Dekat'),
('PBH0003', 10, 'p', 'a', 'Test Pengaturan Bagi Hasil Mitra');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_pembayaran`
--

CREATE TABLE `pengaturan_pembayaran` (
  `id_pengaturan_pembayaran` varchar(10) NOT NULL,
  `server_key` varchar(255) NOT NULL,
  `client_key` varchar(255) NOT NULL,
  `charge_url` varchar(255) NOT NULL,
  `durasi_waktu` int(3) NOT NULL,
  `satuan_durasi` enum('second','minute','hour','day') NOT NULL,
  `harga_margin` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengaturan_pembayaran`
--

INSERT INTO `pengaturan_pembayaran` (`id_pengaturan_pembayaran`, `server_key`, `client_key`, `charge_url`, `durasi_waktu`, `satuan_durasi`, `harga_margin`) VALUES
('PP001', 'SB-Mid-server-05GjX4C1v6VWTy45bLo4YtAc', 'SB-Mid-client-GmZa_8UDvpdh0rwZ', 'https://api.sandbox.midtrans.com/v2/charge', 1, 'hour', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` varchar(10) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `nama_petugas` varchar(150) NOT NULL,
  `jenis_kelamin` enum('l','p') NOT NULL,
  `nomor_hp` bigint(16) UNSIGNED NOT NULL,
  `status` enum('a','n') NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `foto`, `nama_petugas`, `jenis_kelamin`, `nomor_hp`, `status`, `email`, `password`) VALUES
('PTS001', '/storage/petugas/foto/fotopetugas-eSCqf1657053372.jpg', 'Petugas Superadmin Update', 'p', 6282139043511, 'n', 'superadminupdate@example.com', '$2y$10$FQcdAFzc2hlsB9K/K2Vkr.gf7WCJ3fNal3uvJwxnL6hnwzICTaFDu'),
('PTS002', '/storage/petugas/foto/fotopetugas-EVQW61656966052.png', 'Muhammad Nurul Hidayatullah Test Nama Panjang', 'l', 628263792878, 'a', 'petugas1@example.com', '$2y$10$bur5zMC5VFcRoKOThkAFMO7nlku.j0OCZBMiySARdYXN4GTmMBffa');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` varchar(10) NOT NULL,
  `id_kategori` varchar(10) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `fitur` text NOT NULL,
  `harga` double NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `deskripsi`, `fitur`, `harga`, `status`) VALUES
('P001', 'K001', '25 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 25 Mbps|Pemasangan Instalasi|Kartu Langganan', 250000, 'a'),
('P002', 'K001', '30 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 30 Mbps|Kartu Langganan|Pemasangan Instalasi', 280000, 'a'),
('P003', 'K001', '40 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 40 Mbps|Kartu Langganan|Pemasangan Instalasi', 300000, 'a'),
('P004', 'K002', '40 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 40 Mbps|Kartu Langganan|Pemasangan Instalasi', 300000, 'a'),
('P005', 'K002', '50 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 50 Mbps|Kartu Langganan|Pemasangan Instalasi', 320000, 'a'),
('P006', 'K002', '60 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 60 Mbps|Kartu Langganan|Pemasangan Instalasi', 320000, 'a'),
('P007', 'K003', '70 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 70 Mbps|Kartu Langganan|Pemasangan Instalasi', 350000, 'a'),
('P008', 'K003', '80 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 80 Mbps|Kartu Langganan|Pemasangan Instalasi', 380000, 'a'),
('P009', 'K003', '100 Mbps', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Adipisci, quidem?', 'Internet 100 Mbps|Kartu Langganan|Pemasangan Instalasi', 400000, 'a'),
('P010', 'K003', '600 Mbps', 'Test deskripsi 600 Mbps', 'Fitur A|Fitur B|Fitur C|Fitur D|Fitur E|Fitur G|Fitur F', 1350000, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` varchar(10) NOT NULL,
  `nama_provinsi` varchar(150) NOT NULL,
  `status` enum('a','n') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `nama_provinsi`, `status`) VALUES
('PROV001', 'Jawa Timur', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(15) NOT NULL,
  `id_metode_pembayaran` varchar(10) NOT NULL,
  `id_langganan` varchar(10) NOT NULL,
  `id_petugas` varchar(10) DEFAULT NULL,
  `kode_pesanan` varchar(100) NOT NULL,
  `kode_toko` varchar(100) NOT NULL,
  `total_bayar` double NOT NULL,
  `nomor_va` int(20) NOT NULL,
  `status_transaksi` enum('settlement','expire','authorize','capture','deny','pending','cancel','refund','partial_refund','chargeback','partial_chargeback','failure') NOT NULL,
  `status_fraud` enum('challenge','accept','deny') DEFAULT NULL,
  `tanggal_transaksi` date NOT NULL DEFAULT current_timestamp(),
  `tanggal_lunas` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_metode_pembayaran`, `id_langganan`, `id_petugas`, `kode_pesanan`, `kode_toko`, `total_bayar`, `nomor_va`, `status_transaksi`, `status_fraud`, `tanggal_transaksi`, `tanggal_lunas`) VALUES
('TRX90873203', 'MP0002', 'L00001', 'PTS001', 'FHGJHKLJKHBNLKJ', 'GFHGJKJIUYGH', 400000, 222222, 'expire', 'deny', '2022-07-17', NULL),
('TRX90873204', 'MP0002', 'L00001', NULL, 'FHGJKL:IUHJB!', 'JHKLJKHJGJHK ', 400000, 222222, 'pending', 'accept', '2022-07-17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dana_mitra`
--
ALTER TABLE `dana_mitra`
  ADD PRIMARY KEY (`id_dana_mitra`),
  ADD KEY `id_detail_bagi_hasil` (`id_detail_bagi_hasil`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `desa`
--
ALTER TABLE `desa`
  ADD PRIMARY KEY (`id_desa`),
  ADD KEY `id_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `detail_bagi_hasil`
--
ALTER TABLE `detail_bagi_hasil`
  ADD PRIMARY KEY (`id_detail_bagi_hasil`),
  ADD KEY `id_mitra` (`id_mitra`),
  ADD KEY `id_pengaturan_bagi_hasil` (`id_pengaturan_bagi_hasil`);

--
-- Indexes for table `detail_jabatan`
--
ALTER TABLE `detail_jabatan`
  ADD PRIMARY KEY (`id_detail_jabatan`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_jenis_jabatan` (`id_jenis_jabatan`);

--
-- Indexes for table `detail_langganan`
--
ALTER TABLE `detail_langganan`
  ADD PRIMARY KEY (`id_detail_langganan`),
  ADD KEY `id_jenis_langganan` (`id_jenis_langganan`),
  ADD KEY `id_langganan` (`id_langganan`);

--
-- Indexes for table `detail_mitra_pelanggan`
--
ALTER TABLE `detail_mitra_pelanggan`
  ADD KEY `id_mitra` (`id_mitra`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail_transaksi`),
  ADD KEY `id_jenis_pembayaran` (`id_jenis_pembayaran`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indexes for table `dokumen_mitra`
--
ALTER TABLE `dokumen_mitra`
  ADD PRIMARY KEY (`id_dokumen_mitra`),
  ADD KEY `id_jenis_dokumen` (`id_jenis_dokumen`),
  ADD KEY `id_mitra` (`id_mitra`);

--
-- Indexes for table `dokumen_pelanggan`
--
ALTER TABLE `dokumen_pelanggan`
  ADD PRIMARY KEY (`id_dokumen_pelanggan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_jenis_dokumen` (`id_jenis_dokumen`);

--
-- Indexes for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  ADD PRIMARY KEY (`id_jenis_dokumen`);

--
-- Indexes for table `jenis_jabatan`
--
ALTER TABLE `jenis_jabatan`
  ADD PRIMARY KEY (`id_jenis_jabatan`);

--
-- Indexes for table `jenis_langganan`
--
ALTER TABLE `jenis_langganan`
  ADD PRIMARY KEY (`id_jenis_langganan`);

--
-- Indexes for table `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  ADD PRIMARY KEY (`id_jenis_pembayaran`);

--
-- Indexes for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD PRIMARY KEY (`id_kabupaten`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`),
  ADD KEY `id_kabupaten` (`id_kabupaten`);

--
-- Indexes for table `langganan`
--
ALTER TABLE `langganan`
  ADD PRIMARY KEY (`id_langganan`),
  ADD UNIQUE KEY `kode_langganan` (`kode_langganan`),
  ADD KEY `id_desa` (`id_desa`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode_pembayaran`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mitra`
--
ALTER TABLE `mitra`
  ADD PRIMARY KEY (`id_mitra`),
  ADD UNIQUE KEY `nomor_hp` (`nomor_hp`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `nomor_hp` (`nomor_hp`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_desa` (`id_desa`);

--
-- Indexes for table `pengaturan_bagi_hasil`
--
ALTER TABLE `pengaturan_bagi_hasil`
  ADD PRIMARY KEY (`id_pengaturan_bagi_hasil`);

--
-- Indexes for table `pengaturan_pembayaran`
--
ALTER TABLE `pengaturan_pembayaran`
  ADD PRIMARY KEY (`id_pengaturan_pembayaran`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nomor_hp` (`nomor_hp`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `kode_pesanan` (`kode_pesanan`),
  ADD KEY `kode_toko` (`kode_toko`),
  ADD KEY `id_metode_pembayaran` (`id_metode_pembayaran`),
  ADD KEY `id_petugas` (`id_petugas`),
  ADD KEY `id_langganan` (`id_langganan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dana_mitra`
--
ALTER TABLE `dana_mitra`
  ADD CONSTRAINT `dana_mitra_ibfk_1` FOREIGN KEY (`id_detail_bagi_hasil`) REFERENCES `detail_bagi_hasil` (`id_detail_bagi_hasil`),
  ADD CONSTRAINT `dana_mitra_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `desa`
--
ALTER TABLE `desa`
  ADD CONSTRAINT `desa_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_bagi_hasil`
--
ALTER TABLE `detail_bagi_hasil`
  ADD CONSTRAINT `detail_bagi_hasil_ibfk_1` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`),
  ADD CONSTRAINT `detail_bagi_hasil_ibfk_2` FOREIGN KEY (`id_pengaturan_bagi_hasil`) REFERENCES `pengaturan_bagi_hasil` (`id_pengaturan_bagi_hasil`);

--
-- Constraints for table `detail_jabatan`
--
ALTER TABLE `detail_jabatan`
  ADD CONSTRAINT `detail_jabatan_ibfk_1` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `detail_jabatan_ibfk_2` FOREIGN KEY (`id_jenis_jabatan`) REFERENCES `jenis_jabatan` (`id_jenis_jabatan`);

--
-- Constraints for table `detail_langganan`
--
ALTER TABLE `detail_langganan`
  ADD CONSTRAINT `detail_langganan_ibfk_1` FOREIGN KEY (`id_jenis_langganan`) REFERENCES `jenis_langganan` (`id_jenis_langganan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_langganan_ibfk_2` FOREIGN KEY (`id_langganan`) REFERENCES `langganan` (`id_langganan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_mitra_pelanggan`
--
ALTER TABLE `detail_mitra_pelanggan`
  ADD CONSTRAINT `detail_mitra_pelanggan_ibfk_1` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_mitra_pelanggan_ibfk_2` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`id_jenis_pembayaran`) REFERENCES `jenis_pembayaran` (`id_jenis_pembayaran`),
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`);

--
-- Constraints for table `dokumen_mitra`
--
ALTER TABLE `dokumen_mitra`
  ADD CONSTRAINT `dokumen_mitra_ibfk_1` FOREIGN KEY (`id_jenis_dokumen`) REFERENCES `jenis_dokumen` (`id_jenis_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dokumen_mitra_ibfk_2` FOREIGN KEY (`id_mitra`) REFERENCES `mitra` (`id_mitra`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokumen_pelanggan`
--
ALTER TABLE `dokumen_pelanggan`
  ADD CONSTRAINT `dokumen_pelanggan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dokumen_pelanggan_ibfk_2` FOREIGN KEY (`id_jenis_dokumen`) REFERENCES `jenis_dokumen` (`id_jenis_dokumen`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kabupaten`
--
ALTER TABLE `kabupaten`
  ADD CONSTRAINT `kabupaten_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`id_kabupaten`) REFERENCES `kabupaten` (`id_kabupaten`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `langganan`
--
ALTER TABLE `langganan`
  ADD CONSTRAINT `langganan_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `langganan_ibfk_3` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `langganan_ibfk_4` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`id_desa`) REFERENCES `desa` (`id_desa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_metode_pembayaran`) REFERENCES `metode_pembayaran` (`id_metode_pembayaran`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_langganan`) REFERENCES `langganan` (`id_langganan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
