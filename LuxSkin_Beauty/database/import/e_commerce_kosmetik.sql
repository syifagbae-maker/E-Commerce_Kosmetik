-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2026 at 06:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_commerce_kosmetik`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `id_alamat` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `label_alamat` varchar(50) NOT NULL DEFAULT 'Rumah',
  `nama_penerima` varchar(100) NOT NULL,
  `no_hp_penerima` varchar(20) NOT NULL,
  `provinsi` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `kode_pos` varchar(10) NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `catatan` text DEFAULT NULL,
  `alamat_utama` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id_brand` bigint(20) UNSIGNED NOT NULL,
  `nama_brand` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id_brand`, `nama_brand`, `slug`, `deskripsi`, `logo`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Glow Recipe', 'glow-recipe', 'Brand perawatan kulit', NULL, 'aktif', '2026-10-18 15:51:59', '2026-10-18 15:51:59'),
(2, 'Somethinc', 'somethinc', 'Brand kecantikan lokal', NULL, 'aktif', '2026-10-18 15:51:59', '2026-10-18 15:51:59'),
(3, 'Skintific', 'skintific', 'Brand skincare', NULL, 'aktif', '2026-10-18 15:51:59', '2026-10-18 15:51:59'),
(4, 'Wardah', 'wardah', 'Brand kosmetik dan perawatan kulit', NULL, 'aktif', '2026-10-18 15:51:59', '2026-10-18 15:51:59'),
(5, 'LuxSkin Beauty', 'luxskin-beauty', 'Koleksi pilihan LuxSkin', NULL, 'aktif', '2026-10-18 15:51:59', '2026-10-18 15:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `detail_keranjang`
--

CREATE TABLE `detail_keranjang` (
  `id_detail_keranjang` bigint(20) UNSIGNED NOT NULL,
  `id_keranjang` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `nama_produk_saat_beli` varchar(150) NOT NULL,
  `sku_saat_beli` varchar(50) NOT NULL,
  `jumlah` int(10) UNSIGNED NOT NULL,
  `harga_satuan` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `gambar_produk`
--

CREATE TABLE `gambar_produk` (
  `id_gambar` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `path_gambar` varchar(255) NOT NULL,
  `alt_text` varchar(150) DEFAULT NULL,
  `gambar_utama` tinyint(1) NOT NULL DEFAULT 0,
  `urutan` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `slug`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Skincare', 'skincare', 'Produk perawatan kulit wajah', 'aktif', '2026-10-18 15:51:43', '2026-10-18 15:51:43'),
(2, 'Makeup', 'makeup', 'Produk kosmetik dan riasan', 'aktif', '2026-10-18 15:51:43', '2026-10-18 15:51:43'),
(3, 'Body Care', 'body-care', 'Produk perawatan tubuh', 'aktif', '2026-10-18 15:51:43', '2026-10-18 15:51:43'),
(4, 'Hair Care', 'hair-care', 'Produk perawatan rambut', 'aktif', '2026-10-18 15:51:43', '2026-10-18 15:51:43'),
(5, 'Parfum', 'parfum', 'Produk wewangian', 'aktif', '2026-10-18 15:51:43', '2026-10-18 15:51:43');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `status` enum('aktif','checkout','ditinggalkan') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kurir`
--

