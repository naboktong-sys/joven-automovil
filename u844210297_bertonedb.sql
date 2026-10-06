-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 06, 2026 at 12:05 PM
-- Server version: 11.8.9-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u844210297_bertonedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Kampas rem belakang/ brake shoe', '2026-01-31 09:02:09', '2026-02-03 07:24:55'),
(2, 'Kampas rem depan / brake pad', '2026-02-03 07:24:39', '2026-02-03 07:24:39'),
(3, 'Brake lining', '2026-02-03 07:35:16', '2026-02-03 07:35:16'),
(4, 'Hand brake', '2026-02-05 08:00:58', '2026-02-05 08:00:58'),
(7, 'Karpet alas toyota', '2026-02-05 08:55:14', '2026-02-05 08:55:14'),
(8, 'Karpet alas daihatsu', '2026-02-06 07:51:34', '2026-02-06 07:51:34'),
(9, 'Karpet alas suzuki', '2026-02-06 14:44:09', '2026-02-06 14:44:09'),
(10, 'Karpet alas isuzu', '2026-02-06 14:58:10', '2026-02-06 14:58:10'),
(11, 'Karpet alas mitsubishi', '2026-02-06 15:40:51', '2026-02-06 15:40:51'),
(12, 'Karpet alas honda', '2026-02-06 15:52:48', '2026-02-06 15:52:48'),
(13, 'Karpet alas nissan', '2026-02-06 16:18:11', '2026-02-06 16:18:11'),
(14, 'Karpet wuling', '2026-02-06 16:23:38', '2026-02-06 16:23:38'),
(15, 'Karpet hyundai', '2026-02-06 16:25:47', '2026-02-06 16:25:47'),
(16, 'Karpet garis', '2026-02-06 16:32:19', '2026-02-06 16:32:19'),
(17, 'Karpet roda', '2026-02-06 16:39:39', '2026-02-06 16:39:39'),
(18, 'Bungkus stir', '2026-02-06 18:03:28', '2026-02-06 18:03:28'),
(19, 'Klakson / horn', '2026-02-06 18:03:40', '2026-02-06 18:03:40'),
(20, 'Gel excel', '2026-02-06 18:03:51', '2026-02-06 18:03:51'),
(21, 'Kompon', '2026-02-06 18:04:05', '2026-02-06 18:04:05'),
(22, 'Stempet red top 300', '2026-02-06 18:04:21', '2026-02-06 18:04:21'),
(23, 'Lap pel biru', '2026-02-06 18:04:33', '2026-02-06 18:04:33'),
(24, 'Lap flanel', '2026-02-06 18:04:41', '2026-02-06 18:04:41'),
(25, 'Tempat dudukan air', '2026-02-06 18:04:53', '2026-02-06 18:04:53'),
(26, 'Karpet roda STL sparco silver KS tebal', '2026-02-06 18:05:22', '2026-02-10 04:01:11'),
(28, 'Karpet roda STL sparco silver LJ tipis', '2026-02-06 18:05:47', '2026-02-10 04:01:17'),
(29, 'Segitiga pengaman', '2026-02-23 03:20:54', '2026-02-23 03:20:54'),
(31, 'Clutch operating (karet)', '2026-02-23 03:21:39', '2026-02-23 03:21:39'),
(32, 'Van belt', '2026-02-23 03:21:51', '2026-02-23 03:21:51'),
(33, 'Baut roda', '2026-02-23 03:22:00', '2026-02-23 03:22:00'),
(34, 'Les gasket', '2026-02-23 03:22:09', '2026-02-23 03:22:09'),
(35, 'Cross joint', '2026-02-23 03:22:31', '2026-02-23 03:22:31'),
(36, 'Scun kabel', '2026-02-23 03:22:43', '2026-02-23 03:22:43'),
(37, 'Slang bbm', '2026-02-23 03:23:00', '2026-02-23 03:23:00'),
(42, 'Hand rem', '2026-05-08 03:47:12', '2026-05-08 03:47:12'),
(43, 'Tekiro', '2026-05-08 06:59:24', '2026-05-08 06:59:24'),
(44, 'DNY', '2026-05-08 07:00:49', '2026-05-08 07:00:49');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungans`
--

CREATE TABLE `kunjungans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `toko_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `total_qty` int(11) NOT NULL DEFAULT 0,
  `total_nilai` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `foto_kunjungan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kunjungans`
--

INSERT INTO `kunjungans` (`id`, `toko_id`, `tanggal_kunjungan`, `total_qty`, `total_nilai`, `catatan`, `foto_kunjungan`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-01-31', 5, 12500000.00, NULL, NULL, '2026-01-31 09:03:55', '2026-01-31 09:03:55'),
(3, 3, '2026-02-10', 1, 0.00, '-Oil seak Nok Brake master cup skn JP tmc 70840\r\n- Brake master cup skn JP tmc 94327254\r\n- Karpet roda STL sparco silver (lj) \r\n-Lager nek JP 40 bwd 17 dca (ABS)\r\n- Pin per FE polos gold g ( mb - 035277)\r\n- Brakepad dmr panther \r\n- brake shoe dmr grand max\r\n- Seal askruk panther\r\n- Brake shoe carry st 100\r\n- Brake shoe nkr 55 Brake shoe canter t-200', NULL, '2026-02-10 04:20:06', '2026-02-10 04:20:06'),
(4, 2, '2026-02-10', 1, 0.00, '- lampu riting aasy mas panther clear\r\n- Spion bulat engi univ \r\n- spion emgi fighter bawah miring\r\n- brake master cup skn \r\n- brake master cup skn JP ps 135 tmc 869166\r\n- brake master kit skn tw st 100 extra si 61371 \r\n- kipas radiator \r\n- lampu riting assy mas panther clear \r\n- trans mounting t 120/ L 300\r\n- brake shoe dmr panther / tropper rear\r\n- brake shoe dmr st-100 extra\r\nBrake shoe KF 40/50/ diesel rear \r\n- brake shoe dmr st 100 extra \r\n- brake shoe dmr T 120/L-300 front\r\n- baut kopel + mur ps 120\r\n- Handle pintu luar T 120 ss / futura LH \r\n- Kunci kombinasi tkf 8mm \r\n- slang blower PS 100\r\n- lampu bumper assy mas L 300 \r\n- lampu riting assy mas L 309 \r\n- mika stop L300 PU rh lh\r\n- ball joint JP panther \r\n- Ball joint bawah 55 JP L 038\r\n- caliper kit skn JP panther ( sp -A248 PG)\r\n- fuse box car show l 300/ t 120 \r\n- karet rem skn JP sc -30253 \r\n- pistonn caliper jwj avanza 47731 bz 010\r\n- piston caliper jwj st 100 extra \r\n- nempel angin rem T 120 / PS 100 mm halus\r\n- Pipa rem 4,75 x 150 cm hitam\r\n-. Pipa rem 4,75 x 200 cm hitam\r\n-. Pipa rem 4,75 x 30 cm hitam\r\n-. Tie rid 555 JP st-100', NULL, '2026-02-10 04:39:23', '2026-02-10 04:39:23'),
(5, 1, '2026-02-11', 10, 1310000.00, 'Brake pad APV/ xenia\r\n- brake pad L308\r\n- Brake shoe L 308/ kuda Rr\r\n- Brake shoe avanza xenia \r\n- Brake shoe KAD\r\n- karpet roda FE depan belakang\r\n- karpet roda l308', NULL, '2026-02-11 03:41:59', '2026-02-11 03:41:59'),
(6, 4, '2026-02-23', 4, 726000.00, 'Van belt bando ,\r\nCross joint ,\r\nClutch operating kit skn L308 (karet) ,\r\nSegitiga pengaman ,\r\nSlang BBM ,\r\nLager Kyo tw ,\r\nKunci busi,\r\nLem gasket ,\r\nScun kabel accu ,\r\nBaut roda', NULL, '2026-02-23 02:46:07', '2026-02-23 02:59:50'),
(7, 5, '2026-02-24', 1, 154000.00, 'Brake pad L-038 new ,\r\nBrake pad futura , \r\nBrake shoe L 038 belakang\r\nBrake shoe katana belakang ( belakang)\r\nBrake shoe grand max belakang , \r\nBrake shoe s-88 depan ,\r\nBrake shoe avanza belakang\r\nBrake shoe KAD depan ,\r\nBrake shoe KAD depan ,\r\nBrake shoe KAD belakang ,\r\nBrake shoe nkr 55, \r\nBrake pad panther , \r\nBrake shoe futura ,\r\nBrake pad futura \r\nBrake pad T-120 \r\nTalang air KF super long 4,pintu\r\n\r\nATalang air 2 pintu', NULL, '2026-02-24 03:44:44', '2026-02-24 03:44:44'),
(8, 2, '2026-02-27', 4, 1305500.00, 'Brake shoe T-200 depan belakang - \r\nBrake shoe KAD belakang -\r\nNKR -55 - \r\nBrake shoe F-50- -\r\nBrakeshoe hiace depan belakang \r\nBrake shoe 2f Rr- \r\n Brake shoe Timor - \r\nBrake shoe s-75\r\nBrake shoe s-38, -\r\nBrake shoe esteeem Rr-\r\nBrakeshoe Jetstar\r\nBrake shoe KAD \r\nBrake shoe soluna - \r\nBrake shoe livina -\r\nBrake shoe escudo \r\nBrake shoe f-20 depan', NULL, '2026-02-27 07:30:55', '2026-02-27 07:30:55'),
(9, 7, '2026-03-04', 2, 235000.00, 'Brake pad forsa - brake pad futura- brakepad grand max, brake pad- brake pad s 89 - brake pad ST 100 - brake pad traga - brake pad xenia - kampas rem elf - kampas rem futura- kampas rem jet star u-21, kampas rem katana- kampas rem L038- kampas rem panther , kampas rem st 100- kampas rem T120 belakang - kampas rem T120 muka- kampas rem T120,kampas rem TK 4k,  kampas rem traga belakang, kampas rem vitara, - kampas rem zebra- kampas rem avanza- kampas hand rem canther- kampas hand rem ps 120- kampas rem elf - kampas hand rem rino', NULL, '2026-03-04 04:10:41', '2026-03-04 04:10:41'),
(10, 9, '2026-03-09', 2, 336000.00, NULL, NULL, '2026-05-08 03:42:56', '2026-05-08 03:44:52'),
(11, 36, '2026-03-10', 16, 1868700.00, NULL, NULL, '2026-05-08 03:50:07', '2026-05-08 03:50:07'),
(12, 38, '2026-03-11', 4, 1153000.00, NULL, NULL, '2026-05-08 06:59:07', '2026-05-08 06:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `kunjungan_details`
--

CREATE TABLE `kunjungan_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kunjungan_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` int(10) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kunjungan_details`
--

INSERT INTO `kunjungan_details` (`id`, `kunjungan_id`, `produk_id`, `qty`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, 2500000.00, 12500000.00, '2026-01-31 09:03:55', '2026-01-31 09:03:55'),
(3, 3, 97, 1, 0.00, 0.00, '2026-02-10 04:20:06', '2026-02-10 04:20:06'),
(4, 4, 98, 1, 0.00, 0.00, '2026-02-10 04:39:23', '2026-02-10 04:39:23'),
(5, 5, 8, 10, 131000.00, 1310000.00, '2026-02-11 03:41:59', '2026-02-11 03:41:59'),
(6, 6, 80, 4, 181500.00, 726000.00, '2026-02-23 02:46:07', '2026-02-23 02:46:07'),
(7, 7, 30, 1, 154000.00, 154000.00, '2026-02-24 03:44:44', '2026-02-24 03:44:44'),
(8, 8, 86, 3, 394500.00, 1183500.00, '2026-02-27 07:30:55', '2026-02-27 07:30:55'),
(9, 8, 14, 1, 122000.00, 122000.00, '2026-02-27 07:30:55', '2026-02-27 07:30:55'),
(10, 9, 17, 2, 117500.00, 235000.00, '2026-03-04 04:10:41', '2026-03-04 04:10:41'),
(11, 10, 269, 1, 201000.00, 201000.00, '2026-05-08 03:42:56', '2026-05-08 03:42:56'),
(12, 10, 268, 1, 135000.00, 135000.00, '2026-05-08 03:42:56', '2026-05-08 03:42:56'),
(13, 11, 96, 10, 124500.00, 1245000.00, '2026-05-08 03:50:07', '2026-05-08 03:50:07'),
(14, 11, 270, 6, 103950.00, 623700.00, '2026-05-08 03:50:07', '2026-05-08 03:50:07'),
(15, 12, 61, 2, 309000.00, 618000.00, '2026-05-08 06:59:07', '2026-05-08 06:59:07'),
(16, 12, 49, 1, 272000.00, 272000.00, '2026-05-08 06:59:07', '2026-05-08 06:59:07'),
(17, 12, 64, 1, 263000.00, 263000.00, '2026-05-08 06:59:07', '2026-05-08 06:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_03_05_194740_tambah_kolom_baru_to_users_table', 1),
(7, '2021_03_05_195441_buat_kategori_table', 1),
(8, '2021_03_05_195949_buat_produk_table', 1),
(9, '2021_03_05_200904_buat_setting_table', 1),
(10, '2021_03_11_225128_create_sessions_table', 1),
(11, '2021_03_24_115009_tambah_foreign_key_to_produk_table', 1),
(12, '2021_03_24_131829_tambah_kode_produk_to_produk_table', 1),
(13, '2021_05_08_220315_tambah_diskon_to_setting_table', 1),
(14, '2026_01_21_130626_create_toko_table', 1),
(15, '2026_01_21_130636_create_kunjungan_table', 1),
(16, '2026_01_21_130647_create_kunjungan_detail_table', 1),
(17, '2026_01_22_064819_tambah_kolom_gambar_to_produk_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(10) UNSIGNED NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `harga_beli` int(11) NOT NULL,
  `diskon` tinyint(4) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `kode_produk`, `nama_produk`, `merk`, `harga_beli`, `diskon`, `harga_jual`, `stok`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 2, 'P000001', 'Brake pad Agya/ Ayla manual', 'Daimaru', 0, 0, 144000, 10000, 'produk/1770104241_6981a5b1499f7.jpg', '2026-01-31 09:03:02', '2026-02-06 15:02:46'),