CREATE TABLE `kurir` (
  `id_kurir` bigint(20) UNSIGNED NOT NULL,
  `nama_kurir` varchar(80) NOT NULL,
  `kode_kurir` varchar(30) NOT NULL,
  `layanan` varchar(100) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kurir`
--

INSERT INTO `kurir` (`id_kurir`, `nama_kurir`, `kode_kurir`, `layanan`, `status`, `created_at`, `updated_at`) VALUES
(1, 'JNE', 'JNE', NULL, 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32'),
(2, 'J&T Express', 'JNT', NULL, 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32'),
(3, 'SiCepat', 'SICEPAT', NULL, 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32'),
(4, 'AnterAja', 'ANTERAJA', NULL, 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `metode_pembayaran`
--

CREATE TABLE `metode_pembayaran` (
  `id_metode` bigint(20) UNSIGNED NOT NULL,
  `nama_metode` varchar(80) NOT NULL,
  `jenis_metode` enum('transfer_bank','virtual_account','e_wallet','cod') NOT NULL,
  `instruksi` text DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `metode_pembayaran`
--

INSERT INTO `metode_pembayaran` (`id_metode`, `nama_metode`, `jenis_metode`, `instruksi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Transfer Bank', 'transfer_bank', 'Ikuti instruksi transfer yang ditampilkan saat checkout.', 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32'),
(2, 'Virtual Account', 'virtual_account', 'Gunakan nomor virtual account yang diberikan.', 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32'),
(3, 'E-Wallet', 'e_wallet', 'Ikuti instruksi pembayaran e-wallet.', 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32'),
(4, 'COD', 'cod', 'Pembayaran dilakukan saat pesanan diterima.', 'aktif', '2026-10-14 09:17:32', '2026-10-14 09:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `jenis_notifikasi` enum('pesanan','pembayaran','pengiriman','promo','sistem') NOT NULL DEFAULT 'sistem',
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `waktu_dibaca` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_metode` bigint(20) UNSIGNED NOT NULL,
  `nomor_referensi` varchar(100) DEFAULT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `status_pembayaran` enum('menunggu','berhasil','gagal','kedaluwarsa','dikembalikan') NOT NULL DEFAULT 'menunggu',
  `waktu_bayar` datetime DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan_voucher`
--

CREATE TABLE `penggunaan_voucher` (
  `id_penggunaan_voucher` bigint(20) UNSIGNED NOT NULL,
  `id_voucher` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `jumlah_diskon` decimal(12,2) NOT NULL,
  `waktu_penggunaan` datetime NOT NULL DEFAULT current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_kurir` bigint(20) UNSIGNED NOT NULL,
  `nomor_resi` varchar(100) DEFAULT NULL,
  `biaya_pengiriman` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status_pengiriman` enum('menunggu','diproses','dikirim','dalam_perjalanan','diantar','diterima','gagal') NOT NULL DEFAULT 'menunggu',
  `tanggal_dikirim` datetime DEFAULT NULL,
  `estimasi_tiba` datetime DEFAULT NULL,
  `tanggal_diterima` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `no_invoice` varchar(40) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_alamat` bigint(20) UNSIGNED NOT NULL,
  `id_status` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pesanan` datetime NOT NULL DEFAULT current_timestamp(),
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `diskon` decimal(12,2) NOT NULL DEFAULT 0.00,
  `ongkir` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total_harga` decimal(12,2) NOT NULL DEFAULT 0.00,
  `catatan_pesanan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `id_kategori` bigint(20) UNSIGNED NOT NULL,
  `id_brand` bigint(20) UNSIGNED NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `manfaat` text DEFAULT NULL,
  `cara_pakai` text DEFAULT NULL,
  `komposisi` text DEFAULT NULL,
  `jenis_kulit` varchar(100) DEFAULT NULL,
  `berat_gram` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `harga` decimal(12,2) NOT NULL,
  `harga_coret` decimal(12,2) DEFAULT NULL,
  `status` enum('draft','aktif','nonaktif') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `id_brand`, `nama_produk`, `slug`, `sku`, `deskripsi`, `manfaat`, `cara_pakai`, `komposisi`, `jenis_kulit`, `berat_gram`, `harga`, `harga_coret`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 'Radiant Glow Serum', 'radiant-glow-serum', 'LUX-SKN-001', 'Serum wajah untuk rutinitas perawatan kulit.', 'Mendukung tampilan kulit yang tampak sehat.', NULL, NULL, 'Semua jenis kulit', 30, 89000.00, 109000.00, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(2, 1, 5, 'Hydra Boost Moisturizer', 'hydra-boost-moisturizer', 'LUX-SKN-002', 'Pelembap wajah untuk pemakaian sehari-hari.', 'Membantu menjaga kelembapan kulit.', NULL, NULL, 'Normal dan kering', 50, 75000.00, 95000.00, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(3, 1, 5, 'Gentle Facial Cleanser', 'gentle-facial-cleanser', 'LUX-SKN-003', 'Pembersih wajah untuk rutinitas harian.', 'Membantu membersihkan kotoran pada wajah.', NULL, NULL, 'Semua jenis kulit', 100, 59000.00, NULL, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(4, 1, 5, 'Daily Sunscreen SPF 50', 'daily-sunscreen-spf-50', 'LUX-SKN-004', 'Contoh produk tabir surya untuk katalog demo.', 'Dirancang sebagai produk pelindung dari paparan sinar matahari.', NULL, NULL, 'Semua jenis kulit', 40, 99000.00, 119000.00, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(5, 2, 5, 'Velvet Matte Lip Cream', 'velvet-matte-lip-cream', 'LUX-MKP-001', 'Lip cream dengan konsep hasil akhir matte.', 'Melengkapi tampilan riasan bibir.', NULL, NULL, 'Semua jenis kulit', 5, 65000.00, NULL, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(6, 2, 5, 'Soft Blur Cushion', 'soft-blur-cushion', 'LUX-MKP-002', 'Contoh produk cushion untuk katalog demo.', 'Melengkapi rutinitas makeup.', NULL, NULL, 'Semua jenis kulit', 15, 125000.00, 149000.00, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(7, 3, 5, 'Silky Body Lotion', 'silky-body-lotion', 'LUX-BDY-001', 'Lotion tubuh untuk perawatan harian.', 'Membantu menjaga kelembapan kulit tubuh.', NULL, NULL, 'Semua jenis kulit', 200, 68000.00, NULL, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10'),
(8, 5, 5, 'Bloom Eau de Parfum', 'bloom-eau-de-parfum', 'LUX-PRF-001', 'Contoh produk wewangian untuk katalog demo.', 'Melengkapi koleksi wewangian sehari-hari.', NULL, NULL, 'Semua jenis kulit', 30, 135000.00, 159000.00, 'aktif', '2026-10-18 15:53:10', '2026-10-18 15:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pengiriman`
--

CREATE TABLE `riwayat_pengiriman` (
  `id_riwayat_pengiriman` bigint(20) UNSIGNED NOT NULL,
  `id_pengiriman` bigint(20) UNSIGNED NOT NULL,
  `status_pengiriman` varchar(50) NOT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `waktu_update` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_status_pesanan`
--

CREATE TABLE `riwayat_status_pesanan` (
  `id_riwayat_status` bigint(20) UNSIGNED NOT NULL,
  `id_pesanan` bigint(20) UNSIGNED NOT NULL,
  `id_status` bigint(20) UNSIGNED NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu_status` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status_pesanan`
--

CREATE TABLE `status_pesanan` (
  `id_status` bigint(20) UNSIGNED NOT NULL,
  `kode_status` varchar(40) NOT NULL,
  `nama_status` varchar(60) NOT NULL,
  `deskripsi` varchar(255) DEFAULT NULL,
  `urutan` smallint(5) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `status_pesanan`
--

INSERT INTO `status_pesanan` (`id_status`, `kode_status`, `nama_status`, `deskripsi`, `urutan`) VALUES
(1, 'menunggu_pembayaran', 'Menunggu Pembayaran', 'Pesanan menunggu pembayaran', 1),
(2, 'dibayar', 'Dibayar', 'Pembayaran telah dikonfirmasi', 2),
(3, 'diproses', 'Diproses', 'Pesanan sedang diproses', 3),
(4, 'dikemas', 'Dikemas', 'Pesanan sedang dikemas', 4),
(5, 'dikirim', 'Dikirim', 'Pesanan telah diserahkan kepada kurir', 5),
(6, 'selesai', 'Selesai', 'Pesanan telah selesai', 6),
(7, 'dibatalkan', 'Dibatalkan', 'Pesanan dibatalkan', 7),
(8, 'gagal', 'Gagal', 'Pesanan gagal diproses', 8);

-- --------------------------------------------------------

--
-- Table structure for table `stok_produk`
--

CREATE TABLE `stok_produk` (
  `id_stok` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `jumlah_stok` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `stok_minimum` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ulasan_produk`
--

CREATE TABLE `ulasan_produk` (
  `id_ulasan` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `id_detail_pesanan` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `komentar` text DEFAULT NULL,
  `status` enum('menunggu','ditampilkan','disembunyikan') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `no_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `no_hp`, `foto`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pasukan UI', 'syifagbae@gmail.com', '$2y$12$uqIg8cuaYdPV7uJvVhWh6.QgGdr6xc193Unlpoaa0DfzRAAxs6w6q', 'admin', NULL, NULL, NULL, NULL, '2026-10-17 04:08:31', '2026-10-17 04:08:31');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id_voucher` bigint(20) UNSIGNED NOT NULL,
  `kode_voucher` varchar(40) NOT NULL,
  `nama_voucher` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `jenis_diskon` enum('persen','nominal') NOT NULL,
  `nilai_diskon` decimal(12,2) NOT NULL,
  `minimal_pembelian` decimal(12,2) NOT NULL DEFAULT 0.00,
  `maksimal_diskon` decimal(12,2) DEFAULT NULL,
  `kuota` int(10) UNSIGNED DEFAULT NULL,
  `mulai_berlaku` datetime NOT NULL,
  `akhir_berlaku` datetime NOT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` bigint(20) UNSIGNED NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_produk` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`id_alamat`),
  ADD KEY `idx_alamat_user` (`id_user`);

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id_brand`),
  ADD UNIQUE KEY `nama_brand` (`nama_brand`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `detail_keranjang`
--
ALTER TABLE `detail_keranjang`
  ADD PRIMARY KEY (`id_detail_keranjang`),
  ADD UNIQUE KEY `uq_keranjang_produk` (`id_keranjang`,`id_produk`),
  ADD KEY `fk_detail_keranjang_produk` (`id_produk`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail_pesanan`),
  ADD KEY `idx_detail_pesanan_pesanan` (`id_pesanan`),
  ADD KEY `idx_detail_pesanan_produk` (`id_produk`);

--
-- Indexes for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD PRIMARY KEY (`id_gambar`),
  ADD KEY `idx_gambar_produk` (`id_produk`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `idx_keranjang_user_status` (`id_user`,`status`);

--
-- Indexes for table `kurir`
--
ALTER TABLE `kurir`
  ADD PRIMARY KEY (`id_kurir`),
  ADD UNIQUE KEY `nama_kurir` (`nama_kurir`),
  ADD UNIQUE KEY `kode_kurir` (`kode_kurir`);

--
-- Indexes for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  ADD PRIMARY KEY (`id_metode`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `fk_notifikasi_pesanan` (`id_pesanan`),
  ADD KEY `idx_notifikasi_user_baca` (`id_user`,`sudah_dibaca`),
  ADD KEY `idx_notifikasi_waktu` (`created_at`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD UNIQUE KEY `nomor_referensi` (`nomor_referensi`),
  ADD KEY `fk_pembayaran_metode` (`id_metode`),
  ADD KEY `idx_pembayaran_pesanan` (`id_pesanan`),
  ADD KEY `idx_pembayaran_status` (`status_pembayaran`);

--
-- Indexes for table `penggunaan_voucher`
--
ALTER TABLE `penggunaan_voucher`
  ADD PRIMARY KEY (`id_penggunaan_voucher`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `fk_penggunaan_user` (`id_user`),
  ADD KEY `idx_penggunaan_voucher_user` (`id_voucher`,`id_user`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD UNIQUE KEY `id_pesanan` (`id_pesanan`),
  ADD UNIQUE KEY `nomor_resi` (`nomor_resi`),
  ADD KEY `fk_pengiriman_kurir` (`id_kurir`),
  ADD KEY `idx_pengiriman_status` (`status_pengiriman`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD UNIQUE KEY `no_invoice` (`no_invoice`),
  ADD KEY `fk_pesanan_alamat` (`id_alamat`),
  ADD KEY `idx_pesanan_user` (`id_user`),
  ADD KEY `idx_pesanan_status` (`id_status`),
  ADD KEY `idx_pesanan_tanggal` (`tanggal_pesanan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `sku` (`sku`),
  ADD KEY `idx_produk_kategori` (`id_kategori`),
  ADD KEY `idx_produk_brand` (`id_brand`),
  ADD KEY `idx_produk_nama` (`nama_produk`),
  ADD KEY `idx_produk_status` (`status`);

--
-- Indexes for table `riwayat_pengiriman`
--
ALTER TABLE `riwayat_pengiriman`
  ADD PRIMARY KEY (`id_riwayat_pengiriman`),
  ADD KEY `idx_riwayat_pengiriman_waktu` (`id_pengiriman`,`waktu_update`);

--
-- Indexes for table `riwayat_status_pesanan`
--
ALTER TABLE `riwayat_status_pesanan`
  ADD PRIMARY KEY (`id_riwayat_status`),
  ADD KEY `fk_riwayat_status_master` (`id_status`),
  ADD KEY `idx_riwayat_status_pesanan_waktu` (`id_pesanan`,`waktu_status`);

--
-- Indexes for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  ADD PRIMARY KEY (`id_status`),
  ADD UNIQUE KEY `kode_status` (`kode_status`);

--
-- Indexes for table `stok_produk`
--
ALTER TABLE `stok_produk`
  ADD PRIMARY KEY (`id_stok`),
  ADD UNIQUE KEY `id_produk` (`id_produk`);

--
-- Indexes for table `ulasan_produk`
--
ALTER TABLE `ulasan_produk`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD UNIQUE KEY `id_detail_pesanan` (`id_detail_pesanan`),
  ADD KEY `idx_ulasan_produk` (`id_produk`),
  ADD KEY `idx_ulasan_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id_voucher`),
  ADD UNIQUE KEY `kode_voucher` (`kode_voucher`),
  ADD KEY `idx_voucher_status` (`status`),
  ADD KEY `idx_voucher_periode` (`mulai_berlaku`,`akhir_berlaku`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`),
  ADD UNIQUE KEY `uq_wishlist_user_produk` (`id_user`,`id_produk`),
  ADD KEY `fk_wishlist_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamat`
--
ALTER TABLE `alamat`
  MODIFY `id_alamat` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id_brand` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `detail_keranjang`
--
ALTER TABLE `detail_keranjang`
  MODIFY `id_detail_keranjang` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail_pesanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  MODIFY `id_gambar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kurir`
--
ALTER TABLE `kurir`
  MODIFY `id_kurir` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `metode_pembayaran`
--
ALTER TABLE `metode_pembayaran`
  MODIFY `id_metode` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penggunaan_voucher`
--
ALTER TABLE `penggunaan_voucher`
  MODIFY `id_penggunaan_voucher` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id_pengiriman` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_pengiriman`
--
ALTER TABLE `riwayat_pengiriman`
  MODIFY `id_riwayat_pengiriman` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_status_pesanan`
--
ALTER TABLE `riwayat_status_pesanan`
  MODIFY `id_riwayat_status` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status_pesanan`
--
ALTER TABLE `status_pesanan`
  MODIFY `id_status` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stok_produk`
--
ALTER TABLE `stok_produk`
  MODIFY `id_stok` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ulasan_produk`
--
ALTER TABLE `ulasan_produk`
  MODIFY `id_ulasan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id_voucher` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `fk_alamat_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_keranjang`
--
ALTER TABLE `detail_keranjang`
  ADD CONSTRAINT `fk_detail_keranjang_keranjang` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_keranjang_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `fk_detail_pesanan_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_pesanan_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE;

--
-- Constraints for table `gambar_produk`
--
ALTER TABLE `gambar_produk`
  ADD CONSTRAINT `fk_gambar_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `fk_notifikasi_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_notifikasi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `fk_pembayaran_metode` FOREIGN KEY (`id_metode`) REFERENCES `metode_pembayaran` (`id_metode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pembayaran_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON UPDATE CASCADE;

--
-- Constraints for table `penggunaan_voucher`
--
ALTER TABLE `penggunaan_voucher`
  ADD CONSTRAINT `fk_penggunaan_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penggunaan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_penggunaan_voucher` FOREIGN KEY (`id_voucher`) REFERENCES `voucher` (`id_voucher`) ON UPDATE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `fk_pengiriman_kurir` FOREIGN KEY (`id_kurir`) REFERENCES `kurir` (`id_kurir`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengiriman_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `fk_pesanan_alamat` FOREIGN KEY (`id_alamat`) REFERENCES `alamat` (`id_alamat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_status` FOREIGN KEY (`id_status`) REFERENCES `status_pesanan` (`id_status`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pesanan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_produk_brand` FOREIGN KEY (`id_brand`) REFERENCES `brand` (`id_brand`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_produk_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_pengiriman`
--
ALTER TABLE `riwayat_pengiriman`
  ADD CONSTRAINT `fk_riwayat_pengiriman` FOREIGN KEY (`id_pengiriman`) REFERENCES `pengiriman` (`id_pengiriman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_status_pesanan`
--
ALTER TABLE `riwayat_status_pesanan`
  ADD CONSTRAINT `fk_riwayat_status_master` FOREIGN KEY (`id_status`) REFERENCES `status_pesanan` (`id_status`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_riwayat_status_pesanan` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `stok_produk`
--
ALTER TABLE `stok_produk`
  ADD CONSTRAINT `fk_stok_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ulasan_produk`
--
ALTER TABLE `ulasan_produk`
  ADD CONSTRAINT `fk_ulasan_detail_pesanan` FOREIGN KEY (`id_detail_pesanan`) REFERENCES `detail_pesanan` (`id_detail_pesanan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ulasan_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ulasan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