(3, 2, 'P000002', 'Brake pad depan agyla/ Ayla matic', NULL, 0, 0, 144000, 10000, 'produk/1770104306_6981a5f23d27f.jpg', '2026-02-03 07:38:04', '2026-02-06 15:03:18'),
(4, 2, 'P000004', 'Brake pad depan amenity', 'Daimaru', 0, 0, 113000, 1000, 'produk/1770104390_6981a6460fd83.jpg', '2026-02-03 07:39:19', '2026-02-06 17:12:23'),
(5, 2, 'P000005', 'Brake pad depan altis/ vios', 'Daimaru', 0, 0, 159000, 10000, 'produk/1770104576_6981a700d124f.jpg', '2026-02-03 07:42:15', '2026-02-06 17:12:43'),
(6, 2, 'P000006', 'Brake pad depan atoz/kia visto', 'Daimaru', 0, 0, 161000, 1000, 'produk/1770104694_6981a776a8596.jpg', '2026-02-03 07:44:54', '2026-02-06 17:13:04'),
(7, 2, 'P000007', 'Brake pad APV', 'Daimaru', 0, 0, 134000, 1000, 'produk/1770104920_6981a8581743f.png', '2026-02-03 07:48:40', '2026-02-06 17:13:22'),
(8, 2, 'P000008', 'Brake pad avanza/ xenia/ taruna/ terios', 'Daimaru', 0, 0, 131000, 9990, 'produk/1770188876_6982f04cb9fda.jpg', '2026-02-04 07:07:56', '2026-02-11 03:41:59'),
(9, 2, 'P000009', 'Brake pad calya/ Sigra/ new carry2019', 'Daimaru', 0, 0, 140000, 1000, 'produk/1770189018_6982f0da10b9a.png', '2026-02-04 07:10:18', '2026-02-06 17:14:05'),
(10, 2, 'P000010', 'Brake pad CRV frt', 'Daimaru', 0, 0, 188000, 1000, 'produk/1770189107_6982f133ab589.jpg', '2026-02-04 07:11:47', '2026-02-06 17:14:25'),
(11, 2, 'P000011', 'Brake pad CRV Rr', 'Daimaru', 0, 0, 161500, 1000, 'produk/1770189196_6982f18ca0465.jpg', '2026-02-04 07:13:16', '2026-02-06 17:14:43'),
(12, 2, 'P000012', 'Brake pad ertiga frt', 'Daimaru', 0, 0, 146500, 1000, 'produk/1770189282_6982f1e2bfc45.jpg', '2026-02-04 07:14:42', '2026-02-06 17:15:25'),
(13, 2, 'P000013', 'Brake pad escudo 2000', 'Daimaru', 0, 0, 154000, 1000, 'produk/1770189418_6982f26a4269c.jpg', '2026-02-04 07:16:58', '2026-02-06 17:15:50'),
(14, 2, 'P000014', 'Brake pad esteem / baleno', 'Daimaru', 0, 0, 122000, 999, 'produk/1770189695_6982f37f28307.jpg', '2026-02-04 07:21:35', '2026-02-27 07:30:55'),
(15, 2, 'P000015', 'Brake pad xpander / ruah/old ne', 'Daimaru', 0, 0, 147000, 1000, 'produk/1770190928_6982f85082a68.jpg', '2026-02-04 07:42:08', '2026-02-06 17:27:29'),
(16, 2, 'P000016', 'Brake pad Ford laser', 'Daimaru', 0, 0, 120000, 1000, 'produk/1770191000_6982f89829755.jpg', '2026-02-04 07:43:20', '2026-02-06 17:27:53'),
(17, 2, 'P000017', 'Brake pad forsa', 'Daimaru', 0, 0, 117500, 998, 'produk/1770191059_6982f8d367761.jpg', '2026-02-04 07:44:19', '2026-03-04 04:10:41'),
(18, 2, 'P000018', 'Brake pad gemini', 'Daimaru', 0, 0, 105000, 1000, 'produk/1770192332_6982fdccab3c3.jpg', '2026-02-04 08:05:32', '2026-02-06 17:28:46'),
(19, 2, 'P000019', 'Brake pad grand/ N livina', 'Daimaru', 0, 0, 154000, 1000, 'produk/1770193114_698300dade101.jpg', '2026-02-04 08:18:34', '2026-02-06 17:29:11'),
(20, 2, 'P000020', 'Brake pad grandmax/ luxio', 'Daimaru', 0, 0, 146500, 1000, 'produk/1770193271_698301772d0b0.jpg', '2026-02-04 08:21:11', '2026-02-06 17:29:25'),
(21, 2, 'P000021', 'Brake pad Innova biasa', 'Daimaru', 0, 0, 198000, 1000, 'produk/1770193359_698301cf300c2.jpg', '2026-02-04 08:22:39', '2026-02-06 17:29:44'),
(22, 2, 'P000022', 'Brake pad Innova new/ reborn', 'Daimaru', 0, 0, 218000, 1000, 'produk/1770193423_6983020fc3cdb.jpg', '2026-02-04 08:23:19', '2026-02-06 17:30:17'),
(23, 2, 'P000023', 'Brake pad jazz = Brio manual', 'Daimaru', 0, 0, 161500, 1000, 'produk/1770193529_69830279c5de8.jpg', '2026-02-04 08:25:29', '2026-02-06 17:30:36'),
(24, 2, 'P000024', 'Brake pad Jimny sj-410 / katana', 'Daimaru', 0, 0, 102000, 1000, NULL, '2026-02-04 08:26:37', '2026-02-06 17:30:57'),
(25, 2, 'P000025', 'Brake pad karimun', 'Daimaru', 0, 0, 144000, 1000, 'produk/1770193646_698302ee6f64f.jpg', '2026-02-04 08:27:26', '2026-02-06 17:31:15'),
(26, 2, 'P000026', 'Brake pad KBD - 26', 'Daimaru', 0, 0, 136000, 1000, 'produk/1770193740_6983034c81cf4.jpg', '2026-02-04 08:29:00', '2026-02-06 17:31:38'),
(27, 2, 'P000027', 'Brake pad KF 40/50/KF diesel', 'Daimaru', 0, 0, 119500, 1000, 'produk/1770193828_698303a4aa0f2.jpg', '2026-02-04 08:30:28', '2026-02-06 17:32:15'),
(28, 2, 'P000028', 'Brake pad kuda', 'Daimaru', 0, 0, 144000, 1000, 'produk/1770194311_698305872aee2.jpg', '2026-02-04 08:38:31', '2026-02-06 17:32:33'),
(29, 2, 'P000029', 'Brake pad L-038', 'Daimaru', 0, 0, 121500, 1000, 'produk/1770194457_6983061993c45.jpg', '2026-02-04 08:40:57', '2026-02-06 17:32:50'),
(30, 2, 'P000030', 'Brake pad L -038 NEW', 'Daimaru', 0, 0, 154000, 999, 'produk/1770194532_6983066443824.jpg', '2026-02-04 08:42:12', '2026-02-24 03:44:44'),
(31, 2, 'P000031', 'Brake pad L-200', 'Daimaru', 0, 0, 237500, 1000, 'produk/1770194643_698306d378de6.jpg', '2026-02-04 08:44:03', '2026-02-06 17:33:24'),
(32, 2, 'P000032', 'Brake pad Mazda / Ford laser', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770194825_698307891559c.jpg', '2026-02-04 08:47:05', '2026-02-06 17:34:11'),
(33, 2, 'P000033', 'Brake pad Nissan B13', 'Daimaru', 0, 0, 140000, 1000, 'produk/1770194944_698308003eda9.jpg', '2026-02-04 08:49:04', '2026-02-06 17:34:38'),
(34, 2, 'P000034', 'Brake pad panther', 'Daimaru', 0, 0, 134500, 1000, 'produk/1770195290_6983095a43f6b.jpg', '2026-02-04 08:54:50', '2026-02-06 17:35:03'),
(35, 2, 'P000035', 'Brake pad s-89/ zebra Van/ espass/ classy', 'Daimaru', 0, 0, 120000, 1000, 'produk/1770195387_698309bbd30c7.jpg', '2026-02-04 08:56:27', '2026-02-06 17:35:21'),
(36, 2, 'P000036', 'Brake pad soluna/ starlet', 'Daimaru', 0, 0, 136000, 1000, 'produk/1770195723_69830b0b98607.jpg', '2026-02-04 09:02:03', '2026-02-06 17:36:28'),
(37, 2, 'P000037', 'Brake pad SL-413/ T-120ss/ wonder/ civic', 'Daimaru', 0, 0, 105000, 1000, 'produk/1770195831_69830b77dd2e6.jpg', '2026-02-04 09:03:51', '2026-02-06 17:36:47'),
(38, 2, 'P000038', 'Brake pad st 100 extra', 'Daimaru', 0, 0, 97000, 1000, 'produk/1770196946_69830fd2c0c03.jpg', '2026-02-04 09:22:26', '2026-02-06 17:37:03'),
(39, 2, 'P000039', 'Brake pad taft GT/ F 70', 'Daimaru', 0, 0, 120000, 1000, 'produk/1770197147_6983109b2a34d.jpg', '2026-02-04 09:25:47', '2026-02-06 17:37:24'),
(40, 2, 'P000040', 'Brake pad timor 515', 'Daimaru', 0, 0, 159000, 1000, 'produk/1770197372_6983117ce9457.jpg', '2026-02-04 09:29:32', '2026-02-06 17:37:42'),
(41, 2, 'P000041', 'Brake pad traga', 'Daimaru', 0, 0, 211000, 1000, 'produk/1770197458_698311d2273a5.jpg', '2026-02-04 09:30:58', '2026-02-06 17:38:01'),
(42, 2, 'P000042', 'Brake pad vitara / escudo', 'Daimaru', 0, 0, 139500, 1000, 'produk/1770197650_698312921cab7.jpg', '2026-02-04 09:34:10', '2026-02-06 17:39:36'),
(43, 1, 'P000043', 'Brake shoe rear Agya/ ayla', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770197772_6983130c47ba8.jpg', '2026-02-04 09:36:12', '2026-02-06 17:40:00'),
(44, 1, 'P000044', 'Brake shoe  rear amenity', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770264352_69841720079af.jpg', '2026-02-05 04:05:52', '2026-02-06 17:40:26'),
(45, 1, 'P000045', 'Brake shoe  rear APV / new carry', 'Daimaru', 0, 0, 184000, 1000, 'produk/1770264419_69841763ebc08.png', '2026-02-05 04:06:59', '2026-02-06 17:41:02'),
(46, 1, 'P000046', 'Brake shoe rear avanza/ xenia/ taruna/ terios', 'Daimaru', 0, 0, 163500, 1000, 'produk/1770264567_698417f7be8eb.jpg', '2026-02-05 04:09:27', '2026-02-06 17:42:14'),
(47, 1, 'P000047', 'Brake shoe rear calya/ sigra', 'Daimaru', 0, 0, 188000, 1000, 'produk/1770264694_698418760e79f.jpg', '2026-02-05 04:11:34', '2026-02-06 17:42:34'),
(48, 1, 'P000048', 'Brake shoe rear', 'Daimaru', 0, 0, 188000, 1000, NULL, '2026-02-05 04:19:35', '2026-02-06 17:42:51'),
(49, 1, 'P000049', 'Brake shoe rear escudo/ vitara', 'Daimaru', 0, 0, 272000, 999, 'produk/1770265259_69841aab3c6b7.jpg', '2026-02-05 04:20:59', '2026-05-08 06:59:07'),
(50, 1, 'P000050', 'Escudo 2000', 'Daimaru', 0, 0, 238000, 1000, 'produk/1770265306_69841ada44a9e.jpg', '2026-02-05 04:21:46', '2026-02-06 17:43:25'),
(51, 1, 'P000051', 'Brake shoe rear esteem/ baleno/ charade/ wond', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770265440_69841b60b17f8.jpg', '2026-02-05 04:24:00', '2026-02-06 17:43:41'),
(52, 1, 'P000052', 'Brake shoe front= rear elf nkr 55/66', 'Daimaru', 0, 0, 455000, 1000, 'produk/1770265657_69841c392f650.jpg', '2026-02-05 04:27:37', '2026-02-06 17:44:00'),
(53, 1, 'P000053', 'BRAKESHOE rear forsa', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770265727_69841c7f7142a.jpg', '2026-02-05 04:28:47', '2026-02-06 17:44:23'),
(54, 1, 'P000054', 'Brake shoe rear  grand livina', 'Daimaru', 0, 0, 211000, 1000, 'produk/1770265776_69841cb04603e.jpg', '2026-02-05 04:29:36', '2026-02-06 17:44:41'),
(55, 1, 'P000055', 'Brake shoe rear grand max', 'Daimaru', 0, 0, 208500, 1000, 'produk/1770265918_69841d3e1a2cd.jpg', '2026-02-05 04:30:48', '2026-02-06 17:44:58'),
(56, 1, 'P000056', 'Brake shoe front hiace', 'Daimaru', 0, 0, 247500, 1000, 'produk/1770265999_69841d8f9d5c9.jpg', '2026-02-05 04:33:19', '2026-02-06 17:45:15'),
(57, 1, 'P000057', 'Brake shoe rear hiace', 'Daimaru', 0, 0, 346500, 1000, 'produk/1770266075_69841ddbdd594.jpg', '2026-02-05 04:34:35', '2026-02-06 17:45:33'),
(58, 1, 'P000058', 'Brake shoe rear Innova biasa', 'Daimaru', 0, 0, 292000, 1000, 'produk/1770266154_69841e2a293f1.jpg', '2026-02-05 04:35:54', '2026-02-06 17:45:48'),
(59, 1, 'P000059', 'Brake shoe rear Innova new', 'Daimaru', 0, 0, 312500, 1000, 'produk/1770266200_69841e58e3e15.jpg', '2026-02-05 04:36:40', '2026-02-06 17:46:03'),
(60, 1, 'P000060', 'Brake shoe  rear Jimny / sj-410/katana', 'Daimaru', 0, 0, 174000, 100, 'produk/1770266494_69841f7ead472.jpg', '2026-02-05 04:40:43', '2026-02-06 17:46:21'),
(61, 1, 'P000061', 'Brake shoe front KAD/NHR55/ELF', 'Daimaru', 0, 0, 309000, 998, 'produk/1770266687_6984203f64ed0.jpg', '2026-02-05 04:44:47', '2026-05-08 06:59:07'),
(62, 1, 'P000062', 'Brake shoe  rear KAD', 'Daimaru', 0, 0, 321000, 1000, 'produk/1770272884_6984387492c1d.jpg', '2026-02-05 06:28:04', '2026-02-07 02:52:36'),
(63, 1, 'P000063', 'Brake shoe rear karimun', 'Daimaru', 0, 0, 159000, 1000, 'produk/1770273440_69843aa0552c5.jpg', '2026-02-05 06:37:20', '2026-02-07 02:53:41'),
(64, 1, 'P000064', 'Brake shoe KBD 26', 'Daimaru', 0, 0, 263000, 999, 'produk/1770273639_69843b67dfaf7.jpg', '2026-02-05 06:40:39', '2026-05-08 06:59:07'),
(65, 1, 'P000065', 'Brake shoe rear KF KRISTA', 'Daimaru', 0, 0, 292000, 1000, 'produk/1770273715_69843bb314075.jpg', '2026-02-05 06:41:55', '2026-02-07 02:54:37'),
(66, 1, 'P000066', 'Brake shoe front KF 10/20', 'Daimaru', 0, 0, 205000, 1000, 'produk/1770273824_69843c2027395.jpg', '2026-02-05 06:43:44', '2026-02-07 02:55:04'),
(67, 1, 'P000067', 'Brake shoe  REAR KF10/20', 'Daimaru', 0, 0, 230000, 1000, 'produk/1770273993_69843cc9c2ca9.jpg', '2026-02-05 06:46:33', '2026-02-07 02:55:19'),
(68, 1, 'P000068', 'Brake shoe front landcruiser 2F/ rino engkel', 'Daimaru', 0, 0, 383000, 1000, 'produk/1770274071_69843d1706955.jpg', '2026-02-05 06:47:51', '2026-02-07 02:55:35'),
(69, 1, 'P000069', 'Brake shoe rear landcruiser 2F/ rino engkel', 'Daimaru', 0, 0, 383000, 1000, 'produk/1770274122_69843d4a8db9e.jpg', '2026-02-05 06:48:42', '2026-02-07 02:55:54'),
(70, 1, 'P000070', 'Brake shoe L-038 / kuda B& D', 'Daimaru', 0, 0, 284500, 1000, 'produk/1770274279_69843de7b7479.jpg', '2026-02-05 06:51:19', '2026-02-10 16:01:44'),
(71, 1, 'P000071', 'Brake shoe rear L -300 bensin', 'Daimaru', 0, 0, 253500, 1000, 'produk/1770274356_69843e34dd3dd.jpg', '2026-02-05 06:52:36', '2026-02-07 02:56:28'),
(72, 1, 'P000072', 'Brake shoe rear L-200', 'Daimaru', 0, 0, 346500, 1000, 'produk/1770274747_69843fbbbb64e.jpg', '2026-02-05 06:59:07', '2026-02-07 02:57:21'),
(73, 1, 'P000073', 'Brake shoe Mazda rear', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770274880_6984404013b06.jpg', '2026-02-05 07:01:20', '2026-02-07 02:58:24'),
(74, 1, 'P000074', 'Brake shoe rear Nissan b13', 'Daimaru', 0, 0, 173000, 1000, 'produk/1770274946_698440825d3d0.jpg', '2026-02-05 07:02:26', '2026-02-07 02:58:55'),
(75, 1, 'P000075', 'Brake shoe rear panther/ tropper', 'Daimaru', 0, 0, 242500, 1000, 'produk/1770275110_69844126c6d93.jpg', '2026-02-05 07:05:10', '2026-02-07 02:59:18'),
(76, 1, 'P000076', 'Brake shoe front S-38', 'Daimaru', 0, 0, 119000, 1000, 'produk/1770275198_6984417ebd2c0.jpg', '2026-02-05 07:06:38', '2026-02-07 02:59:39'),
(77, 1, 'P000077', 'Brake shoe rear s-38', 'Daimaru', 0, 0, 124500, 1000, 'produk/1770275249_698441b14b47a.jpg', '2026-02-05 07:07:29', '2026-02-07 03:00:05'),
(78, 1, 'P000078', 'Brake shoe front s-75/ hijet s 70', 'Daimaru', 0, 0, 114500, 1000, 'produk/1770275347_69844213e3aa7.jpg', '2026-02-05 07:09:07', '2026-02-07 03:00:27'),
(79, 1, 'P000079', 'Brake shoe rear s-75/88/89/espass', 'Daimaru', 0, 0, 116500, 1000, 'produk/1770275660_6984434cc37fb.jpg', '2026-02-05 07:13:32', '2026-02-07 03:00:42'),
(80, 1, 'P000080', 'Brake shoe s88', 'Daimaru', 0, 0, 181500, 996, 'produk/1770275722_6984438a534cf.jpg', '2026-02-05 07:15:22', '2026-02-23 02:46:07'),
(81, 1, 'P000081', 'Brake shoe rear soluna / new starlet', 'Daimaru', 0, 0, 148500, 1000, 'produk/1770275819_698443eb5e501.jpg', '2026-02-05 07:16:59', '2026-02-07 03:01:15'),
(82, 1, 'P000082', 'Brake shoe front = rear st-100 extra', 'Daimaru', 0, 0, 168000, 1000, 'produk/1770276205_6984456d91dfa.jpg', '2026-02-05 07:23:25', '2026-02-07 02:56:51'),
(83, 1, 'P000083', 'Brake shoe rear T-120ss/SL -413/ futura', 'Daimaru', 0, 0, 163500, 1000, 'produk/1770276634_6984471a1f64a.jpg', '2026-02-05 07:30:34', '2026-02-07 03:01:35'),
(84, 1, 'P000084', 'Brake shoe front t -120/ L -300', 'Daimaru', 0, 0, 205000, 1000, 'produk/1770276713_698447691b8e2.jpg', '2026-02-05 07:31:53', '2026-02-07 03:01:57'),
(85, 1, 'P000085', 'Brake shoe rear T-120', 'Daimaru', 0, 0, 205000, 1000, 'produk/1770276803_698447c3c0880.jpg', '2026-02-05 07:33:23', '2026-02-07 03:02:13'),
(86, 1, 'P000086', 'Brake shoe  front T 200', 'Daimaru', 0, 0, 394500, 997, 'produk/1770276901_69844825384c4.jpg', '2026-02-05 07:35:01', '2026-02-27 07:30:55'),
(87, 1, 'P000087', 'Brake shoe rear t-200', 'Daimaru', 0, 0, 376000, 1000, 'produk/1770276962_698448622fb33.jpg', '2026-02-05 07:36:02', '2026-02-07 03:03:02'),
(88, 1, 'P000088', 'Brake shoe front = rear Taft f-50', 'Daimaru', 0, 0, 237500, 1000, 'produk/1770277332_698449d41b2ff.jpg', '2026-02-05 07:42:12', '2026-02-07 03:03:23'),
(89, 1, 'P000089', 'Brake shoe rear Taft gt/ Feroza/ f-70/ taruna', 'Daimaru', 0, 0, 230000, 1000, 'produk/1770278003_69844c737f3b9.jpg', '2026-02-05 07:53:23', '2026-02-07 03:03:40'),
(90, 1, 'P000090', 'Brake shoe rear  taft independent', 'Daimaru', 0, 0, 383000, 1000, 'produk/1770278087_69844cc70bf5e.jpg', '2026-02-05 07:54:13', '2026-02-07 03:04:00'),
(91, 1, 'P000091', 'Brake shoe rear traga', 'Daimaru', 0, 0, 260500, 1000, 'produk/1770278154_69844d0a20395.jpg', '2026-02-05 07:55:54', '2026-02-07 03:04:16'),
(92, 1, 'P000092', 'Brake shoe rear timor 515', 'Daimaru', 0, 0, 142000, 1000, 'produk/1770278403_69844e034045c.jpg', '2026-02-05 07:56:52', '2026-02-07 03:05:07'),
(93, 1, 'P000093', 'Brake shoe front u-21/ jet star', 'Daimaru', 0, 0, 173500, 1000, 'produk/1770278417_69844e119ebbc.jpg', '2026-02-05 07:57:44', '2026-02-07 03:05:32'),
(94, 1, 'P000094', 'Brake shoe rear u-21/ jet star', 'Daimaru', 0, 0, 198500, 1000, 'produk/1770278437_69844e254226c.jpg', '2026-02-05 07:58:18', '2026-02-07 03:05:52'),
(95, 4, 'P000095', 'Brake shoe daimaru ( hand brake) ps -100/ fe-111', 'Daimaru', 0, 0, 107000, 1000, 'produk/1770278685_69844f1d5db53.jpg', '2026-02-05 08:01:59', '2026-02-07 03:10:37'),
(96, 4, 'P000096', 'Brake shoe  daimaru ( hand brake ) ps 120/ fe-119', 'Daimaru', 0, 0, 124500, 990, 'produk/1770278717_69844f3d582c6.jpg', '2026-02-05 08:03:21', '2026-05-08 03:50:07'),
(97, 4, 'P000097', 'Brake shoe  daimaru ( hand brake ) ps -135 / canter', 'Daimaru', 0, 0, 159000, 999, 'produk/1770278747_69844f5ba3627.jpg', '2026-02-05 08:04:06', '2026-02-19 06:39:34'),
(98, 3, 'P000098', 'Brake lining daimaru font fuso', 'Daimaru', 0, 0, 333000, 999, 'produk/1770279077_698450a512436.jpg', '2026-02-05 08:06:52', '2026-02-19 06:40:00'),
(99, 3, 'P000099', 'Brake lining rear fuso', 'Daimaru', 0, 0, 394500, 1000, 'produk/1770279087_698450af5e708.jpg', '2026-02-05 08:07:25', '2026-02-24 03:45:15'),
(100, 3, 'P000100', 'Brake lining FE-111/ps -100', 'Daimaru', 0, 0, 132000, 1000, 'produk/1770279107_698450c30090a.jpg', '2026-02-05 08:08:06', '2026-02-24 03:45:44'),
(101, 3, 'P000101', 'Brake lining fe -119/PS-120', 'Daimaru', 0, 0, 158500, 1000, 'produk/1770279124_698450d438439.jpg', '2026-02-05 08:08:48', '2026-02-24 03:46:04'),
(102, 3, 'P000102', 'Brake lining FE -447', 'Daimaru', 0, 0, 191000, 1000, 'produk/1770279062_6984509641525.jpg', '2026-02-05 08:09:20', '2026-02-07 03:10:07'),
(103, 7, 'P000103', 'Karpet alas JV  depan/ belakang / belakang agya', 'Joven', 0, 0, 175000, 1000, NULL, '2026-02-05 08:56:21', '2026-02-07 03:11:31'),
(104, 7, 'P000104', 'Karpet alas JV depan tengah belakang avanza', 'Joven', 0, 0, 224000, 1000, NULL, '2026-02-05 08:58:05', '2026-02-24 03:46:30'),
(105, 7, 'P000105', 'Karpet alas depan tengah belakang belakang all new avanza', 'Joven', 0, 0, 224000, 1000, NULL, '2026-02-05 09:09:06', '2026-02-24 03:47:09'),
(106, 7, 'P000106', 'Karpet alas depan tengah belakang belakang avanza new grand 2019', 'Joven', 0, 0, 224000, 1000, NULL, '2026-02-05 09:34:17', '2026-02-24 03:47:33'),
(107, 7, 'P000107', 'Karpet alas JV depan tengah belakang belakang all new avanza 2022', 'Joven', 0, 0, 233000, 1000, NULL, '2026-02-06 06:26:44', '2026-02-24 03:48:35'),
(108, 7, 'P000108', 'Karpet Alas JV depan tengah belakang belakang Fortuner', 'Joven', 0, 0, 260000, 1000, NULL, '2026-02-06 06:28:17', '2026-02-24 03:48:59'),
(109, 7, 'P000109', 'Karpet Alas JV depan tengah belakang belakang new fortuner', 'Joven', 0, 0, 276000, 1000, NULL, '2026-02-06 06:28:59', '2026-02-24 03:49:23'),
(110, 7, 'P000110', 'Karpet Alas JV depan tengah belakang belakang calya', 'Joven', 0, 0, 198000, 1000, NULL, '2026-02-06 06:29:33', '2026-02-24 03:49:48'),
(111, 7, 'P000111', 'Karpet Alas JV depan  Hilux', 'Joven', 0, 0, 86000, 1000, NULL, '2026-02-06 06:30:20', '2026-02-24 03:50:08'),
(112, 7, 'P000112', 'Karpet Alas JV depan tengah belakang hilux', 'Joven', 0, 0, 326000, 1000, NULL, '2026-02-06 06:31:47', '2026-02-24 03:50:41'),
(113, 7, 'P000113', 'Karpet Alas JV depan tengah belakang belakang Innova biasa', 'Joven', 0, 0, 255000, 1000, NULL, '2026-02-06 07:37:43', '2026-02-24 03:51:01'),
(114, 7, 'P000114', 'Karpet Alas JV depan tengah belakang belakang Innova new reborn', 'Joven', 0, 0, 255000, 1000, NULL, '2026-02-06 07:38:24', '2026-02-24 03:51:22'),
(115, 7, 'P000115', 'Karpet Alas JV depan tengah belakang belakang Innova zenix 7 lembar', 'Joven', 0, 0, 350000, 1000, NULL, '2026-02-06 07:39:07', '2026-02-24 03:53:44'),
(116, 7, 'P000116', 'Karpet Alas JV depan kijang lama', 'Joven', 0, 0, 80000, 1000, NULL, '2026-02-06 07:39:46', '2026-02-24 03:54:08'),
(117, 7, 'P000117', 'Karpet Alas JV depan kijang super', 'Joven', 0, 0, 64000, 1000, NULL, '2026-02-06 07:40:21', '2026-02-24 03:54:35'),
(118, 7, 'P000118', 'Karpet Alas JV  tengah kijang super', 'Joven', 0, 0, 72000, 1000, NULL, '2026-02-06 07:41:02', '2026-02-24 03:55:18'),
(119, 7, 'P000119', 'Karpet Alas JV belakang kijang super', 'Joven', 0, 0, 98000, 1000, NULL, '2026-02-06 07:41:35', '2026-02-24 03:55:46'),
(120, 7, 'P000120', 'Karpet Alas JV depan tengah belakang kijang super', 'Joven', 0, 0, 225000, 1000, NULL, '2026-02-06 07:42:12', '2026-02-24 03:56:07'),
(121, 7, 'P000121', 'Karpet Alas JV depan tengah belakang rush', 'Joven', 0, 0, 224000, 1000, NULL, '2026-02-06 07:42:41', '2026-02-24 03:56:30'),
(122, 7, 'P000122', 'Karpet Alas JV depan tengah belakang belakang rush', 'Joven', 0, 0, 224000, 1000, NULL, '2026-02-06 07:43:20', '2026-02-24 03:57:16'),
(123, 7, 'P000123', 'Karpet Alas JV depan tengah belakang belakang all new rush', 'Joven', 0, 0, 267000, 1000, NULL, '2026-02-06 07:43:51', '2026-02-24 03:57:47'),
(124, 7, 'P000124', 'Karpet Alas JV depan  belakang belakang raize', 'Joven', 0, 0, 178000, 1000, NULL, '2026-02-06 07:44:22', '2026-02-24 03:58:27'),
(125, 7, 'P000125', 'Karpet Alas JV depan tengah belakang sidekick', 'Joven', 0, 0, 200000, 1000, NULL, '2026-02-06 07:44:58', '2026-02-24 03:58:50'),
(126, 7, 'P000126', 'Karpet Alas JV depan tengah belakang belakang sienta', 'Joven', 0, 0, 224000, 1000, NULL, '2026-02-06 07:45:30', '2026-02-24 03:59:14'),
(127, 7, 'P000127', 'Karpet Alas JV depan tengah belakang kijang 2000', 'Joven', 0, 0, 255000, 1000, NULL, '2026-02-06 07:46:10', '2026-02-24 03:59:51'),
(128, 7, 'P000128', 'Karpet Alas JV depan tengah belakang KF kapsul/ KF new', 'Joven', 253000, 0, 0, 1000, NULL, '2026-02-06 07:46:57', '2026-02-06 07:46:57'),
(129, 7, 'P000129', 'Karpet Alas JV depan tengah belakang all new veloz 2022', 'Joven', 233000, 0, 0, 1000, NULL, '2026-02-06 07:47:48', '2026-02-06 07:47:48'),
(130, 7, 'P000130', 'Karpet Alas JV depan belakang yaris', 'Joven', 149000, 0, 0, 1000, NULL, '2026-02-06 07:48:27', '2026-02-06 07:48:27'),
(131, 7, 'P000131', 'Karpet Alas JV depan belakang  all new yaris', 'Joven', 151000, 0, 0, 1000, NULL, '2026-02-06 07:49:13', '2026-02-06 07:49:13'),
(132, 7, 'P000132', 'Karpet Alas JV depan  belakang belakang all new yaris', 'Joven', 233000, 0, 0, 1000, NULL, '2026-02-06 07:50:15', '2026-02-06 07:50:15'),
(133, 8, 'P000133', 'Karpet Alas JV depan  belakang belakang Ayla', 'Joven', 175000, 0, 0, 1000, NULL, '2026-02-06 07:53:26', '2026-02-06 07:53:26'),
(134, 8, 'P000134', 'Karpet Alas JV depan esspass', 'Joven', 65000, 0, 0, 1000, NULL, '2026-02-06 09:23:44', '2026-02-06 09:23:44'),
(135, 8, 'P000135', 'Karpet Alas JV tengah belakang espass', 'Joven', 170000, 0, 0, 1000, NULL, '2026-02-06 14:23:25', '2026-02-06 14:23:25'),
(136, 8, 'P000136', 'Karpet Alas JV depan  belakang feroza', 'Joven', 182000, 0, 0, 1000, NULL, '2026-02-06 14:24:23', '2026-02-06 14:24:23'),
(137, 8, 'P000137', 'Karpet Alas JV depan tengah belakang feroza', 'Joven', 190000, 0, 0, 1000, NULL, '2026-02-06 14:24:56', '2026-02-06 14:24:56'),
(138, 8, 'P000138', 'Karpet Alas JV depan grand max', 'Joven', 72000, 0, 0, 1000, NULL, '2026-02-06 14:25:25', '2026-02-06 14:25:25'),
(139, 8, 'P000139', 'Karpet Alas JV tengah belakang grand max', 'Joven', 188000, 0, 0, 1000, NULL, '2026-02-06 14:25:59', '2026-02-06 14:25:59'),
(140, 8, 'P000140', 'Karpet Alas JV depan Hijet', 'Joven', 65000, 0, 0, 1000, NULL, '2026-02-06 14:26:43', '2026-02-06 14:26:43'),
(141, 8, 'P000141', 'Karpet Alas JV depan tengah belakang Hilux (lembar)', 'Joven', 326000, 0, 0, 1000, NULL, '2026-02-06 14:28:04', '2026-02-06 14:28:04'),
(142, 8, 'P000142', 'Karpet Alas JV depan tengah belakang luxio (set)', 'Joven', 292000, 0, 0, 1000, NULL, '2026-02-06 14:28:58', '2026-02-06 14:28:58'),
(143, 8, 'P000143', 'Karpet Alas JV depan tengah belakang Rocky (set)', 'Joven', 197000, 0, 0, 1000, NULL, '2026-02-06 14:29:35', '2026-02-06 14:29:35'),
(144, 8, 'P000144', 'Karpet Alas JV depan tengah belakang new Rocky (set)', 'Joven', 200000, 0, 0, 1000, NULL, '2026-02-06 14:30:21', '2026-02-06 14:30:21'),
(145, 8, 'P000145', 'Karpet Alas JV depan tengah tengah belakang (set)', 'Joven', 198000, 0, 0, 1000, NULL, '2026-02-06 14:31:04', '2026-02-06 14:31:04'),
(146, 8, 'P000146', 'Karpet Alas JV depan tengah belakang belakang taruna short (set)', 'Joven', 184000, 0, 0, 1000, NULL, '2026-02-06 14:31:43', '2026-02-06 14:31:43'),
(147, 8, 'P000147', 'Karpet Alas JV depan belakang  taruna long (set)', 'Joven', 184000, 0, 0, 1000, NULL, '2026-02-06 14:32:32', '2026-02-06 14:32:32'),
(148, 8, 'P000148', 'Karpet Alas JV depan  belakang Taft GT (set)', 'Joven', 182000, 0, 0, 1000, NULL, '2026-02-06 14:33:24', '2026-02-06 14:33:24'),
(149, 8, 'P000149', 'Karpet Alas JV depan tengah belakang belakang terios', 'Joven', 215000, 0, 0, 1000, NULL, '2026-02-06 14:33:59', '2026-02-06 14:33:59'),
(150, 8, 'P000150', 'Karpet Alas JV depan tengah belakang belakang  all new terios', 'Joven', 271000, 0, 0, 1000, NULL, '2026-02-06 14:34:35', '2026-02-06 14:34:35'),
(151, 8, 'P000151', 'Karpet Alas JV depan tengah belakang Triton (set)', 'Joven', 328000, 0, 0, 1000, NULL, '2026-02-06 14:35:23', '2026-02-06 14:35:23'),
(152, 8, 'P000152', 'Karpet Alas JV depan tengah tengah belakang', 'Joven', 224000, 0, 0, 1000, NULL, '2026-02-06 14:36:11', '2026-02-06 14:36:11'),
(153, 8, 'P000153', 'Karpet Alas JV depan tengah belakang all new xenia (set)', 'Joven', 224000, 0, 0, 1000, NULL, '2026-02-06 14:36:51', '2026-02-06 14:36:51'),
(154, 8, 'P000154', 'Karpet Alas JV depan tengah belakang xenia new great 2019', 'Joven', 224000, 0, 0, 1000, NULL, '2026-02-06 14:37:32', '2026-02-06 14:37:32'),
(155, 8, 'P000155', 'Karpet Alas JV depan tengah belakang belakang all new xenia 2022 (set)', 'Joven', 233000, 0, 0, 1000, NULL, '2026-02-06 14:38:13', '2026-02-06 14:38:13'),
(156, 8, 'P000156', 'Karpet Alas JV depan zebra old (lbr)', 'Joven', 65000, 0, 0, 1000, NULL, '2026-02-06 14:38:49', '2026-02-06 14:38:49'),
(157, 9, 'P000157', 'Karpet Alas JV depan belakang  aero (set)', 'Joven', 160000, 0, 0, 1000, NULL, '2026-02-06 14:40:19', '2026-02-06 14:44:30'),
(158, 9, 'P000158', 'Karpet Alas JV depan tengah belakang belakang APV arena (set)', 'Joven', 227000, 0, 0, 1000, NULL, '2026-02-06 14:40:59', '2026-02-06 14:44:44'),
(159, 9, 'P000159', 'Karpet Alas JV depan belakang baleno pcs', 'Joven', 150000, 0, 0, 1000, NULL, '2026-02-06 14:41:41', '2026-02-06 14:45:03'),
(160, 9, 'P000160', 'Karpet Alas JV depan carry st 100 lbr', 'Joven', 60000, 0, 0, 1000, NULL, '2026-02-06 14:42:28', '2026-02-06 14:45:09'),
(161, 9, 'P000161', 'Karpet Alas JV depan carry extra lbr', 'Joven', 60000, 0, 0, 1000, NULL, '2026-02-06 14:43:52', '2026-02-06 14:45:43'),
(162, 9, 'P000162', 'Karpet Alas JV depan new carry 2019 (lbr)', 'Joven', 75000, 0, 0, 1000, NULL, '2026-02-06 14:46:27', '2026-02-06 14:46:27'),
(163, 9, 'P000163', 'Karpet Alas JV depan Mega carry (lbr)', 'Joven', 70000, 0, 0, 1000, NULL, '2026-02-06 14:47:19', '2026-02-06 14:47:19'),
(164, 9, 'P000164', 'Karpet Alas JV depan tengah belakang belakang ertiga (set)', 'Joven', 211000, 0, 0, 1000, NULL, '2026-02-06 14:47:50', '2026-02-06 14:47:50'),
(165, 9, 'P000165', 'Karpet Alas JV depan tengah belakang belakang all new ertiga (set)', 'Joven', 235000, 0, 0, 1000, NULL, '2026-02-06 14:48:20', '2026-02-06 14:48:20'),
(166, 9, 'P000166', 'Karpet Alas JV depan tengah belakang escudo (set)', 'Joven', 200000, 0, 0, 1000, NULL, '2026-02-06 14:49:08', '2026-02-06 14:49:08'),
(167, 9, 'P000167', 'Karpet Alas JV depan tengah belakang escudo new (set)', 'Joven', 230000, 0, 0, 1000, NULL, '2026-02-06 14:49:48', '2026-02-06 14:49:48'),
(168, 9, 'P000168', 'Karpet alas JV depan futura (lbr)', 'Joven', 65000, 0, 0, 1000, NULL, '2026-02-06 14:50:47', '2026-02-06 14:50:47'),
(169, 9, 'P000169', 'Karpet alas JV  tengah / belakang futura (set)', 'Joven', 180000, 0, 0, 1000, NULL, '2026-02-06 14:52:19', '2026-02-06 14:52:19'),
(170, 9, 'P000170', 'Karpet alas JV  depan/ belakang / belakang ignis (set)', 'Joven', 183000, 0, 0, 1000, NULL, '2026-02-06 14:53:26', '2026-02-06 14:53:26'),
(171, 9, 'P000171', 'Karpet alas JV  depan/ belakang Jimny (set)', 'Joven', 165000, 0, 0, 1000, NULL, '2026-02-06 14:54:10', '2026-02-06 14:54:10'),
(172, 9, 'P000172', 'Karpet alas JV  depan/ tengah / belakang katana gx', 'Joven', 170000, 0, 0, 1000, NULL, '2026-02-06 14:54:42', '2026-02-06 14:54:42'),
(173, 9, 'P000173', 'Karpet alas JV  depan/ tengah / belakang karimun lama set', 'Joven', 170000, 0, 0, 1000, NULL, '2026-02-06 14:55:07', '2026-02-06 14:56:04'),
(174, 9, 'P000174', 'Karpet alas JV  depan/ tengah / belakang karimun wagon (set)', 'Joven', 160000, 0, 0, 1000, NULL, '2026-02-06 14:55:48', '2026-02-06 14:55:48'),
(175, 9, 'P000175', 'Karpet alas JV  depan/ tengah / belakang karimun estilo (set)', 'Joven', 164000, 0, 0, 1000, NULL, '2026-02-06 14:56:38', '2026-02-06 14:56:38'),
(176, 9, 'P000176', 'Karpet alas JV  depan/ tengah / belakang sidekick set', 'Joven', 200000, 0, 0, 1000, NULL, '2026-02-06 14:57:12', '2026-02-06 14:57:12'),
(177, 9, 'P000177', 'Karpet alas JV  depan/ tengah / belakang vitara (set)', 'Joven', 200000, 0, 0, 1000, NULL, '2026-02-06 14:57:47', '2026-02-06 14:57:47'),
(178, 10, 'P000178', 'Karpet alas JV  depan pisah panther lbr', 'Joven', 66000, 0, 0, 1000, NULL, '2026-02-06 14:58:58', '2026-02-06 14:58:58'),
(179, 10, 'P000179', 'Karpet alas JV  depan sambung lbr', 'Joven', 0, 0, 75000, 1000, NULL, '2026-02-06 14:59:41', '2026-02-06 15:03:47'),
(180, 10, 'P000180', 'Karpet alas JV   tengah panther (lbr)', 'Joven', 0, 0, 81000, 1000, NULL, '2026-02-06 15:05:20', '2026-02-06 15:05:20'),
(181, 10, 'P000181', 'Karpet alas JV  belakang panther lbr', 'Joven', 0, 0, 110000, 1000, NULL, '2026-02-06 15:06:04', '2026-02-06 15:06:19'),
(182, 10, 'P000182', 'Karpet alas JV   tengah /belakang  panther 2,3 set', 'Joven', 0, 0, 234000, 1000, NULL, '2026-02-06 15:07:14', '2026-02-06 15:07:14'),
(183, 10, 'P000183', 'Karpet alas JV  depan/ tengah /belakang panther new (set)', 'Joven', 0, 0, 248000, 1000, NULL, '2026-02-06 15:08:16', '2026-02-06 15:08:16'),
(184, 10, 'P000184', 'Karpet alas JV  depan isuzu elf set', 'Joven', 0, 0, 72000, 1000, NULL, '2026-02-06 15:35:50', '2026-02-06 15:35:50'),
(185, 10, 'P000185', 'Karpet alas JV  depan isuzu elf nmr set', 'Joven', 0, 0, 79000, 1000, NULL, '2026-02-06 15:38:03', '2026-02-06 15:38:03'),
(186, 11, 'P000186', 'Karpet alas JV  depan isuzu traga set', 'Joven', 0, 0, 72000, 1000, NULL, '2026-02-06 15:38:49', '2026-02-06 15:41:23'),
(187, 11, 'P000187', 'Karpet alas JV  depan cold diesel lama lbr', 'Joven', 0, 0, 70000, 1000, NULL, '2026-02-06 15:39:48', '2026-02-06 15:41:05'),
(188, 11, 'P000188', 'Karpet alas JV  deppan cold diesel fuso 2007 (canter) lbr', 'Joven', 0, 0, 80000, 1000, NULL, '2026-02-06 15:42:30', '2026-02-06 15:42:43'),
(189, 11, 'P000189', 'Karpet alas JV  depan colt-120 lbr', 'Joven', 0, 0, 66000, 1000, NULL, '2026-02-06 15:43:30', '2026-02-06 15:43:30'),
(190, 11, 'P000190', 'Karpet alas JV  depan colt T-120 ss', 'Joven', 0, 0, 66000, 1000, NULL, '2026-02-06 15:44:34', '2026-02-06 15:44:34'),
(191, 11, 'P000191', 'Karpet alas JV  depan Jetstar lbr', 'Joven', 0, 0, 68000, 1000, NULL, '2026-02-06 15:45:15', '2026-02-06 15:45:15'),
(192, 11, 'P000192', 'Karpet alas JV  depan mitsh L-300', 'Joven', 0, 0, 70000, 1000, NULL, '2026-02-06 15:46:03', '2026-02-06 15:46:03'),
(193, 11, 'P000193', 'Karpet alas JV  depan mitsh L -300 new lbr', 'Joven', 0, 0, 73000, 1000, NULL, '2026-02-06 15:47:13', '2026-02-06 15:47:13'),
(194, 11, 'P000194', 'Karpet alas JV  depan/ tengah /belakang kuda long set', 'Joven', 0, 0, 250000, 1000, NULL, '2026-02-06 15:48:54', '2026-02-06 15:48:54'),
(195, 11, 'P000195', 'Karpet alas JV  depan/ tengah / tengah/ belakang Pajero sport', 'Joven', 0, 0, 257000, 1000, NULL, '2026-02-06 15:50:17', '2026-02-06 15:50:17'),
(196, 11, 'P000196', 'Karpet alas JV  depan/ tengah /tengah/ belakang all new Pajero sport set', 'Joven', 0, 0, 274000, 1000, NULL, '2026-02-06 15:51:25', '2026-02-06 15:51:25'),
(197, 11, 'P000197', 'Karpet alas JV  depan/ tengah /belakang x pander', 'Joven', 0, 0, 237000, 1000, NULL, '2026-02-06 15:52:12', '2026-02-06 15:52:12'),
(198, 12, 'P000198', 'Karpet alas JV  depan/belakang  Brio set', 'Joven', 0, 0, 135000, 1000, NULL, '2026-02-06 15:54:22', '2026-02-06 15:54:22'),
(199, 12, 'P000199', 'Karpet alas JV  depan/ tengah /belakang  all new brio', 'Joven', 0, 0, 235000, 1000, NULL, '2026-02-06 15:57:48', '2026-02-06 15:57:48'),
(200, 12, 'P000200', 'Karpet alas JV  depan/ tengah /belakang / belakang Honda brv', 'Joven', 0, 0, 241000, 1000, NULL, '2026-02-06 15:58:29', '2026-02-06 15:58:29'),
(201, 12, 'P000201', 'Karpet alas JV  depan/ tengah /belakang / belakang all new brv 2022 set', 'Joven', 0, 0, 275000, 1000, NULL, '2026-02-06 15:59:14', '2026-02-06 15:59:14'),
(202, 12, 'P000202', 'Karpet alas JV  depan/ tengah /belakang Honda crv', 'Joven', 0, 0, 240000, 1000, NULL, '2026-02-06 16:00:25', '2026-02-06 16:00:25'),
(203, 12, 'P000203', 'Karpet alas JV  depan/ tengah /belakang all new crv2013 set', 'Joven', 0, 0, 250000, 1000, NULL, '2026-02-06 16:01:43', '2026-02-06 16:01:43'),
(204, 12, 'P000204', 'Karpet alas JV  depan/ tengah /belakang  Honda Freed set', 'Joven', 0, 0, 233000, 1000, NULL, '2026-02-06 16:02:24', '2026-02-06 16:02:24'),
(205, 12, 'P000205', 'Karpet alas JV  depan/ tengah /belakang hrv set', 'Joven', 0, 0, 240000, 1000, NULL, '2026-02-06 16:03:38', '2026-02-06 16:03:38'),
(206, 12, 'P000206', 'Karpet alas JV  depan/ tengah /belakang  all new hrv 2022', 'Joven', 0, 0, 298000, 1000, NULL, '2026-02-06 16:04:31', '2026-02-06 16:04:31'),
(207, 12, 'P000207', 'Karpet alas JV  depan/ belakang Honda jazz set', 'Joven', 0, 0, 198000, 1000, NULL, '2026-02-06 16:05:27', '2026-02-06 16:05:27'),
(208, 12, 'P000208', 'Karpet alas JV  depan/ tengah /belakang all new jazz 2019', 'Joven', 0, 0, 228000, 1000, NULL, '2026-02-06 16:06:56', '2026-02-06 16:06:56'),
(209, 12, 'P000209', 'Karpet alas JV  depan/ tengah /belakang Mobilio set', 'Joven', 0, 0, 236000, 1000, NULL, '2026-02-06 16:07:34', '2026-02-06 16:07:34'),
(210, 12, 'P000210', 'Karpet alas JV  depan/ tengah /belakang Honda stream', 'Joven', 0, 0, 188000, 1000, NULL, '2026-02-06 16:08:15', '2026-02-06 16:08:15'),
(211, 13, 'P000211', 'Karpet alas JV  depan/ tengah /belakang evalia', 'Joven', 0, 0, 263000, 1000, NULL, '2026-02-06 16:18:44', '2026-02-06 16:18:44'),
(212, 13, 'P000212', 'Karpet alas JV  depan/ tengah /belakang / belakang grand livina', 'Joven', 0, 0, 230000, 1000, NULL, '2026-02-06 16:19:55', '2026-02-06 16:19:55'),
(213, 13, 'P000213', 'Karpet alas JV  depan/ tengah /belakang / belakang all new livina gp set', 'Joven', 0, 0, 270000, 270000, NULL, '2026-02-06 16:21:36', '2026-02-06 16:22:38'),
(214, 13, 'P000214', 'Karpet alas JV  depan / belakang march set', 'Joven', 0, 0, 135000, 1000, NULL, '2026-02-06 16:22:25', '2026-02-06 16:22:25'),
(215, 13, 'P000215', 'Karpet alas JV  depan/ tengah /belakang opel blazer set', 'Joven', 0, 0, 269000, 1000, NULL, '2026-02-06 16:23:20', '2026-02-06 16:23:20'),
(216, 14, 'P000216', 'Karpet alas JV  depan/ tengah /belakang / belakang confero set', 'Joven', 0, 0, 270000, 1000, NULL, '2026-02-06 16:24:26', '2026-02-06 16:24:26'),
(217, 14, 'P000217', 'Karpet alas JV  depan/belakang / belakang almaz (5bangku) set', 'Joven', 0, 0, 259000, 1000, NULL, '2026-02-06 16:25:20', '2026-02-06 16:25:20'),
(218, 15, 'P000218', 'Karpet alas JV  depan /belakang atoz', 'Joven', 0, 0, 136000, 1000, NULL, '2026-02-06 16:26:47', '2026-02-06 16:26:47'),
(219, 15, 'P000219', 'Karpet alas JV  depan/ tengah /belakang datsun go set', 'Joven', 0, 0, 173000, 1000, NULL, '2026-02-06 16:27:34', '2026-02-06 16:27:34'),
(220, 15, 'P000220', 'Karpet alas JV  depan Hino dutro lbr', 'Joven', 0, 0, 89000, 1000, NULL, '2026-02-06 16:28:18', '2026-02-06 16:29:30'),
(221, 15, 'P000221', 'Karpet alas JV  depan Hino ranger lbr', 'Joven', 0, 0, 163000, 1000, NULL, '2026-02-06 16:28:59', '2026-02-06 16:28:59'),
(222, 15, 'P000222', 'Karpet alas JV  depan/ tengah /belakang / belakang stargazer gp set', 'Joven', 0, 0, 302000, 1000, NULL, '2026-02-06 16:30:22', '2026-02-06 16:30:22'),
(223, 16, 'P000223', 'Karpet keset garis 1 krg = 60 PC trs pcs', 'Joven', 0, 0, 13000, 1000, NULL, '2026-02-06 16:33:23', '2026-02-06 16:33:23'),
(224, 16, 'P000224', 'Karpet keset garis 1krg = 60 PC Daihatsu pcs', 'Joven', 0, 0, 12500, 1000, NULL, '2026-02-06 16:35:00', '2026-02-06 16:35:00'),
(225, 16, 'P000225', 'Karpet keset garis 1krg = 60 PC polos pcs', 'Joven', 0, 0, 12500, 1000, NULL, '2026-02-06 16:35:39', '2026-02-06 16:35:39'),
(226, 16, 'P000226', 'Karpet keset garis 1krg = 60 PC Honda pcs', 'Joven', 0, 0, 12500, 1000, NULL, '2026-02-06 16:36:18', '2026-02-06 16:36:18'),
(227, 16, 'P000227', 'Karpet keset garis 1krg = 60 PC suzuki', 'Joven', 0, 0, 12500, 1000, NULL, '2026-02-06 16:37:07', '2026-02-06 16:37:07'),
(228, 16, 'P000228', 'Karpet keset garis 1krg = 60 PC toyota', 'Joven', 0, 0, 12500, 1000, NULL, '2026-02-06 16:37:39', '2026-02-06 16:37:39'),
(229, 16, 'P000229', 'Karpet keset garis 1krg = 60 PC sarang tawon pcs', 'Joven', 0, 0, 12500, 1000, NULL, '2026-02-06 16:38:17', '2026-02-06 16:38:17'),
(230, 16, 'P000230', 'Karpet keset garis 1krg = 60 PC trs jumbo', 'Joven', 0, 0, 20000, 1000, NULL, '2026-02-06 16:38:55', '2026-02-06 16:38:55'),
(231, 17, 'P000231', 'Karpet roda 1krg = 15 set hati hati set 54 x 72', 'Joven', 0, 0, 55000, 1000, NULL, '2026-02-06 16:40:39', '2026-02-06 16:41:17'),
(232, 17, 'P000232', 'Karpet roda depan isi 50 set (47 x 34) cold diesel / FE isi 50 set', 'Joven', 0, 0, 28500, 1000, NULL, '2026-02-06 16:42:47', '2026-02-06 16:45:14'),
(233, 17, 'P000233', 'Karpet roda belakang isi 25 set cold diesel / FE isi 25 set (47 x 54)', 'Joven', 0, 0, 46500, 1000, NULL, '2026-02-06 16:47:09', '2026-02-06 16:49:17'),
(234, 17, 'P000234', 'Karpet roda  belakang Jimny katana (47 x 54) set', 'Joven', 0, 0, 18500, 1000, NULL, '2026-02-06 16:50:17', '2026-02-06 16:55:59'),
(235, 17, 'P000235', 'Karpet roda  depan kijang super 47 x 54', 'Joven', 0, 0, 22000, 1000, NULL, '2026-02-06 16:51:30', '2026-02-06 16:56:19'),
(236, 17, 'P000236', 'Karpet roda belakang kijang super 47 x 54', 'Joven', 0, 0, 24000, 1000, NULL, '2026-02-06 16:52:14', '2026-02-06 16:55:20'),
(237, 17, 'P000237', 'Karpet roda depan kijang new set 47 x 54', 'Joven', 0, 0, 25000, 1000, NULL, '2026-02-06 16:54:45', '2026-02-06 16:57:18'),
(238, 17, 'P000238', 'Karpet roda belakang kijang new 47 x 54 set', 'Joven', 0, 0, 26000, 1000, NULL, '2026-02-06 16:59:26', '2026-02-06 16:59:26'),
(239, 17, 'P000239', 'Karpet roda depan L -300 colt 24 x 37 set', 'Joven', 0, 0, 17500, 1000, NULL, '2026-02-06 17:00:38', '2026-02-06 17:00:38'),
(240, 17, 'P000240', 'Karpet roda belakang 28 x 35 set', 'Joven', 0, 0, 14000, 1000, NULL, '2026-02-06 17:01:33', '2026-02-06 17:01:33'),
(241, 17, 'P000241', 'Karpet roda depan panther 22 x 23 set', 'Joven', 0, 0, 18000, 1000, NULL, '2026-02-06 17:02:34', '2026-02-06 17:02:34'),
(242, 17, 'P000242', 'Karpet roda belakang panther 18 x 29 set', 'Joven', 0, 0, 19000, 1000, NULL, '2026-02-06 17:03:31', '2026-02-06 17:03:31'),
(243, 17, 'P000243', 'Karpet roda depan s-88 set', 'Joven', 0, 0, 14000, 1000, NULL, '2026-02-06 17:04:13', '2026-02-06 17:04:13'),
(244, 17, 'P000244', 'Karpet roda belakang S-88  18 x 26 set', 'Joven', 0, 0, 14000, 1000, NULL, '2026-02-06 17:05:14', '2026-02-06 17:05:14'),
(245, 17, 'P000245', 'Karpet roda depan st -100 set', 'Joven', 0, 0, 14000, 1000, NULL, '2026-02-06 17:05:56', '2026-02-06 17:05:56'),
(246, 17, 'P000246', 'Karpet roda 18 x 29 belakang st - 100 / futura', 'Joven', 0, 0, 14000, 1000, NULL, '2026-02-06 17:07:09', '2026-02-06 17:07:09'),
(247, 17, 'P000247', 'Karpet roda depan 23 x 27 x 22 T-120 set', 'Joven', 0, 0, 16000, 1000, NULL, '2026-02-06 17:08:10', '2026-02-06 17:08:10'),
(248, 17, 'P000248', 'Karpet roda 15 x 20 x 27 belakang T-120 set', 'Joven', 0, 0, 16000, 1000, NULL, '2026-02-06 17:09:16', '2026-02-06 17:09:16'),
(249, 17, 'P000249', 'Karpet roda 15 x20 x 27 depan Taft gt set', 'Joven', 0, 0, 22000, 1000, NULL, '2026-02-06 17:10:07', '2026-02-06 17:10:07'),
(250, 17, 'P000250', 'Karpet roda 15 x20 x27 belakang Taft gt set', 'Joven', 0, 0, 25000, 1000, NULL, '2026-02-06 17:11:02', '2026-02-06 17:11:02'),
(251, 17, 'P000251', 'Karpet roda 20 x 23 x 30 Univ TRD KIPAS SET', 'Joven', 0, 0, 16500, 1000, NULL, '2026-02-06 17:11:57', '2026-02-06 17:11:57'),
(252, 18, 'P000252', 'Bungkus stir japa Denzel ukuran M universal/ L -300', 'Japa Denzel', 0, 0, 46000, 1000, NULL, '2026-02-06 18:07:04', '2026-02-06 18:07:14'),
(253, 18, 'P000253', 'Bungkus stir ukuran L universal / FE', 'Japa Denzel', 0, 0, 49000, 1000, NULL, '2026-02-06 18:08:04', '2026-02-06 18:08:04'),
(254, 19, 'P000254', 'Horn japa 12 engkel 1 dos = 30 PC 12 V (110 MM)', 'Japa Denzel', 0, 0, 48500, 1000, NULL, '2026-02-06 18:09:13', '2026-02-06 18:09:13'),
(255, 19, 'P000255', 'Horn japa 24 engkel 1 dos = 30 PC 24 V (110 MM)', NULL, 0, 0, 50500, 1000, NULL, '2026-02-06 18:10:12', '2026-02-06 18:10:12'),
(256, 19, 'P000256', 'Horn Japa 12 V dobel super tone 12v (110MM) 1 dos = 20 set universal', 'Japa Denzel', 0, 0, 90000, 1000, NULL, '2026-02-06 18:11:38', '2026-02-06 18:11:46'),
(257, 19, 'P000257', 'Horn Japa 24 V dobel super tone 1 dos = 20 set universal', 'Japa Denzel', 0, 0, 93500, 1000, NULL, '2026-02-06 18:12:51', '2026-02-06 18:12:51'),
(258, 19, 'P000258', 'Horn japa 12 V Twin  12 V (90 MM) 1 dos = 24 set universal', 'Japa Denzel', 0, 0, 79000, 1000, NULL, '2026-02-06 18:13:52', '2026-02-06 18:13:52'),
(259, 20, 'P000259', 'Gel excel japa Denzel 1 dos = 15 bot universal', 'Japa Denzel', 0, 0, 10000, 1000, NULL, '2026-02-06 18:14:49', '2026-02-06 18:14:49'),
(260, 21, 'P000260', 'Kompon cepuk joven 52 gram  1dos = 24 PC coklat', 'Japa Denzel', 0, 0, 5600, 1000, NULL, '2026-02-06 18:16:07', '2026-02-06 18:16:07'),
(261, 21, 'P000261', 'Kompon cepuk joven 50 gram 1 dos = 24 pc putih', 'Japa Denzel', 0, 0, 6000, 1000, NULL, '2026-02-06 18:17:17', '2026-02-06 18:17:17'),
(262, 22, 'P000262', 'Stempet red top 300 1 dos = 50 PC universal', NULL, 0, 0, 13500, 1000, NULL, '2026-02-06 18:18:15', '2026-02-06 18:18:15'),
(263, 23, 'P000263', 'Lap pel biru japa Denzel universal', 'Japa Denzel', 0, 0, 75000, 1000, NULL, '2026-02-06 18:18:58', '2026-02-06 18:18:58'),
(264, 24, 'P000264', 'Lap flanel japa denzel 37 x 49 cm universal', 'Japa Denzel', 0, 0, 98000, 1000, NULL, '2026-02-06 18:19:54', '2026-02-06 18:20:02'),
(265, 25, 'P000265', 'Tempat dudukan air japa Denzel', 'Japa Denzel', 0, 0, 40000, 1000, NULL, '2026-02-06 18:20:32', '2026-02-06 18:20:32'),
(266, 26, 'P000266', 'Karpet roda STL SPARCO SILVER (KS) UNIVERSAL', 'Japa Denzel', 0, 0, 25500, 1000, NULL, '2026-02-06 18:21:19', '2026-02-06 18:21:19'),
(267, 28, 'P000267', 'Karpet roda STL SPARCO SILVER (LJ) UNIVERSAL', 'Japa Denzel', 0, 0, 17500, 1000, NULL, '2026-02-06 18:22:07', '2026-02-06 18:22:07'),
(268, 3, 'P000268', 'Brake Lining ps120 ibk/rca', 'Ibk', 0, 0, 135000, 999, NULL, '2026-05-08 03:40:25', '2026-05-08 03:42:56'),
(269, 3, 'P000269', 'Brake Lining canter', 'Ibk', 0, 0, 201000, 999, NULL, '2026-05-08 03:41:36', '2026-05-08 03:42:56'),
(270, 42, 'P000270', 'Hand rem nhr 55 sanikko', 'Sanikko', 0, 0, 103950, 994, NULL, '2026-05-08 03:48:56', '2026-05-08 03:50:07'),
(271, 43, 'P000271', 'Obeng tekiro (+) 6x100 mm', 'Tekiro', 0, 0, 0, 1000, NULL, '2026-05-08 07:00:16', '2026-05-08 07:00:16'),
(272, 44, 'P000272', 'Turen signal switch L 300', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:01:43', '2026-05-09 07:01:43'),
(273, 44, 'P000273', 'Back horn stanlise DNY H93', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:02:44', '2026-05-09 07:02:44'),
(274, 44, 'P000274', 'Km 30 merah', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:03:22', '2026-05-09 07:03:22'),
(275, 44, 'P000275', 'STP KAD', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:04:08', '2026-05-09 07:04:08'),
(276, 44, 'P000276', 'Ms - sk 40 ( skun mata ayam)', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:13:45', '2026-05-09 07:13:45'),
(277, 44, 'P000277', 'Km 50 skun mata ayam', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:18:14', '2026-05-09 07:18:14'),
(278, 44, 'P000278', 'DNY 150 red an yellow', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:20:55', '2026-05-09 07:20:55'),
(279, 44, 'P000279', 'DNY 350 kuning', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:21:47', '2026-05-09 07:21:47'),
(280, 44, 'P000280', 'DNY 350', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:23:23', '2026-05-09 07:23:23'),
(281, 44, 'P000281', 'DNY 350 biru', 'DNY', 0, 0, 0, 1000, NULL, '2026-05-09 07:25:25', '2026-05-09 07:25:25');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` text NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('0w4GF2Dz6dnyAUuZALHJVCY1Mm5BtEOnKMF9b8rw', NULL, '98.92.5.248', 'Mozilla/5.0 (Linux; Android 10; Redmi Note 8 Pro) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/101.0.4951.41 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXdkMjR1M3NXSTFoYmwwbWoxdGRZY0tHWlFPSzBTZEpicTNERkF4cyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790779053),
('3smvpXSKdSOwQicIstOCglmP2dmkyaz5IR4Vfwdg', NULL, '2400:6180:10:200::e6b7:b000', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVWJ1SkhoT1A5NUNyY0RUMjVmNVFFS202blhNZUxNQmFRN21VUHlRUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790962340),
('5yqEUQZ2S1k8naMIGK9GdQfn2WqVeHRg8fmCSlzB', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVUt6endKbmhCZFFHT3Eydm12VThncDVaTklaOUpxRkVzUU9ScXFzeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791260256),
('6KLVMtzIcOB8Wnli3peqJ49NIQiZs9XDDSegN0Nl', NULL, '114.12.20.40', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFhXajMzdjFmU05TNEdZNjBzeTNaWEtWSndKQkVjT3ZwZENBMDNiVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791287464),
('6soFOlDzPX52sNhECERcvzRURsjHXUSwa7PmlY7b', NULL, '66.249.74.228', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.84 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMTlCUkZhZDFNdXdHVDBDRXZ4SlJZdk5mc3VmV2M3ekhWQTRGbjR3TiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791253683),
('7wwJWqgFRJvaZ3caB4B3xAi82Tzg1ODniG2RVLCs', NULL, '139.59.16.211', 'Mozilla/5.0 (X11; Linux x86_64; rv:153.0) Gecko/20100101 Firefox/153.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ1c1eERBNkUxeEd5WDhUbUNXUXZBZ2V2M2Z1RFg2eXF0RVF6RXNTSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmJlcnRvbmUuaWQvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790796808),
('85P155GbtcxM0gGjCl9nOCtcgdQG2YrM4A7zcn7f', NULL, '35.207.43.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTlFXSVUzejJUVjRCYkhPVUtwTGtEdk9sSU9BVDI1SUFzc1pESWoyWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791080087),
('8CWhafnCaotyRjLzvoaEwANpjpGI42gytEixuzIF', NULL, '75.101.222.144', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.0.1 Safari/605.1.15', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic0pTSmpyb0NuanppWnp1eXl3dXV1dktnTUhwRHk5YkFiejZtMEdKWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791224016),
('ba2cbMFVSio5vjEDRpyErmFEHMN46vfFRJtpq0C5', NULL, '182.253.228.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazVNcnluUWV1d1FMSU9OUzFGa1RwbXlXV0tZa1E4aG8xbjVmQm8ySSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790785966),
('bdoiN053EaplmdTEvyqaeNZjM8CbNFMZZxnGMltb', NULL, '144.217.135.165', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSmJyenRUZWNxMmkwbjd1VEFmS0lQQjB5Qlp1SWVRNWxRRVJqc2dJSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmJlcnRvbmUuaWQvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790864813),
('bdwtx6jJi4h9vylLffwkQ8mgjjeWrIS5jSJQfXWw', NULL, '2a01:ecc0:480:16c::2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidjRVUWNqTzlBUkNKWkdVTzdtNWJOTXRKRHpkbVJiR25ocTN4M2IybCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791172066),
('buicuSYsdDQ68mK0j8ktCjzIjrFH0LccWpxV8Hra', NULL, '185.110.10.81', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUFNtNExlOU5qTGhWWmtyNVVlRDU3b2c0MmhVNnlTZ25RYXhRT3RQVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791150407),
('CY8SxICLdnwP7KpG88OsppisZrBFRAvWIo9XAi8r', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZGZpMlZtTWI3NW11dXEwSDdSUnZFS29CaGE3V2NvdWlWODlNM25QTCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791196441),
('fUa350jV2OtfxZ72oOp4CjslxYK2OiuLaNH5RJLe', NULL, '2a01:ecc0:480:16c::2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzZHSWg3ekptTHZaMjkyWlBnWkNxcGJ3bDFJc2FXR3VmdXludGJpQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791172066),
('fvEZCHJTJBeZd8RNGMKoBqshvMVy6tyGMP3OJDhN', NULL, '2400:6180:10:200::e6b7:b000', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoid2hLWVVvQ2xPSVlyRnZLZWtZUmo5WkFYUGF2UUcxaHFQanYwdmphQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790962340),
('I5ELTaLqLqqn4wXs7egUTIgfuU328hMN5mPkdgu8', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicWhTQzBKUjlXRzRsVm1iSmJTOGZ6NGxpcjA3S085T3M3MXVQYklBNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791196441),
('I5pZqYeNWKHl9Ho08gj4ezDv7woiJtQYAQrXXEn4', NULL, '2001:4ca0:108:42::7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVDZ5ZnVyQlFpbEVSMXZVQ3N2clB2eFBBM1RMTzRNMVhTVUkxZlNNUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791136377),
('j0SzdB1O1p1IeZDgpdqZZaUEUpxec3eWjvD0xorj', NULL, '66.249.74.226', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTlPdk5jeTV0THpBb1Rkb2p5OW96NmJIbmdMWlFaVFFGM1hHNlp4SyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791253684),
('j7RsRSYBsM2pKeAtYcIEv6kmPl4dmg6wfuqN7x0D', NULL, '185.12.150.161', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM0JEVUk5ZFVWMXp6Y2l6Unp3c1Vjd2ViMlRpN090TVIyRE9iZExacSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791072941),
('JWq0Iux87KWtQC8VHBCouT5eMDcwd6c02JcV2HBB', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieDZ5R0JFTnR1WEIxS2pJYXpWRVJUTEdCR3ZFV001UGNJRUZxSzBOVCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790834769),
('KIByzojRTxqAN1oaA4X0sLrBH9CBQW4pfluouv21', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMDRoejhjZkY1WEZpVEtBS2ZPWUsydE40UGdaSGc2ZFlHeXNDNklSNiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791075699),
('kkSIKaTohQKNWWUkM4lap4MDvYF2y8kSoqz9FRMf', NULL, '98.92.5.248', 'Mozilla/5.0 (Linux; Android 9; ASUS_X00TD) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibWNzZlV5aEhjZDBla0l1TnAyTjdrSmF6TTRtWkxvRkxHdVN0Y09XcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790779054),
('Ko59GyfywJgj0kRccQH0DEDqwuEvkQOanVl87boM', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoialhvamh1YkFxaFpRY09EalFLN1RGeUE4M0tWc2tCNUJkQ2lHZ25JViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790834769),
('ksQdDGkBlkff2zlJZpQYGyZeDggp6hYlzMEHD0Hc', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoibkQ3eDA4cWxVaXcwdzJLZ0NYT2xZcXRCRXdVY3VPZzlCQk9UZTRjdiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791260256),
('lVlF58VkeVlPi96I7Dne9YRhmpHCpL0Pn3GP0M80', NULL, '66.249.74.226', 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT214YU9VMEIyZ2E4dVQyV2IzNVQ2UGVObVRqdFR5RVpMcGppcFd6YiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790974471),
('lVWz49OwcKyg1qI9PjiFZkD1KclKdgpeQjGtoRo2', NULL, '174.138.6.237', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYkdUWUx4UnYxYUFNR1ltcWgwTW4xbHhpOE1oUTN4dGNCVjVwYlh4aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790836067),
('mJFtpZDWxz570hFKpQoDLHsmU4MV7tWnDFHcNjAa', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoid0dzR3ZlWmZtYmgyTEZlQ25sSElnakxRV0RsY29nYWZHQWRNeVFMbSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790936159),
('mYtvCaMqcGTidV5LmUn8xPTtIGuNkYPcXkwRAYl3', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiM0R3NlkwaVk4azI1d2R1clJlemtXM1VpVHNzWWZLQlg5b0JjYkFqbiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790936159),
('nRAbECN03oocQUif7WpRxTTnPuipXgzRM0IXjRSW', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiMUdTYm5Gd1l5dFA1ZmhnZmxwSlRLZ0E0N2hMbDc0bEd3Z0g2Rk5xViI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791075699),
('PadYpsECXM56Rlf5Svx2FGy6xfECV8bfVtat8IqX', NULL, '182.253.228.225', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWWNaSmZaS3liYUlxV3E4SWVEblk3Q3Z6Rkl6VXY2aXEwWEcybUNxZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAwOiJodHRwczovL2JlcnRvbmUuaWQvaW5kZXgucGhwP19maWVsZHM9aWQlMkNzbHVnJTJDdGVtcGxhdGUmcGVyX3BhZ2U9MTAwJnJlc3Rfcm91dGU9JTJGd3AlMkZ2MiUyRnBhZ2VzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790785966),
('PCjrhW53A3xdyJ0SfAeI9C3vzJpMQtE7ItvHocbH', NULL, '2001:4ca0:108:42::7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVlRVUk14RTFwVnpTVUtOOWZFRHpFTEhNakpNWE16MlhpRTVFUVBMbyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791125206),
('PPYVPAhQkSAOUy1GcAFw5ci6pezjsIqXJXNYMWxH', NULL, '144.217.135.165', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaTlGR0xDdzdCYUdaU0hVQmZrSDZ0anNYM2F4YU1zWXcwRGxjTTFVTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vd3d3LmJlcnRvbmUuaWQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790864812),
('Pwig410qUhOVv6EAsYc3eUxWGgENEkHdOwKBMa3E', NULL, '144.217.135.165', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUzdHeUNNS2t4WjMwZUVCQmV0bXBuNHVpeU8wM1VrMFZJd3dZbGMzVSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmJlcnRvbmUuaWQvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790864809),
('qW8wux1BCWRITeruf0yvKfhy6iGTCyQc681QGmzO', NULL, '194.132.51.97', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:123.0) Gecko/20100101 Firefox/123', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVndFNHVhOEVlanZJRnZtZ0lGcHdBWE9EdWMyOXlrTHVkakZabzFsOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791072942),
('T6OmN1Eam9laYHraKzrZk5pJVY88mZ16MLWNDKfn', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoicnBYT2JQazVoaGtKTG9jZ3QzM2JzVXpQU1hDSFEzMWNwSmlFb3FUWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791001616),
('TDOneh8wcvewxOcghgzQRwrI0iXu4PyixfwWRrJj', NULL, '35.207.43.170', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTWlSbm5IUTFYRWduQWozUWNBSFo1SHBQN1lKRTVPQXRpOVNuaWtJQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791080086),
('UbEDhZ3gUquJ1Ni68Gnc8ZcfFRgEnAWyTlHFR8m8', NULL, '138.246.253.7', 'quic-go-HTTP/3', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiZnFNSVVLemRhU2RxM3dxMDhLQVJSWnhIQ3FBUGlpTElCVjBVOFZJMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1790910117),
('uDw9DkGSZlWfMIFuVAgsurJi5gStJVaWdDYqxH8O', NULL, '2400:6180:10:200::e6b7:b000', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicnlwTjROZ2lyN1FpR2NONW52TXdJQ1QzdnY0RFkwMlludDdNYjZ2cSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTg6Imh0dHBzOi8vYmVydG9uZS5pZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1790962340),
('UNxZFeXpsZ6WMGPD9obtHNbf0oreyRcZomxdRMHn', NULL, '52.167.144.166', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiR2hTMTJYWmxXeGdCUWM4NW9DTURtdFBINlNMcEdsZVRObk9lU0xxSyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vYmVydG9uZS5pZC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1791145741),
('WZwCPTlmtuMXZV5OtgKGiHcEg6gXbBVXlnEeU54G', NULL, '2a02:4780:6:c0de::8', 'Go-http-client/2.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoieVlsY3poWWk2VWpFYlM3WWVIdzdSanlSTkJaMkVuT3pweXRGMmxiMSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1791001616),
('x0u5TT7NjTzqsaOFI95FPnNWiKhBBBSaBJGHxaeR', NULL, '149.56.160.212', 'Mozilla/5.0 (Linux; Android 10; SM-G981B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.162 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieDdWSHJ3aEswblVGclpRVHJQcXYzODdKZGtOZHhxTVk3cmdxaW9hMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmJlcnRvbmUuaWQvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790864752),
('zIGI6gVnRjJlH5LiXotYZGhbWKsvOBO20BIV4ypQ', NULL, '149.56.160.212', 'Mozilla/5.0 (compatible; Dataprovider.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiS216Q0VMRzd6UVI4RE5MUTdBbHBaYVk2ZTRGbWpBcktKbFl4TGJKayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjg6Imh0dHBzOi8vd3d3LmJlcnRvbmUuaWQvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1790864749);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_setting` int(10) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(255) NOT NULL,
  `tipe_nota` tinyint(4) NOT NULL,
  `diskon` smallint(6) NOT NULL DEFAULT 0,
  `path_logo` varchar(255) NOT NULL,
  `path_kartu_member` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_setting`, `nama_perusahaan`, `alamat`, `telepon`, `tipe_nota`, `diskon`, `path_logo`, `path_kartu_member`, `created_at`, `updated_at`) VALUES
(1, 'JOVEN AUTOMOVIL', 'Malang', '0812345678', 1, 0, '/img/logo.png', '/img/member.png', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tokos`
--

CREATE TABLE `tokos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `foto_toko` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokos`
--

INSERT INTO `tokos` (`id`, `nama_toko`, `alamat`, `kontak`, `foto_toko`, `latitude`, `longitude`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'Formosa', 'Ponorogo', NULL, NULL, NULL, NULL, 'Pak', '2026-01-31 09:03:35', '2026-02-10 04:01:53'),
(2, 'Sri megah', 'Ngawi', NULL, NULL, NULL, NULL, NULL, '2026-02-10 04:03:04', '2026-02-10 04:03:04'),
(3, 'Tritunggal', 'Ponorogo', NULL, NULL, NULL, NULL, NULL, '2026-02-10 04:04:22', '2026-05-07 08:53:49'),
(4, 'Maju motor SINGOSARI', 'Singosari', NULL, NULL, NULL, NULL, 'Singosari', '2026-02-23 02:40:40', '2026-05-07 08:53:59'),
(5, 'Andy motor batu', 'Batu', NULL, NULL, NULL, NULL, NULL, '2026-02-24 03:38:30', '2026-02-24 03:38:30'),
(6, 'Sekar jaya turen', 'Turen', NULL, NULL, NULL, NULL, NULL, '2026-02-27 07:12:27', '2026-02-27 07:12:27'),
(7, 'Slamet kandangan', 'Kandangan kediri', NULL, NULL, NULL, NULL, NULL, '2026-03-04 03:56:12', '2026-03-04 03:56:12'),
(8, 'Jaya motor blitar', 'Blitar', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:04:11', '2026-05-07 09:04:11'),
(9, 'Brawijaya motor', 'Blitar Wlingi', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:04:47', '2026-05-07 09:04:47'),
(10, 'Gunung mas srengat', 'Srengat', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:05:27', '2026-05-07 09:05:27'),
(11, 'Oriza jaya oli', 'Blitar', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:06:03', '2026-05-07 09:06:03'),
(12, 'Sb motor', 'Kediri', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:07:24', '2026-05-07 09:07:24'),
(13, 'Adam motor', 'Kediri', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:07:41', '2026-05-07 09:07:41'),
(14, 'Endang motor', 'Kediri', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:08:00', '2026-05-07 09:08:00'),
(15, 'Morodadi motor', 'Kediri', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:08:16', '2026-05-07 09:08:16'),
(16, 'Slamet motor kandangan', 'Kandangan kediri', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:08:35', '2026-05-07 09:08:35'),
(17, 'Jaya abadi motor', 'Pajarakan Probolinggo', NULL, NULL, NULL, NULL, NULL, '2026-05-07 09:09:09', '2026-05-08 02:49:06'),
(18, 'Roda mas', 'Situbondo', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:49:37', '2026-05-08 02:49:37'),
(19, 'Piala Motor', 'Asembagus, situbondo', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:50:23', '2026-05-08 02:50:23'),
(20, 'Karsa motor', 'Rogojampi Banyuwangi', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:52:08', '2026-05-08 02:52:08'),
(21, 'Mandiri motor', 'Genteng, Banyuwangi', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:53:14', '2026-05-08 02:53:14'),
(22, 'Maju jaya sempolan', 'Jember', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:54:43', '2026-05-08 02:54:43'),
(23, 'Sumber baru kalisat', 'Jember', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:55:08', '2026-05-08 02:55:08'),
(24, 'Sentausa motor', 'Jember', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:55:47', '2026-05-08 02:55:47'),
(25, 'Maju motor pasirian', 'Lumajang', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:56:39', '2026-05-08 02:56:39'),
(26, 'Sumber rejeki tongas', 'Probolinggo', NULL, NULL, NULL, NULL, NULL, '2026-05-08 02:57:28', '2026-05-08 02:57:28'),
(27, 'Subur makmur', 'Tulung Agung', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:00:40', '2026-05-08 03:00:40'),
(28, 'Sri rejeki motor', 'Tulungagung', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:01:14', '2026-05-08 03:01:14'),
(29, 'Terminal motor', 'Ngunut, Tulungagung', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:01:44', '2026-05-08 03:01:44'),
(30, 'Energi motor', 'Kecamatan bandung, Tulungagung', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:04:31', '2026-05-08 03:04:31'),
(31, 'Kranding motor', 'Trenggalek', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:05:10', '2026-05-08 03:05:10'),
(32, 'Sinar jaya diesel', 'Trenggalek', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:05:30', '2026-05-08 03:05:30'),
(33, 'Maju jaya oli', 'Trenggalek', NULL, NULL, NULL, NULL, 'Pak duki', '2026-05-08 03:06:05', '2026-05-08 03:06:05'),
(34, 'Mentaya motor', 'Trenggalek', NULL, NULL, NULL, NULL, 'Pak jumilan', '2026-05-08 03:13:11', '2026-05-08 03:13:11'),
(35, 'Mentaya motor', 'Trenggalek', NULL, NULL, NULL, NULL, 'Pak jumilan', '2026-05-08 03:13:12', '2026-05-08 03:13:12'),
(36, 'Intan motor', 'Ponorogo', NULL, NULL, NULL, NULL, 'Mbak intan', '2026-05-08 03:13:45', '2026-05-08 03:13:45'),
(37, 'Anugerah motor', 'Ponorogo', NULL, NULL, NULL, NULL, 'Ai jejing', '2026-05-08 03:14:29', '2026-05-08 03:14:29'),
(38, 'Union jaya motor', 'Ponorogo', NULL, NULL, NULL, NULL, 'Ko andy', '2026-05-08 03:16:12', '2026-05-08 03:16:12'),
(46, 'Yoga motor', 'Madiun', NULL, NULL, NULL, NULL, 'Pak slamet', '2026-05-08 03:20:11', '2026-05-08 03:20:11'),
(47, 'SAE MOTOR PAGOTAN', 'Madiun', NULL, NULL, NULL, NULL, 'Bu dewi', '2026-05-08 03:20:45', '2026-05-08 03:20:45'),
(48, 'Asia jaya motor', 'Jombang', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:31:00', '2026-05-08 03:31:00'),
(49, 'Panca jaya motor', 'Ngawi', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:34:38', '2026-05-08 03:34:38'),
(50, 'Bumi mas motor', 'Ngawi', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:34:59', '2026-05-08 03:34:59'),
(51, 'Sinar harapan Turen', 'Turen', NULL, NULL, NULL, NULL, NULL, '2026-05-08 03:35:29', '2026-05-08 03:35:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `foto`, `level`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', NULL, '$2y$10$dVNq9CaTP2aI/IZCqGKpReFKoeLsZVc6GHmkOWkunQP3shy7uJaUS', '/img/logo.png', 1, NULL, NULL, NULL, NULL, NULL, '2026-01-30 02:23:19', '2026-01-30 02:34:48'),
(2, 'Bertone', 'bertone@gmail.com', NULL, '$2y$10$71M72tsoY/qFX3ea48oxcue6xN.1WTZQaPQryTqZqzyp9fkil40kC', '/img/logo.png', 1, NULL, NULL, NULL, NULL, NULL, '2026-01-30 02:23:19', '2026-02-01 10:46:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `kategori_nama_kategori_unique` (`nama_kategori`);

--
-- Indexes for table `kunjungans`
--
ALTER TABLE `kunjungans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjungans_tanggal_kunjungan_index` (`tanggal_kunjungan`),
  ADD KEY `kunjungans_toko_id_index` (`toko_id`);

--
-- Indexes for table `kunjungan_details`
--
ALTER TABLE `kunjungan_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kunjungan_details_kunjungan_id_index` (`kunjungan_id`),
  ADD KEY `kunjungan_details_produk_id_index` (`produk_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `produk_nama_produk_unique` (`nama_produk`),
  ADD UNIQUE KEY `produk_kode_produk_unique` (`kode_produk`),
  ADD KEY `produk_id_kategori_foreign` (`id_kategori`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_setting`);

--
-- Indexes for table `tokos`
--
ALTER TABLE `tokos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `kunjungans`
--
ALTER TABLE `kunjungans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `kunjungan_details`
--
ALTER TABLE `kunjungan_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=282;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_setting` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tokos`
--
ALTER TABLE `tokos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kunjungans`
--
ALTER TABLE `kunjungans`
  ADD CONSTRAINT `kunjungans_toko_id_foreign` FOREIGN KEY (`toko_id`) REFERENCES `tokos` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kunjungan_details`
--
ALTER TABLE `kunjungan_details`
  ADD CONSTRAINT `kunjungan_details_kunjungan_id_foreign` FOREIGN KEY (`kunjungan_id`) REFERENCES `kunjungans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `kunjungan_details_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id_produk`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_id_kategori_foreign` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
