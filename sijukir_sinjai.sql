-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2026 at 12:46 AM
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
-- Database: `sijukir_sinjai`
--

-- --------------------------------------------------------

--
-- Table structure for table `area_asets`
--

CREATE TABLE `area_asets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `aset_daerah_id` bigint(20) UNSIGNED NOT NULL,
  `kode_area` varchar(80) NOT NULL,
  `nama_area` varchar(255) NOT NULL,
  `luas_m2` decimal(15,2) DEFAULT NULL,
  `tarif_sewa` decimal(15,2) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'tersedia',
  `pemanfaat_terakhir` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `aset_daerahs`
--

CREATE TABLE `aset_daerahs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_aset` varchar(80) NOT NULL,
  `nama_aset` varchar(255) NOT NULL,
  `jenis_aset` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `nomor_register` varchar(255) DEFAULT NULL,
  `luas_total_m2` decimal(15,2) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `auditable_type` varchar(255) NOT NULL,
  `auditable_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(30) NOT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `auditable_type`, `auditable_id`, `action`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'App\\Models\\Jukir', 3, 'deleted', '{\"id\":3,\"kode_jukir\":\"JKR-00001\",\"jenis_jukir_id\":1,\"nik\":\"7307054107620013\",\"nama\":\"Jukir Uji\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-12-02T16:00:00.000000Z\",\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. AP Pettarani\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"no_hp\":\"082215766363\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"created_at\":\"2026-08-19T07:06:52.000000Z\",\"updated_at\":\"2026-08-19T07:06:52.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 09:40:59', '2026-08-21 09:40:59'),
(2, 1, 'App\\Models\\Jukir', 4, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307010101900001\",\"nama\":\"Ahmad Petugas Test\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-01-01 00:00:00\",\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. Persatuan Raya\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"64\",\"no_hp\":\"081234567801\",\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas tetap\",\"kode_jukir\":\"JKR-00001\",\"updated_at\":\"2026-08-21 18:39:47\",\"created_at\":\"2026-08-21 18:39:47\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 10:39:47', '2026-08-21 10:39:47'),
(3, 1, 'App\\Models\\Jukir', 5, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307010202920002\",\"nama\":\"Siti Petugas Test\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-02-02 00:00:00\",\"jenis_kelamin\":\"P\",\"alamat\":\"Jl. Sultan Hasanuddin\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"no_hp\":\"081234567802\",\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas\",\"kode_jukir\":\"JKR-00002\",\"updated_at\":\"2026-08-21 18:41:30\",\"created_at\":\"2026-08-21 18:41:30\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 10:41:30', '2026-08-21 10:41:30'),
(4, 1, 'App\\Models\\JenisParkir', 4, 'created', NULL, '{\"kode\":\"USAHA-TEST\",\"nama\":\"Parkir Kegiatan Usaha Test\",\"deskripsi\":\"Parkir yang berkaitan dengan kegiatan usaha\",\"status\":\"1\",\"updated_at\":\"2026-08-21 18:44:16\",\"created_at\":\"2026-08-21 18:44:16\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 10:44:16', '2026-08-21 10:44:16'),
(5, 1, 'App\\Models\\TitikParkir', 3, 'created', NULL, '{\"kode_titik\":\"TP-TEST-001\",\"nama\":\"Parkir Pasar Sentral Test\",\"alamat\":\"Jl. Persatuan, Kabupaten Sinjai\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"64\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.1245000\",\"longitude\":\"120.2535000\",\"status\":\"aktif\",\"kapasitas_motor\":\"50\",\"kapasitas_mobil_kecil\":\"20\",\"kapasitas_mobil_besar\":\"5\",\"kapasitas_total\":\"105\",\"nama_pengelola\":\"Ahmad\",\"telepon_pengelola\":\"081234567801\",\"potensi_harian\":\"185000\",\"potensi_bulanan\":\"2220000\",\"keterangan\":null,\"updated_at\":\"2026-08-21 18:53:21\",\"created_at\":\"2026-08-21 18:53:21\",\"id\":3}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 10:53:21', '2026-08-21 10:53:21'),
(6, 1, 'App\\Models\\TitikParkir', 4, 'created', NULL, '{\"kode_titik\":\"TP-TEST-002\",\"nama\":\"Area Parkir Terminal Test\",\"alamat\":\"Kawasan Terminal Sinjai\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"latitude\":\"-5.1155000\",\"longitude\":\"120.2515000\",\"status\":\"aktif\",\"kapasitas_motor\":\"40\",\"kapasitas_mobil_kecil\":\"30\",\"kapasitas_mobil_besar\":\"10\",\"kapasitas_total\":\"80\",\"nama_pengelola\":\"Budi\",\"telepon_pengelola\":\"081234567803\",\"potensi_harian\":\"220000\",\"potensi_bulanan\":\"2640000\",\"keterangan\":null,\"updated_at\":\"2026-08-21 18:56:53\",\"created_at\":\"2026-08-21 18:56:53\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 10:56:53', '2026-08-21 10:56:53'),
(7, 1, 'App\\Models\\WajibPajak', 1, 'created', NULL, '{\"nama\":\"PT Sinjai Parkir Test\",\"npwp\":\"123456789012345\",\"nik\":\"WP-TEST-001\",\"alamat\":\"Jl. Persatuan No. 10\",\"nomor_telepon\":\"081234567804\",\"email\":\"pajak-test@example.com\",\"status\":\"aktif\",\"catatan\":null,\"updated_at\":\"2026-08-21 18:58:28\",\"created_at\":\"2026-08-21 18:58:28\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 10:58:28', '2026-08-21 10:58:28'),
(8, 1, 'App\\Models\\ObjekPendapatan', 1, 'created', NULL, '{\"sumber_pemasukan_id\":\"3\",\"wajib_pajak_id\":null,\"kode\":\"PAJAK-TEST-001\",\"nama\":\"Area Parkir Mall Sinjai Test\",\"tipe\":\"objek_pajak\",\"alamat\":\"Jl. Persatuan No. 20\",\"nama_pengelola\":\"PT Sinjai Parkir Test\",\"nomor_identitas\":\"WP-TEST-001\",\"npwp\":\"123456789012345\",\"nop\":\"NOP-730701-TEST-001\",\"masa_pajak_mulai\":\"2026-01-01 00:00:00\",\"masa_pajak_sampai\":null,\"tarif_pajak\":\"10\",\"jenis_usaha\":null,\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":null,\"nomor_kontrak\":null,\"kontrak_mulai\":null,\"kontrak_selesai\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"status\":\"aktif\",\"updated_at\":\"2026-08-21 19:01:26\",\"created_at\":\"2026-08-21 19:01:26\",\"id\":1}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:01:26', '2026-08-21 11:01:26'),
(9, 1, 'App\\Models\\ObjekPendapatan', 1, 'updated', '{\"id\":1,\"sumber_pemasukan_id\":3,\"wajib_pajak_id\":null,\"kode\":\"PAJAK-TEST-001\",\"nama\":\"Area Parkir Mall Sinjai Test\",\"tipe\":\"objek_pajak\",\"alamat\":\"Jl. Persatuan No. 20\",\"nama_pengelola\":\"PT Sinjai Parkir Test\",\"nomor_identitas\":\"WP-TEST-001\",\"npwp\":\"123456789012345\",\"nop\":\"NOP-730701-TEST-001\",\"masa_pajak_mulai\":\"2025-12-31T16:00:00.000000Z\",\"masa_pajak_sampai\":null,\"tarif_pajak\":\"10.00\",\"jenis_usaha\":null,\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":null,\"nomor_kontrak\":null,\"kontrak_mulai\":null,\"kontrak_selesai\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"status\":\"aktif\",\"metadata\":null,\"created_at\":\"2026-08-21T11:01:26.000000Z\",\"updated_at\":\"2026-08-21T11:01:26.000000Z\"}', '{\"tarif_sewa\":\"50000\",\"potensi_harian\":\"50000\",\"potensi_bulanan\":\"150000\",\"updated_at\":\"2026-08-21 19:02:48\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:02:48', '2026-08-21 11:02:48'),
(10, 1, 'App\\Models\\ObjekPendapatan', 2, 'created', NULL, '{\"sumber_pemasukan_id\":\"4\",\"wajib_pajak_id\":null,\"kode\":\"USAHA-TEST-001\",\"nama\":\"Kios Terminal Test\",\"tipe\":\"tempat_usaha\",\"alamat\":\"Area Terminal Sinjai\",\"nama_pengelola\":\"CV Usaha Sinjai Test\",\"nomor_identitas\":null,\"npwp\":null,\"nop\":null,\"masa_pajak_mulai\":null,\"masa_pajak_sampai\":null,\"tarif_pajak\":null,\"jenis_usaha\":\"Kios makanan\",\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":\"1500000\",\"nomor_kontrak\":null,\"kontrak_mulai\":\"2026-01-01 00:00:00\",\"kontrak_selesai\":null,\"potensi_harian\":\"50000\",\"potensi_bulanan\":\"1500000\",\"status\":\"aktif\",\"updated_at\":\"2026-08-21 19:04:34\",\"created_at\":\"2026-08-21 19:04:34\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:04:34', '2026-08-21 11:04:34'),
(11, 1, 'App\\Models\\PenempatanJukir', 2, 'created', NULL, '{\"jukir_id\":\"4\",\"titik_parkir_id\":\"3\",\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-08-21 19:05:30\",\"created_at\":\"2026-08-21 19:05:30\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:05:30', '2026-08-21 11:05:30'),
(12, 1, 'App\\Models\\PenempatanJukir', 3, 'created', NULL, '{\"jukir_id\":\"5\",\"titik_parkir_id\":\"4\",\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-08-21 19:05:58\",\"created_at\":\"2026-08-21 19:05:58\",\"id\":3}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:05:58', '2026-08-21 11:05:58'),
(13, 1, 'App\\Models\\Setoran', 2, 'created', NULL, '{\"sumber_pemasukan_id\":\"2\",\"objek_pendapatan_id\":null,\"jukir_id\":\"4\",\"titik_parkir_id\":\"3\",\"tanggal\":\"2026-08-21 00:00:00\",\"jumlah_motor\":\"100\",\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":\"25\",\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":325000,\"jumlah_setoran\":300000,\"selisih\":25000,\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-08-21 19:12:23\",\"created_at\":\"2026-08-21 19:12:23\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:12:23', '2026-08-21 11:12:23'),
(14, 1, 'App\\Models\\Setoran', 3, 'created', NULL, '{\"sumber_pemasukan_id\":\"1\",\"objek_pendapatan_id\":null,\"jukir_id\":\"5\",\"titik_parkir_id\":\"4\",\"tanggal\":\"2026-08-21 00:00:00\",\"jumlah_motor\":\"80\",\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":\"30\",\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":330000,\"jumlah_setoran\":320000,\"selisih\":10000,\"status\":\"belum_verifikasi\",\"keterangan\":\"Setoran uji parkir khusus |\",\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-08-21 19:13:36\",\"created_at\":\"2026-08-21 19:13:36\",\"id\":3}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:13:36', '2026-08-21 11:13:36'),
(15, 1, 'App\\Models\\Setoran', 4, 'created', NULL, '{\"sumber_pemasukan_id\":\"4\",\"objek_pendapatan_id\":\"2\",\"jukir_id\":null,\"titik_parkir_id\":null,\"tanggal\":\"2026-08-21 00:00:00\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":150000,\"jumlah_setoran\":150000,\"selisih\":0,\"status\":\"belum_verifikasi\",\"keterangan\":\"Setoran sewa tempat usaha test\",\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-08-21 19:16:45\",\"created_at\":\"2026-08-21 19:16:45\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:16:45', '2026-08-21 11:16:45'),
(16, 1, 'App\\Models\\Setoran', 4, 'updated', '{\"id\":4,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":2,\"jukir_id\":null,\"titik_parkir_id\":null,\"tanggal\":\"2026-08-20T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"150000.00\",\"jumlah_setoran\":\"150000.00\",\"selisih\":\"0.00\",\"status\":\"belum_verifikasi\",\"keterangan\":\"Setoran sewa tempat usaha test\",\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-08-21T11:16:45.000000Z\",\"updated_at\":\"2026-08-21T11:16:45.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-08-21 19:19:13\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-08-21 19:19:13\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:19:13', '2026-08-21 11:19:13'),
(17, 1, 'App\\Models\\Setoran', 3, 'updated', '{\"id\":3,\"sumber_pemasukan_id\":1,\"objek_pendapatan_id\":null,\"jukir_id\":5,\"titik_parkir_id\":4,\"tanggal\":\"2026-08-20T16:00:00.000000Z\",\"jumlah_motor\":80,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":30,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"330000.00\",\"jumlah_setoran\":\"320000.00\",\"selisih\":\"10000.00\",\"status\":\"belum_verifikasi\",\"keterangan\":\"Setoran uji parkir khusus |\",\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-08-21T11:13:36.000000Z\",\"updated_at\":\"2026-08-21T11:13:36.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-08-21 19:19:24\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-08-21 19:19:24\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:19:24', '2026-08-21 11:19:24'),
(18, 1, 'App\\Models\\Setoran', 2, 'updated', '{\"id\":2,\"sumber_pemasukan_id\":2,\"objek_pendapatan_id\":null,\"jukir_id\":4,\"titik_parkir_id\":3,\"tanggal\":\"2026-08-20T16:00:00.000000Z\",\"jumlah_motor\":100,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":25,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"325000.00\",\"jumlah_setoran\":\"300000.00\",\"selisih\":\"25000.00\",\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-08-21T11:12:23.000000Z\",\"updated_at\":\"2026-08-21T11:12:23.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-08-21 19:19:36\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-08-21 19:19:36\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 11:19:36', '2026-08-21 11:19:36'),
(19, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-21 12:04:42', '2026-08-21 12:04:42'),
(20, 1, 'App\\Models\\TitikParkir', 4, 'updated', '{\"id\":4,\"kode_titik\":\"TP-TEST-002\",\"nama\":\"Area Parkir Terminal Test\",\"alamat\":\"Kawasan Terminal Sinjai\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1155000\",\"longitude\":\"120.2515000\",\"status\":\"aktif\",\"kapasitas_motor\":40,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":30,\"kapasitas_mobil_besar\":10,\"kapasitas_total\":80,\"nama_pengelola\":\"Budi\",\"telepon_pengelola\":\"081234567803\",\"potensi_harian\":\"220000.00\",\"potensi_bulanan\":\"2640000.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:56:53.000000Z\",\"updated_at\":\"2026-08-21T10:56:53.000000Z\"}', '{\"kode_titik\":\"TP-001\",\"nama\":\"Taman Topekkong\",\"alamat\":\"Taman Topekkong\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12085\",\"longitude\":\"120.25174\",\"kapasitas_motor\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"potensi_harian\":null,\"potensi_bulanan\":null,\"updated_at\":\"2026-08-24 19:26:51\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:26:51', '2026-08-24 11:26:51'),
(21, 1, 'App\\Models\\TitikParkir', 3, 'updated', '{\"id\":3,\"kode_titik\":\"TP-TEST-001\",\"nama\":\"Parkir Pasar Sentral Test\",\"alamat\":\"Jl. Persatuan, Kabupaten Sinjai\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1245000\",\"longitude\":\"120.2535000\",\"status\":\"aktif\",\"kapasitas_motor\":50,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":20,\"kapasitas_mobil_besar\":5,\"kapasitas_total\":105,\"nama_pengelola\":\"Ahmad\",\"telepon_pengelola\":\"081234567801\",\"potensi_harian\":\"185000.00\",\"potensi_bulanan\":\"2220000.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:53:21.000000Z\",\"updated_at\":\"2026-08-21T10:53:21.000000Z\"}', '{\"kode_titik\":\"TP-SU-002\",\"nama\":\"Toko Kosmetik Sri\",\"alamat\":\"Sinjai Utara\",\"latitude\":\"-5.12063\",\"longitude\":\"120.25412\",\"kapasitas_motor\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"potensi_harian\":null,\"potensi_bulanan\":null,\"updated_at\":\"2026-08-24 19:28:32\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:28:32', '2026-08-24 11:28:32'),
(22, 1, 'App\\Models\\TitikParkir', 4, 'updated', '{\"id\":4,\"kode_titik\":\"TP-001\",\"nama\":\"Taman Topekkong\",\"alamat\":\"Taman Topekkong\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1208500\",\"longitude\":\"120.2517400\",\"status\":\"aktif\",\"kapasitas_motor\":null,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"nama_pengelola\":\"Budi\",\"telepon_pengelola\":\"081234567803\",\"potensi_harian\":null,\"potensi_bulanan\":null,\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:56:53.000000Z\",\"updated_at\":\"2026-08-24T11:26:51.000000Z\"}', '{\"alamat\":\"Kec. Sinjai Utara\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"updated_at\":\"2026-08-24 19:29:23\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:29:23', '2026-08-24 11:29:23'),
(23, 1, 'App\\Models\\TitikParkir', 5, 'created', NULL, '{\"kode_titik\":\"TP-SU-003\",\"nama\":\"Klinik Dokter Nanang\",\"alamat\":\"Jl. Persatuan Raya No. 56\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"64\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12002\",\"longitude\":\"120.25564\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:33:17\",\"created_at\":\"2026-08-24 19:33:17\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:33:17', '2026-08-24 11:33:17'),
(24, 1, 'App\\Models\\TitikParkir', 4, 'updated', '{\"id\":4,\"kode_titik\":\"TP-001\",\"nama\":\"Taman Topekkong\",\"alamat\":\"Kec. Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1208500\",\"longitude\":\"120.2517400\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"Budi\",\"telepon_pengelola\":\"081234567803\",\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:56:53.000000Z\",\"updated_at\":\"2026-08-24T11:29:23.000000Z\"}', '{\"kode_titik\":\"TP-SU-001\",\"nama\":\"Taman Topekkong Demma\",\"alamat\":\"Jl. Bhayangkara\",\"kelurahan_id\":\"65\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"updated_at\":\"2026-08-24 19:35:27\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:35:27', '2026-08-24 11:35:27'),
(25, 1, 'App\\Models\\TitikParkir', 3, 'updated', '{\"id\":3,\"kode_titik\":\"TP-SU-002\",\"nama\":\"Toko Kosmetik Sri\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1206300\",\"longitude\":\"120.2541200\",\"status\":\"aktif\",\"kapasitas_motor\":null,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"nama_pengelola\":\"Ahmad\",\"telepon_pengelola\":\"081234567801\",\"potensi_harian\":null,\"potensi_bulanan\":null,\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:53:21.000000Z\",\"updated_at\":\"2026-08-24T11:28:32.000000Z\"}', '{\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"updated_at\":\"2026-08-24 19:36:06\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:36:06', '2026-08-24 11:36:06'),
(26, 1, 'App\\Models\\TitikParkir', 6, 'created', NULL, '{\"kode_titik\":\"TP-SU-004\",\"nama\":\"RM Legenda\",\"alamat\":\"Kec. Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.1199\",\"longitude\":\"120.25585\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:38:23\",\"created_at\":\"2026-08-24 19:38:23\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:38:23', '2026-08-24 11:38:23'),
(27, 1, 'App\\Models\\TitikParkir', 3, 'updated', '{\"id\":3,\"kode_titik\":\"TP-SU-002\",\"nama\":\"Toko Kosmetik Sri\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1206300\",\"longitude\":\"120.2541200\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:53:21.000000Z\",\"updated_at\":\"2026-08-24T11:36:06.000000Z\"}', '{\"alamat\":\"Jl. G. Bawakaraeng\",\"updated_at\":\"2026-08-24 19:39:14\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:39:14', '2026-08-24 11:39:14'),
(28, 1, 'App\\Models\\TitikParkir', 6, 'updated', '{\"id\":6,\"kode_titik\":\"TP-SU-004\",\"nama\":\"RM Legenda\",\"alamat\":\"Kec. Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1199000\",\"longitude\":\"120.2558500\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:38:23.000000Z\",\"updated_at\":\"2026-08-24T11:38:23.000000Z\"}', '{\"alamat\":\"Jl. Persatuan Raya\",\"updated_at\":\"2026-08-24 19:39:58\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:39:58', '2026-08-24 11:39:58'),
(29, 1, 'App\\Models\\TitikParkir', 7, 'created', NULL, '{\"kode_titik\":\"TP-SU-005\",\"nama\":\"Kuliner Hisana,Momoyo,Pelangi\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.11739\",\"longitude\":\"120.25687\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:41:34\",\"created_at\":\"2026-08-24 19:41:34\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:41:34', '2026-08-24 11:41:34'),
(30, 1, 'App\\Models\\TitikParkir', 7, 'updated', '{\"id\":7,\"kode_titik\":\"TP-SU-005\",\"nama\":\"Kuliner Hisana,Momoyo,Pelangi\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1173900\",\"longitude\":\"120.2568700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:41:34.000000Z\",\"updated_at\":\"2026-08-24T11:41:34.000000Z\"}', '{\"alamat\":\"Jl. Persatuan Raya\",\"updated_at\":\"2026-08-24 19:42:03\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:42:03', '2026-08-24 11:42:03'),
(31, 1, 'App\\Models\\TitikParkir', 8, 'created', NULL, '{\"kode_titik\":\"TP-SU-006\",\"nama\":\"RM PASUNDAN & ALFAMIDI\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.11523\",\"longitude\":\"120.25834\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:43:42\",\"created_at\":\"2026-08-24 19:43:42\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:43:42', '2026-08-24 11:43:42'),
(32, 1, 'App\\Models\\TitikParkir', 8, 'updated', '{\"id\":8,\"kode_titik\":\"TP-SU-006\",\"nama\":\"RM PASUNDAN & ALFAMIDI\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1152300\",\"longitude\":\"120.2583400\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:43:42.000000Z\",\"updated_at\":\"2026-08-24T11:43:42.000000Z\"}', '{\"alamat\":\"Jl. Sungai Tangka\",\"kelurahan_id\":\"64\",\"updated_at\":\"2026-08-24 19:44:59\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:44:59', '2026-08-24 11:44:59'),
(33, 1, 'App\\Models\\TitikParkir', 9, 'created', NULL, '{\"kode_titik\":\"TP-SU-007\",\"nama\":\"Dsimple & Karampuang\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"64\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12648\",\"longitude\":\"120.25098\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:46:34\",\"created_at\":\"2026-08-24 19:46:34\",\"id\":9}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:46:34', '2026-08-24 11:46:34'),
(34, 1, 'App\\Models\\TitikParkir', 9, 'updated', '{\"id\":9,\"kode_titik\":\"TP-SU-007\",\"nama\":\"Dsimple & Karampuang\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1264800\",\"longitude\":\"120.2509800\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:46:34.000000Z\",\"updated_at\":\"2026-08-24T11:46:34.000000Z\"}', '{\"alamat\":\"Jl. Baso Kalaka\",\"updated_at\":\"2026-08-24 19:47:34\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:47:34', '2026-08-24 11:47:34'),
(35, 1, 'App\\Models\\TitikParkir', 10, 'created', NULL, '{\"kode_titik\":\"TP-SU-008\",\"nama\":\"CAFE DR HAMKA 1\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"64\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12559\",\"longitude\":\"120.25071\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:48:55\",\"created_at\":\"2026-08-24 19:48:55\",\"id\":10}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:48:55', '2026-08-24 11:48:55'),
(36, 1, 'App\\Models\\TitikParkir', 10, 'updated', '{\"id\":10,\"kode_titik\":\"TP-SU-008\",\"nama\":\"CAFE DR HAMKA 1\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1255900\",\"longitude\":\"120.2507100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:48:55.000000Z\",\"updated_at\":\"2026-08-24T11:48:55.000000Z\"}', '{\"alamat\":\"Jl. Dr. Hamka\",\"updated_at\":\"2026-08-24 19:49:29\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:49:29', '2026-08-24 11:49:29'),
(37, 1, 'App\\Models\\TitikParkir', 10, 'updated', '{\"id\":10,\"kode_titik\":\"TP-SU-008\",\"nama\":\"CAFE DR HAMKA 1\",\"alamat\":\"Jl. Dr. Hamka\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1255900\",\"longitude\":\"120.2507100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:48:55.000000Z\",\"updated_at\":\"2026-08-24T11:49:29.000000Z\"}', '{\"alamat\":\"Jl. Dokter Hamka\",\"updated_at\":\"2026-08-24 19:49:51\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:49:51', '2026-08-24 11:49:51'),
(38, 1, 'App\\Models\\TitikParkir', 11, 'created', NULL, '{\"kode_titik\":\"TP-SU-009\",\"nama\":\"DR HAMKA 2\",\"alamat\":\"Jl. Dokter Hamka\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12567\",\"longitude\":\"120.25076\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:51:18\",\"created_at\":\"2026-08-24 19:51:18\",\"id\":11}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:51:18', '2026-08-24 11:51:18'),
(39, 1, 'App\\Models\\TitikParkir', 11, 'updated', '{\"id\":11,\"kode_titik\":\"TP-SU-009\",\"nama\":\"DR HAMKA 2\",\"alamat\":\"Jl. Dokter Hamka\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1256700\",\"longitude\":\"120.2507600\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:51:18.000000Z\",\"updated_at\":\"2026-08-24T11:51:18.000000Z\"}', '{\"kelurahan_id\":\"67\",\"updated_at\":\"2026-08-24 19:52:08\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:52:08', '2026-08-24 11:52:08'),
(40, 1, 'App\\Models\\TitikParkir', 10, 'updated', '{\"id\":10,\"kode_titik\":\"TP-SU-008\",\"nama\":\"CAFE DR HAMKA 1\",\"alamat\":\"Jl. Dokter Hamka\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1255900\",\"longitude\":\"120.2507100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:48:55.000000Z\",\"updated_at\":\"2026-08-24T11:49:51.000000Z\"}', '{\"kelurahan_id\":\"67\",\"updated_at\":\"2026-08-24 19:52:21\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:52:21', '2026-08-24 11:52:21'),
(41, 1, 'App\\Models\\TitikParkir', 12, 'created', NULL, '{\"kode_titik\":\"TP-SU-010\",\"nama\":\"JL. Tondong Ujung\",\"alamat\":\"Jl. Tondong Ujung\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12536\",\"longitude\":\"120.25011\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:53:42\",\"created_at\":\"2026-08-24 19:53:42\",\"id\":12}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:53:42', '2026-08-24 11:53:42'),
(42, 1, 'App\\Models\\TitikParkir', 12, 'updated', '{\"id\":12,\"kode_titik\":\"TP-SU-010\",\"nama\":\"JL. Tondong Ujung\",\"alamat\":\"Jl. Tondong Ujung\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1253600\",\"longitude\":\"120.2501100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:53:42.000000Z\",\"updated_at\":\"2026-08-24T11:53:42.000000Z\"}', '{\"nama\":\"Tondong Ujung\",\"alamat\":\"Jl. Haji Abdul Latief\",\"updated_at\":\"2026-08-24 19:54:48\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:54:48', '2026-08-24 11:54:48'),
(43, 1, 'App\\Models\\TitikParkir', 12, 'updated', '{\"id\":12,\"kode_titik\":\"TP-SU-010\",\"nama\":\"Tondong Ujung\",\"alamat\":\"Jl. Haji Abdul Latief\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1253600\",\"longitude\":\"120.2501100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:53:42.000000Z\",\"updated_at\":\"2026-08-24T11:54:48.000000Z\"}', '{\"alamat\":\"Jl. Haji Andi Abdul Latief\",\"updated_at\":\"2026-08-24 19:55:20\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:55:20', '2026-08-24 11:55:20'),
(44, 1, 'App\\Models\\TitikParkir', 12, 'updated', '{\"id\":12,\"kode_titik\":\"TP-SU-010\",\"nama\":\"Tondong Ujung\",\"alamat\":\"Jl. Haji Andi Abdul Latief\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1253600\",\"longitude\":\"120.2501100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:53:42.000000Z\",\"updated_at\":\"2026-08-24T11:55:20.000000Z\"}', '{\"alamat\":\"Jl. H.A. Abdul Latief\",\"updated_at\":\"2026-08-24 19:56:00\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:56:00', '2026-08-24 11:56:00'),
(45, 1, 'App\\Models\\TitikParkir', 13, 'created', NULL, '{\"kode_titik\":\"TP-SU-011\",\"nama\":\"Kaytama\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.1229\",\"longitude\":\"120.25107\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:57:24\",\"created_at\":\"2026-08-24 19:57:24\",\"id\":13}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:57:24', '2026-08-24 11:57:24'),
(46, 1, 'App\\Models\\TitikParkir', 13, 'updated', '{\"id\":13,\"kode_titik\":\"TP-SU-011\",\"nama\":\"Kaytama\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1229000\",\"longitude\":\"120.2510700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:57:24.000000Z\",\"updated_at\":\"2026-08-24T11:57:24.000000Z\"}', '{\"alamat\":\"Jl. Jend. Sudirman\",\"updated_at\":\"2026-08-24 19:58:07\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:58:07', '2026-08-24 11:58:07'),
(47, 1, 'App\\Models\\TitikParkir', 14, 'created', NULL, '{\"kode_titik\":\"TP-SU-012\",\"nama\":\"Hana dan\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12134\",\"longitude\":\"120.24895\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 19:59:31\",\"created_at\":\"2026-08-24 19:59:31\",\"id\":14}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 11:59:31', '2026-08-24 11:59:31'),
(48, 1, 'App\\Models\\TitikParkir', 14, 'updated', '{\"id\":14,\"kode_titik\":\"TP-SU-012\",\"nama\":\"Hana dan\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1213400\",\"longitude\":\"120.2489500\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:59:31.000000Z\",\"updated_at\":\"2026-08-24T11:59:31.000000Z\"}', '{\"alamat\":\"Jl. H. A. Abdul Latif\",\"kelurahan_id\":\"67\",\"updated_at\":\"2026-08-24 20:00:04\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:00:04', '2026-08-24 12:00:04'),
(49, 1, 'App\\Models\\TitikParkir', 15, 'created', NULL, '{\"kode_titik\":\"TP-SU-013\",\"nama\":\"PRAKTEK DOKTER\\/KLINIK\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12503\",\"longitude\":\"120.24807\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:01:15\",\"created_at\":\"2026-08-24 20:01:15\",\"id\":15}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:01:16', '2026-08-24 12:01:16'),
(50, 1, 'App\\Models\\TitikParkir', 15, 'updated', '{\"id\":15,\"kode_titik\":\"TP-SU-013\",\"nama\":\"PRAKTEK DOKTER\\/KLINIK\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1250300\",\"longitude\":\"120.2480700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:01:15.000000Z\",\"updated_at\":\"2026-08-24T12:01:15.000000Z\"}', '{\"alamat\":\"Jl. A. Abdul Latief\",\"updated_at\":\"2026-08-24 20:02:23\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:02:23', '2026-08-24 12:02:23'),
(51, 1, 'App\\Models\\TitikParkir', 16, 'created', NULL, '{\"kode_titik\":\"TP-EKS-014\",\"nama\":\"ALun-ALun 1\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"5.12471\",\"longitude\":\"120.24837\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:04:30\",\"created_at\":\"2026-08-24 20:04:30\",\"id\":16}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:04:30', '2026-08-24 12:04:30'),
(52, 1, 'App\\Models\\TitikParkir', 16, 'updated', '{\"id\":16,\"kode_titik\":\"TP-EKS-014\",\"nama\":\"ALun-ALun 1\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"5.1247100\",\"longitude\":\"120.2483700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:04:30.000000Z\",\"updated_at\":\"2026-08-24T12:04:30.000000Z\"}', '{\"latitude\":\"-5.12471\",\"updated_at\":\"2026-08-24 20:04:59\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:04:59', '2026-08-24 12:04:59'),
(53, 1, 'App\\Models\\TitikParkir', 16, 'updated', '{\"id\":16,\"kode_titik\":\"TP-EKS-014\",\"nama\":\"ALun-ALun 1\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1247100\",\"longitude\":\"120.2483700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:04:30.000000Z\",\"updated_at\":\"2026-08-24T12:04:59.000000Z\"}', '{\"alamat\":\"Jl. A.Abdul Latief\",\"updated_at\":\"2026-08-24 20:07:28\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:07:28', '2026-08-24 12:07:28'),
(54, 1, 'App\\Models\\TitikParkir', 17, 'created', NULL, '{\"kode_titik\":\"TP-EKS-015\",\"nama\":\"ALUN-ALUN 2\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"5.12479\",\"longitude\":\"120.2486\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:08:36\",\"created_at\":\"2026-08-24 20:08:36\",\"id\":17}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:08:36', '2026-08-24 12:08:36'),
(55, 1, 'App\\Models\\TitikParkir', 17, 'updated', '{\"id\":17,\"kode_titik\":\"TP-EKS-015\",\"nama\":\"ALUN-ALUN 2\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"5.1247900\",\"longitude\":\"120.2486000\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:08:36.000000Z\",\"updated_at\":\"2026-08-24T12:08:36.000000Z\"}', '{\"latitude\":\"-5.12479\",\"updated_at\":\"2026-08-24 20:09:21\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:09:21', '2026-08-24 12:09:21'),
(56, 1, 'App\\Models\\TitikParkir', 16, 'updated', '{\"id\":16,\"kode_titik\":\"TP-EKS-014\",\"nama\":\"ALun-ALun 1\",\"alamat\":\"Jl. A.Abdul Latief\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1247100\",\"longitude\":\"120.2483700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:04:30.000000Z\",\"updated_at\":\"2026-08-24T12:07:28.000000Z\"}', '{\"nama\":\"ALUN-ALUN 1\",\"updated_at\":\"2026-08-24 20:11:35\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:11:35', '2026-08-24 12:11:35'),
(57, 1, 'App\\Models\\TitikParkir', 13, 'updated', '{\"id\":13,\"kode_titik\":\"TP-SU-011\",\"nama\":\"Kaytama\",\"alamat\":\"Jl. Jend. Sudirman\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1229000\",\"longitude\":\"120.2510700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:57:24.000000Z\",\"updated_at\":\"2026-08-24T11:58:07.000000Z\"}', '{\"nama\":\"KAYTAMA\",\"updated_at\":\"2026-08-24 20:11:53\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:11:53', '2026-08-24 12:11:53'),
(58, 1, 'App\\Models\\TitikParkir', 12, 'updated', '{\"id\":12,\"kode_titik\":\"TP-SU-010\",\"nama\":\"Tondong Ujung\",\"alamat\":\"Jl. H.A. Abdul Latief\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1253600\",\"longitude\":\"120.2501100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T11:53:42.000000Z\",\"updated_at\":\"2026-08-24T11:56:00.000000Z\"}', '{\"nama\":\"TONDONG UJUNG\",\"updated_at\":\"2026-08-24 20:12:13\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:12:13', '2026-08-24 12:12:13');
INSERT INTO `audit_logs` (`id`, `user_id`, `auditable_type`, `auditable_id`, `action`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(59, 1, 'App\\Models\\TitikParkir', 18, 'created', NULL, '{\"kode_titik\":\"TP-EKS-016\",\"nama\":\"ALUN-ALUN 3\",\"alamat\":\"Jl. H.A. Abdul Latief\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12495\",\"longitude\":\"120.24902\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:13:43\",\"created_at\":\"2026-08-24 20:13:43\",\"id\":18}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:13:43', '2026-08-24 12:13:43'),
(60, 1, 'App\\Models\\TitikParkir', 19, 'created', NULL, '{\"kode_titik\":\"TP-EKS-017\",\"nama\":\"ALUN-ALUN 4\",\"alamat\":\"Sinjai Utara\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12511\",\"longitude\":\"120.24942\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:15:26\",\"created_at\":\"2026-08-24 20:15:26\",\"id\":19}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:15:26', '2026-08-24 12:15:26'),
(61, 1, 'App\\Models\\TitikParkir', 20, 'created', NULL, '{\"kode_titik\":\"TP-EKS-018\",\"nama\":\"ALUN-ALUN 5\",\"alamat\":\"Jl, H.A. Abdul Latief\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12507\",\"longitude\":\"120.24977\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:23:22\",\"created_at\":\"2026-08-24 20:23:22\",\"id\":20}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:23:22', '2026-08-24 12:23:22'),
(62, 1, 'App\\Models\\TitikParkir', 21, 'created', NULL, '{\"kode_titik\":\"TP-EKS-019\",\"nama\":\"ALUN-ALUN 6\",\"alamat\":\"Jl. H.A. Abdul Latief\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"67\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12516\",\"longitude\":\"120.24979\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:25:08\",\"created_at\":\"2026-08-24 20:25:08\",\"id\":21}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:25:08', '2026-08-24 12:25:08'),
(63, 1, 'App\\Models\\TitikParkir', 22, 'created', NULL, '{\"kode_titik\":\"TP-EKS-020\",\"nama\":\"PASAR ATAS 1\",\"alamat\":\"JL. sentral\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12014\",\"longitude\":\"120.25179\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:29:06\",\"created_at\":\"2026-08-24 20:29:06\",\"id\":22}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:29:06', '2026-08-24 12:29:06'),
(64, 1, 'App\\Models\\TitikParkir', 22, 'updated', '{\"id\":22,\"kode_titik\":\"TP-EKS-020\",\"nama\":\"PASAR ATAS 1\",\"alamat\":\"JL. sentral\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1201400\",\"longitude\":\"120.2517900\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:29:06.000000Z\",\"updated_at\":\"2026-08-24T12:29:06.000000Z\"}', '{\"alamat\":\"Jl. Bulu Bicara\",\"updated_at\":\"2026-08-24 20:30:05\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:30:05', '2026-08-24 12:30:05'),
(65, 1, 'App\\Models\\TitikParkir', 23, 'created', NULL, '{\"kode_titik\":\"TP-EKS-021\",\"nama\":\"PASAR ATAS 2\",\"alamat\":\"Bongki\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12005\",\"longitude\":\"120.25181\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:30:58\",\"created_at\":\"2026-08-24 20:30:58\",\"id\":23}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:30:58', '2026-08-24 12:30:58'),
(66, 1, 'App\\Models\\TitikParkir', 23, 'updated', '{\"id\":23,\"kode_titik\":\"TP-EKS-021\",\"nama\":\"PASAR ATAS 2\",\"alamat\":\"Bongki\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1200500\",\"longitude\":\"120.2518100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:30:58.000000Z\",\"updated_at\":\"2026-08-24T12:30:58.000000Z\"}', '{\"alamat\":\"Jl. Bulu Bicara\",\"updated_at\":\"2026-08-24 20:31:25\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:31:25', '2026-08-24 12:31:25'),
(67, 1, 'App\\Models\\TitikParkir', 24, 'created', NULL, '{\"kode_titik\":\"TP-EKS-022\",\"nama\":\"POS DEMMA\",\"alamat\":\"Demma\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.12129\",\"longitude\":\"120.25329\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:32:27\",\"created_at\":\"2026-08-24 20:32:27\",\"id\":24}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:32:27', '2026-08-24 12:32:27'),
(68, 1, 'App\\Models\\TitikParkir', 25, 'created', NULL, '{\"kode_titik\":\"TP-EKS-023\",\"nama\":\"POS BULU SARAUNG\",\"alamat\":\"Jl. Bulu Saraung\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.11884\",\"longitude\":\"120.25391\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:34:04\",\"created_at\":\"2026-08-24 20:34:04\",\"id\":25}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:34:04', '2026-08-24 12:34:04'),
(69, 1, 'App\\Models\\TitikParkir', 25, 'updated', '{\"id\":25,\"kode_titik\":\"TP-EKS-023\",\"nama\":\"POS BULU SARAUNG\",\"alamat\":\"Jl. Bulu Saraung\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1188400\",\"longitude\":\"120.2539100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:34:04.000000Z\",\"updated_at\":\"2026-08-24T12:34:04.000000Z\"}', '{\"nama\":\"POS BULU SALAKA\",\"alamat\":\"Jl. Bulu Salaka\",\"updated_at\":\"2026-08-24 20:35:27\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:35:27', '2026-08-24 12:35:27'),
(70, 1, 'App\\Models\\TitikParkir', 26, 'created', NULL, '{\"kode_titik\":\"TP-EKS-024\",\"nama\":\"POS RUKO PRAMUKA\",\"alamat\":\"Jl. Pramuka\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.11807\",\"longitude\":\"120.25601\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:36:43\",\"created_at\":\"2026-08-24 20:36:43\",\"id\":26}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:36:43', '2026-08-24 12:36:43'),
(71, 1, 'App\\Models\\TitikParkir', 26, 'updated', '{\"id\":26,\"kode_titik\":\"TP-EKS-024\",\"nama\":\"POS RUKO PRAMUKA\",\"alamat\":\"Jl. Pramuka\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1180700\",\"longitude\":\"120.2560100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:36:43.000000Z\",\"updated_at\":\"2026-08-24T12:36:43.000000Z\"}', '{\"nama\":\"PASAR RUKO PRAMUKA\",\"updated_at\":\"2026-08-24 20:37:55\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:37:55', '2026-08-24 12:37:55'),
(72, 1, 'App\\Models\\TitikParkir', 27, 'created', NULL, '{\"kode_titik\":\"TP-EKS-026\",\"nama\":\"PASAR RUKO 2\",\"alamat\":\"bONGKI\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"latitude\":\"-5.1194\",\"longitude\":\"120.25544\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:41:54\",\"created_at\":\"2026-08-24 20:41:54\",\"id\":27}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:41:54', '2026-08-24 12:41:54'),
(73, 1, 'App\\Models\\TitikParkir', 27, 'updated', '{\"id\":27,\"kode_titik\":\"TP-EKS-026\",\"nama\":\"PASAR RUKO 2\",\"alamat\":\"bONGKI\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1194000\",\"longitude\":\"120.2554400\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:41:54.000000Z\",\"updated_at\":\"2026-08-24T12:41:54.000000Z\"}', '{\"kode_titik\":\"TP-EKS-025\",\"updated_at\":\"2026-08-24 20:42:08\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:42:08', '2026-08-24 12:42:08'),
(74, 1, 'App\\Models\\TitikParkir', 27, 'updated', '{\"id\":27,\"kode_titik\":\"TP-EKS-025\",\"nama\":\"PASAR RUKO 2\",\"alamat\":\"bONGKI\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1194000\",\"longitude\":\"120.2554400\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:41:54.000000Z\",\"updated_at\":\"2026-08-24T12:42:08.000000Z\"}', '{\"alamat\":\"Jl. Persatuan Raya\",\"updated_at\":\"2026-08-24 20:44:16\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:44:16', '2026-08-24 12:44:16'),
(75, 1, 'App\\Models\\TitikParkir', 26, 'updated', '{\"id\":26,\"kode_titik\":\"TP-EKS-024\",\"nama\":\"PASAR RUKO PRAMUKA\",\"alamat\":\"Jl. Pramuka\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1180700\",\"longitude\":\"120.2560100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:36:43.000000Z\",\"updated_at\":\"2026-08-24T12:37:55.000000Z\"}', '{\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"nama_pengelola\":\"AHMAD\",\"updated_at\":\"2026-08-24 20:45:32\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:45:32', '2026-08-24 12:45:32'),
(76, 1, 'App\\Models\\TitikParkir', 20, 'updated', '{\"id\":20,\"kode_titik\":\"TP-EKS-018\",\"nama\":\"ALUN-ALUN 5\",\"alamat\":\"Jl, H.A. Abdul Latief\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1250700\",\"longitude\":\"120.2497700\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:23:22.000000Z\",\"updated_at\":\"2026-08-24T12:23:22.000000Z\"}', '{\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"nama_pengelola\":\"AHMAD\",\"updated_at\":\"2026-08-24 20:46:44\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:46:44', '2026-08-24 12:46:44'),
(77, 1, 'App\\Models\\TitikParkir', 28, 'created', NULL, '{\"kode_titik\":\"TP-EKS-026\",\"nama\":\"POS BONTO\",\"alamat\":\"Jl. Petta Ponggawae\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.09544\",\"longitude\":\"120.24632\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:49:13\",\"created_at\":\"2026-08-24 20:49:13\",\"id\":28}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:49:13', '2026-08-24 12:49:13'),
(78, 1, 'App\\Models\\TitikParkir', 29, 'created', NULL, '{\"kode_titik\":\"TP-EKS-027\",\"nama\":\"POS TPI LAPPA\",\"alamat\":\"Lappa\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"66\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.10773\",\"longitude\":\"120.27075\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:51:33\",\"created_at\":\"2026-08-24 20:51:33\",\"id\":29}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:51:33', '2026-08-24 12:51:33'),
(79, 1, 'App\\Models\\TitikParkir', 29, 'updated', '{\"id\":29,\"kode_titik\":\"TP-EKS-027\",\"nama\":\"POS TPI LAPPA\",\"alamat\":\"Lappa\",\"kecamatan_id\":7,\"kelurahan_id\":66,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1077300\",\"longitude\":\"120.2707500\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:51:33.000000Z\",\"updated_at\":\"2026-08-24T12:51:33.000000Z\"}', '{\"alamat\":\"Jl. Kalampeto\",\"updated_at\":\"2026-08-24 20:53:26\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:53:26', '2026-08-24 12:53:26'),
(80, 1, 'App\\Models\\TitikParkir', 30, 'created', NULL, '{\"kode_titik\":\"TP-EKS-028\",\"nama\":\"PASAR BARINGENG\",\"alamat\":\"sinjai\",\"kecamatan_id\":\"6\",\"kelurahan_id\":\"42\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.16928\",\"longitude\":\"120.27239\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 20:56:46\",\"created_at\":\"2026-08-24 20:56:46\",\"id\":30}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:56:46', '2026-08-24 12:56:46'),
(81, 1, 'App\\Models\\TitikParkir', 30, 'updated', '{\"id\":30,\"kode_titik\":\"TP-EKS-028\",\"nama\":\"PASAR BARINGENG\",\"alamat\":\"sinjai\",\"kecamatan_id\":6,\"kelurahan_id\":42,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1692800\",\"longitude\":\"120.2723900\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:56:46.000000Z\",\"updated_at\":\"2026-08-24T12:56:46.000000Z\"}', '{\"alamat\":\"Jl. Poros Sinjai-Kajang\",\"updated_at\":\"2026-08-24 20:58:00\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 12:58:00', '2026-08-24 12:58:00'),
(82, 1, 'App\\Models\\TitikParkir', 31, 'created', NULL, '{\"kode_titik\":\"TP-EKS-029\",\"nama\":\"PASAR LAGORA\",\"alamat\":\"SINJAI TENGAH\",\"kecamatan_id\":\"1\",\"kelurahan_id\":\"63\",\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"latitude\":\"-5.16358\",\"longitude\":\"120.1684\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:00:08\",\"created_at\":\"2026-08-24 21:00:08\",\"id\":31}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:00:08', '2026-08-24 13:00:08'),
(83, 1, 'App\\Models\\TitikParkir', 31, 'updated', '{\"id\":31,\"kode_titik\":\"TP-EKS-029\",\"nama\":\"PASAR LAGORA\",\"alamat\":\"SINJAI TENGAH\",\"kecamatan_id\":1,\"kelurahan_id\":63,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1635800\",\"longitude\":\"120.1684000\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T13:00:08.000000Z\",\"updated_at\":\"2026-08-24T13:00:08.000000Z\"}', '{\"alamat\":\"Kec. Sinjai Tengah\",\"latitude\":\"-5.165572\",\"longitude\":\"120.168704\",\"updated_at\":\"2026-08-24 21:05:17\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:05:17', '2026-08-24 13:05:17'),
(84, 1, 'App\\Models\\TitikParkir', 31, 'updated', '{\"id\":31,\"kode_titik\":\"TP-EKS-029\",\"nama\":\"PASAR LAGORA\",\"alamat\":\"Kec. Sinjai Tengah\",\"kecamatan_id\":1,\"kelurahan_id\":63,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1655720\",\"longitude\":\"120.1687040\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T13:00:08.000000Z\",\"updated_at\":\"2026-08-24T13:05:17.000000Z\"}', '{\"alamat\":\"Jl. Poros Manipi\",\"updated_at\":\"2026-08-24 21:06:12\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:06:12', '2026-08-24 13:06:12'),
(85, 1, 'App\\Models\\TitikParkir', 32, 'created', NULL, '{\"kode_titik\":\"TP-EKS-030\",\"nama\":\"PASAR MANIMPAHOI\",\"alamat\":\"Saotengnga\",\"kecamatan_id\":\"1\",\"kelurahan_id\":\"55\",\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"latitude\":\"-5.18893\",\"longitude\":\"120.11271\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:10:11\",\"created_at\":\"2026-08-24 21:10:11\",\"id\":32}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:10:11', '2026-08-24 13:10:11'),
(86, 1, 'App\\Models\\TitikParkir', 32, 'updated', '{\"id\":32,\"kode_titik\":\"TP-EKS-030\",\"nama\":\"PASAR MANIMPAHOI\",\"alamat\":\"Saotengnga\",\"kecamatan_id\":1,\"kelurahan_id\":55,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1889300\",\"longitude\":\"120.1127100\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T13:10:11.000000Z\",\"updated_at\":\"2026-08-24T13:10:11.000000Z\"}', '{\"latitude\":\"-5.190885\",\"longitude\":\"120.112292\",\"updated_at\":\"2026-08-24 21:12:45\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:12:45', '2026-08-24 13:12:45'),
(87, 1, 'App\\Models\\TitikParkir', 32, 'updated', '{\"id\":32,\"kode_titik\":\"TP-EKS-030\",\"nama\":\"PASAR MANIMPAHOI\",\"alamat\":\"Saotengnga\",\"kecamatan_id\":1,\"kelurahan_id\":55,\"jenis_parkir_id\":2,\"sumber_pemasukan_id\":1,\"latitude\":\"-5.1908850\",\"longitude\":\"120.1122920\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T13:10:11.000000Z\",\"updated_at\":\"2026-08-24T13:12:45.000000Z\"}', '{\"alamat\":\"Jl. Sultan Hasanuddin\",\"updated_at\":\"2026-08-24 21:13:23\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:13:23', '2026-08-24 13:13:23'),
(88, 1, 'App\\Models\\TitikParkir', 33, 'created', NULL, '{\"kode_titik\":\"TP-EKS-031\",\"nama\":\"PASAR TASSILILU\",\"alamat\":\"Komp. Pasar Manipi\",\"kecamatan_id\":\"2\",\"kelurahan_id\":\"8\",\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"latitude\":\"-5.20483\",\"longitude\":\"120.00027\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:17:01\",\"created_at\":\"2026-08-24 21:17:01\",\"id\":33}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:17:01', '2026-08-24 13:17:01'),
(89, 1, 'App\\Models\\TitikParkir', 34, 'created', NULL, '{\"kode_titik\":\"TP-EKS-032\",\"nama\":\"PASAR BIKERU\",\"alamat\":\"Jl. Rambutan\",\"kecamatan_id\":\"4\",\"kelurahan_id\":\"28\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.24774\",\"longitude\":\"120.15811\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:27:28\",\"created_at\":\"2026-08-24 21:27:28\",\"id\":34}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:27:28', '2026-08-24 13:27:28'),
(90, 1, 'App\\Models\\TitikParkir', 35, 'created', NULL, '{\"kode_titik\":\"TP-EKS-033\",\"nama\":\"PASAR MANNANTI\",\"alamat\":\"Mannanti\",\"kecamatan_id\":\"5\",\"kelurahan_id\":\"39\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.26586\",\"longitude\":\"120.23501\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:29:55\",\"created_at\":\"2026-08-24 21:29:55\",\"id\":35}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:29:55', '2026-08-24 13:29:55'),
(91, 1, 'App\\Models\\TitikParkir', 36, 'created', NULL, '{\"kode_titik\":\"TP-EKS-034\",\"nama\":\"PASAR MATAJANG\",\"alamat\":\"Lamatti Riattang\",\"kecamatan_id\":\"8\",\"kelurahan_id\":\"70\",\"jenis_parkir_id\":\"2\",\"sumber_pemasukan_id\":\"1\",\"latitude\":\"-5.09671\",\"longitude\":\"120.15259\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":\"AHMAD\",\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:32:59\",\"created_at\":\"2026-08-24 21:32:59\",\"id\":36}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:32:59', '2026-08-24 13:32:59'),
(92, 1, 'App\\Models\\TitikParkir', 37, 'created', NULL, '{\"kode_titik\":\"TP-EKS-035\",\"nama\":\"PASAR INRULAMUNG PASIR PUTIH\",\"alamat\":\"Jl. Melati\",\"kecamatan_id\":\"3\",\"kelurahan_id\":\"17\",\"jenis_parkir_id\":\"1\",\"sumber_pemasukan_id\":\"2\",\"latitude\":\"-5.32491\",\"longitude\":\"120.06558\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-24 21:35:47\",\"created_at\":\"2026-08-24 21:35:47\",\"id\":37}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 13:35:47', '2026-08-24 13:35:47'),
(93, 1, 'App\\Models\\Setoran', 4, 'deleted', '{\"id\":4,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":2,\"jukir_id\":null,\"titik_parkir_id\":null,\"tanggal\":\"2026-08-20T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"150000.00\",\"jumlah_setoran\":\"150000.00\",\"selisih\":\"0.00\",\"status\":\"terverifikasi\",\"keterangan\":\"Setoran sewa tempat usaha test\",\"diverifikasi_at\":\"2026-08-21T11:19:13.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-08-21T11:16:45.000000Z\",\"updated_at\":\"2026-08-21T11:19:13.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 14:47:49', '2026-08-24 14:47:49'),
(94, 1, 'App\\Models\\Setoran', 3, 'deleted', '{\"id\":3,\"sumber_pemasukan_id\":1,\"objek_pendapatan_id\":null,\"jukir_id\":5,\"titik_parkir_id\":4,\"tanggal\":\"2026-08-20T16:00:00.000000Z\",\"jumlah_motor\":80,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":30,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"330000.00\",\"jumlah_setoran\":\"320000.00\",\"selisih\":\"10000.00\",\"status\":\"terverifikasi\",\"keterangan\":\"Setoran uji parkir khusus |\",\"diverifikasi_at\":\"2026-08-21T11:19:24.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-08-21T11:13:36.000000Z\",\"updated_at\":\"2026-08-21T11:19:24.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 14:47:59', '2026-08-24 14:47:59'),
(95, 1, 'App\\Models\\Setoran', 2, 'deleted', '{\"id\":2,\"sumber_pemasukan_id\":2,\"objek_pendapatan_id\":null,\"jukir_id\":4,\"titik_parkir_id\":3,\"tanggal\":\"2026-08-20T16:00:00.000000Z\",\"jumlah_motor\":100,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":25,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"325000.00\",\"jumlah_setoran\":\"300000.00\",\"selisih\":\"25000.00\",\"status\":\"terverifikasi\",\"keterangan\":null,\"diverifikasi_at\":\"2026-08-21T11:19:36.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-08-21T11:12:23.000000Z\",\"updated_at\":\"2026-08-21T11:19:36.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 14:48:06', '2026-08-24 14:48:06'),
(96, 1, 'App\\Models\\JenisParkir', 4, 'updated', '{\"id\":4,\"kode\":\"USAHA-TEST\",\"nama\":\"Parkir Kegiatan Usaha Test\",\"deskripsi\":\"Parkir yang berkaitan dengan kegiatan usaha\",\"status\":true,\"created_at\":\"2026-08-21T10:44:16.000000Z\",\"updated_at\":\"2026-08-21T10:44:16.000000Z\"}', '{\"kode\":\"R-KU\",\"nama\":\"Parkir Kegiatan Usaha\",\"updated_at\":\"2026-08-24 23:19:38\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:19:38', '2026-08-24 15:19:38'),
(97, 1, 'App\\Models\\Tarif', 6, 'created', NULL, '{\"jenis_parkir_id\":\"2\",\"jenis_kendaraan\":\"motor\",\"nominal\":\"2000\",\"berlaku_mulai\":\"2026-01-01 00:00:00\",\"berlaku_sampai\":null,\"status\":\"1\",\"keterangan\":null,\"updated_at\":\"2026-08-24 23:21:04\",\"created_at\":\"2026-08-24 23:21:04\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:21:04', '2026-08-24 15:21:04'),
(98, 1, 'App\\Models\\Tarif', 7, 'created', NULL, '{\"jenis_parkir_id\":\"2\",\"jenis_kendaraan\":\"mobil_kecil\",\"nominal\":\"3000\",\"berlaku_mulai\":\"2026-01-01 00:00:00\",\"berlaku_sampai\":null,\"status\":\"1\",\"keterangan\":null,\"updated_at\":\"2026-08-24 23:21:44\",\"created_at\":\"2026-08-24 23:21:44\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:21:44', '2026-08-24 15:21:44'),
(99, 1, 'App\\Models\\Tarif', 8, 'created', NULL, '{\"jenis_parkir_id\":\"2\",\"jenis_kendaraan\":\"mobil_besar\",\"nominal\":\"5000\",\"berlaku_mulai\":\"2026-01-01 00:00:00\",\"berlaku_sampai\":null,\"status\":\"1\",\"keterangan\":null,\"updated_at\":\"2026-08-24 23:22:07\",\"created_at\":\"2026-08-24 23:22:07\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:22:07', '2026-08-24 15:22:07'),
(100, 1, 'App\\Models\\Tarif', 9, 'created', NULL, '{\"jenis_parkir_id\":\"4\",\"jenis_kendaraan\":\"motor\",\"nominal\":\"2000\",\"berlaku_mulai\":\"2026-01-01 00:00:00\",\"berlaku_sampai\":null,\"status\":\"1\",\"keterangan\":null,\"updated_at\":\"2026-08-24 23:22:37\",\"created_at\":\"2026-08-24 23:22:37\",\"id\":9}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:22:37', '2026-08-24 15:22:37'),
(101, 1, 'App\\Models\\Tarif', 10, 'created', NULL, '{\"jenis_parkir_id\":\"4\",\"jenis_kendaraan\":\"mobil_kecil\",\"nominal\":\"3000\",\"berlaku_mulai\":\"2026-01-01 00:00:00\",\"berlaku_sampai\":null,\"status\":\"1\",\"keterangan\":null,\"updated_at\":\"2026-08-24 23:22:55\",\"created_at\":\"2026-08-24 23:22:55\",\"id\":10}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:22:55', '2026-08-24 15:22:55'),
(102, 1, 'App\\Models\\Tarif', 11, 'created', NULL, '{\"jenis_parkir_id\":\"4\",\"jenis_kendaraan\":\"mobil_besar\",\"nominal\":\"5000\",\"berlaku_mulai\":\"2026-01-01 00:00:00\",\"berlaku_sampai\":null,\"status\":\"1\",\"keterangan\":null,\"updated_at\":\"2026-08-24 23:23:12\",\"created_at\":\"2026-08-24 23:23:12\",\"id\":11}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:23:12', '2026-08-24 15:23:12'),
(103, 1, 'App\\Models\\PenempatanJukir', 3, 'deleted', '{\"id\":3,\"jukir_id\":5,\"titik_parkir_id\":4,\"tanggal_mulai\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"created_at\":\"2026-08-21T11:05:58.000000Z\",\"updated_at\":\"2026-08-21T11:05:58.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:26:50', '2026-08-24 15:26:50'),
(104, 1, 'App\\Models\\JenisParkir', 4, 'updated', '{\"id\":4,\"kode\":\"R-KU\",\"nama\":\"Parkir Kegiatan Usaha\",\"deskripsi\":\"Parkir yang berkaitan dengan kegiatan usaha\",\"status\":true,\"created_at\":\"2026-08-21T10:44:16.000000Z\",\"updated_at\":\"2026-08-24T15:19:38.000000Z\"}', '{\"kode\":\"R-PKU\",\"updated_at\":\"2026-08-24 23:45:15\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:45:15', '2026-08-24 15:45:15'),
(105, 1, 'App\\Models\\Jukir', 5, 'updated', '{\"id\":5,\"kode_jukir\":\"JKR-00002\",\"jenis_jukir_id\":1,\"nik\":\"7307010202920002\",\"nama\":\"Siti Petugas Test\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-02-01T16:00:00.000000Z\",\"jenis_kelamin\":\"P\",\"alamat\":\"Jl. Sultan Hasanuddin\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"no_hp\":\"081234567802\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas\",\"created_at\":\"2026-08-21T10:41:30.000000Z\",\"updated_at\":\"2026-08-21T10:41:30.000000Z\"}', '{\"nama\":\"Siti Petugas\",\"updated_at\":\"2026-08-24 23:53:48\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:53:48', '2026-08-24 15:53:48'),
(106, 1, 'App\\Models\\Jukir', 4, 'updated', '{\"id\":4,\"kode_jukir\":\"JKR-00001\",\"jenis_jukir_id\":1,\"nik\":\"7307010101900001\",\"nama\":\"Ahmad Petugas Test\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1989-12-31T16:00:00.000000Z\",\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. Persatuan Raya\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"no_hp\":\"081234567801\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas tetap\",\"created_at\":\"2026-08-21T10:39:47.000000Z\",\"updated_at\":\"2026-08-21T10:39:47.000000Z\"}', '{\"nama\":\"Ahmad Petugas\",\"updated_at\":\"2026-08-24 23:55:27\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:55:27', '2026-08-24 15:55:27'),
(107, 1, 'App\\Models\\Jukir', 5, 'updated', '{\"id\":5,\"kode_jukir\":\"JKR-00002\",\"jenis_jukir_id\":1,\"nik\":\"7307010202920002\",\"nama\":\"Siti Petugas\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-02-01T16:00:00.000000Z\",\"jenis_kelamin\":\"P\",\"alamat\":\"Jl. Sultan Hasanuddin\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"no_hp\":\"081234567802\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas\",\"created_at\":\"2026-08-21T10:41:30.000000Z\",\"updated_at\":\"2026-08-24T15:53:48.000000Z\"}', '{\"nik\":\"7307010202920003\",\"updated_at\":\"2026-08-24 23:56:01\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:56:01', '2026-08-24 15:56:01'),
(108, 1, 'App\\Models\\Jukir', 5, 'updated', '{\"id\":5,\"kode_jukir\":\"JKR-00002\",\"jenis_jukir_id\":1,\"nik\":\"7307010202920003\",\"nama\":\"Siti Petugas\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-02-01T16:00:00.000000Z\",\"jenis_kelamin\":\"P\",\"alamat\":\"Jl. Sultan Hasanuddin\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"no_hp\":\"081234567802\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas\",\"created_at\":\"2026-08-21T10:41:30.000000Z\",\"updated_at\":\"2026-08-24T15:56:01.000000Z\"}', '{\"nik\":\"7307010202920004\",\"updated_at\":\"2026-08-24 23:57:26\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 15:57:26', '2026-08-24 15:57:26'),
(109, 1, 'App\\Models\\TitikParkir', 38, 'created', NULL, '{\"kode_titik\":\"R.Kios-01\",\"nama\":\"Kios 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":\"5\",\"latitude\":\"-5.113475\",\"longitude\":\"120.251640\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-25 00:36:30\",\"created_at\":\"2026-08-25 00:36:30\",\"id\":38}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:36:30', '2026-08-24 16:36:30'),
(110, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"Kios 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":5,\"latitude\":\"-5.1134750\",\"longitude\":\"120.2516400\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-24T16:36:30.000000Z\"}', '{\"nama\":\"KIOS 1\",\"latitude\":\"-5.113593\",\"longitude\":\"120.252434\",\"updated_at\":\"2026-08-25 00:40:19\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:40:19', '2026-08-24 16:40:19'),
(111, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":5,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-24T16:40:19.000000Z\"}', '{\"nama\":\"Kios 1\",\"updated_at\":\"2026-08-25 00:45:01\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:45:01', '2026-08-24 16:45:01'),
(112, 1, 'App\\Models\\TitikParkir', 37, 'updated', '{\"id\":37,\"kode_titik\":\"TP-EKS-035\",\"nama\":\"PASAR INRULAMUNG PASIR PUTIH\",\"alamat\":\"Jl. Melati\",\"kecamatan_id\":3,\"kelurahan_id\":17,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.3249100\",\"longitude\":\"120.0655800\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T13:35:47.000000Z\",\"updated_at\":\"2026-08-24T13:35:47.000000Z\"}', '{\"nama\":\"Pasar Inrulamung Pasir Putih\",\"updated_at\":\"2026-08-25 00:45:39\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:45:39', '2026-08-24 16:45:39'),
(113, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"Kios 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":5,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-24T16:45:01.000000Z\"}', '{\"nama\":\"KIOS 1\",\"updated_at\":\"2026-08-25 00:46:43\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:46:43', '2026-08-24 16:46:43'),
(114, 1, 'App\\Models\\TitikParkir', 37, 'updated', '{\"id\":37,\"kode_titik\":\"TP-EKS-035\",\"nama\":\"Pasar Inrulamung Pasir Putih\",\"alamat\":\"Jl. Melati\",\"kecamatan_id\":3,\"kelurahan_id\":17,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.3249100\",\"longitude\":\"120.0655800\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T13:35:47.000000Z\",\"updated_at\":\"2026-08-24T16:45:39.000000Z\"}', '{\"nama\":\"PASAR INRULAMUNG PASIR PUTIH\",\"updated_at\":\"2026-08-25 00:47:08\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:47:08', '2026-08-24 16:47:08'),
(115, 1, 'App\\Models\\User', 2, 'created', NULL, '{\"name\":\"Akbar, S.Sos.,M.Si\",\"email\":\"akbar@gmail.com\",\"role\":\"pimpinan\",\"status\":\"aktif\",\"updated_at\":\"2026-08-25 00:57:30\",\"created_at\":\"2026-08-25 00:57:30\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:57:30', '2026-08-24 16:57:30'),
(116, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-24 16:57:38', '2026-08-24 16:57:38'),
(117, 1, 'App\\Models\\CapaianBulanan', 2, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"1\",\"target\":\"97541667\",\"realisasi\":\"95369000\",\"catatan\":null,\"updated_at\":\"2026-08-28 15:04:08\",\"created_at\":\"2026-08-28 15:04:08\",\"id\":2}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:04:08', '2026-08-28 07:04:08'),
(118, 1, 'App\\Models\\CapaianBulanan', 3, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"2\",\"target\":\"97541667\",\"realisasi\":\"96046000\",\"catatan\":null,\"updated_at\":\"2026-08-28 15:05:40\",\"created_at\":\"2026-08-28 15:05:40\",\"id\":3}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:05:40', '2026-08-28 07:05:40'),
(119, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:14:41', '2026-08-28 07:14:41'),
(120, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":5,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-24T16:46:43.000000Z\"}', '{\"kapasitas_mobil_kecil\":\"20\",\"kapasitas_mobil_besar\":\"30\",\"kapasitas_total\":\"50\",\"potensi_harian\":\"210000\",\"potensi_bulanan\":\"6300000\",\"updated_at\":\"2026-08-28 15:40:11\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:40:11', '2026-08-28 07:40:11'),
(121, 1, 'App\\Models\\ObjekPendapatan', 1, 'deleted', '{\"id\":1,\"sumber_pemasukan_id\":3,\"wajib_pajak_id\":null,\"kode\":\"PAJAK-TEST-001\",\"nama\":\"Area Parkir Mall Sinjai Test\",\"tipe\":\"objek_pajak\",\"alamat\":\"Jl. Persatuan No. 20\",\"nama_pengelola\":\"PT Sinjai Parkir Test\",\"nomor_identitas\":\"WP-TEST-001\",\"npwp\":\"123456789012345\",\"nop\":\"NOP-730701-TEST-001\",\"masa_pajak_mulai\":\"2025-12-31T16:00:00.000000Z\",\"masa_pajak_sampai\":null,\"tarif_pajak\":\"10.00\",\"jenis_usaha\":null,\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":\"50000.00\",\"nomor_kontrak\":null,\"kontrak_mulai\":null,\"kontrak_selesai\":null,\"potensi_harian\":\"50000.00\",\"potensi_bulanan\":\"150000.00\",\"status\":\"aktif\",\"metadata\":null,\"created_at\":\"2026-08-21T11:01:26.000000Z\",\"updated_at\":\"2026-08-21T11:02:48.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:43:46', '2026-08-28 07:43:46'),
(122, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:46:17', '2026-08-28 07:46:17'),
(123, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:47:46', '2026-08-28 07:47:46'),
(124, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 07:54:37', '2026-08-28 07:54:37');
INSERT INTO `audit_logs` (`id`, `user_id`, `auditable_type`, `auditable_id`, `action`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(125, 1, 'App\\Models\\Jukir', 5, 'deleted', '{\"id\":5,\"kode_jukir\":\"JKR-00002\",\"jenis_jukir_id\":1,\"nik\":\"7307010202920004\",\"nama\":\"Siti Petugas\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-02-01T16:00:00.000000Z\",\"jenis_kelamin\":\"P\",\"alamat\":\"Jl. Sultan Hasanuddin\",\"kecamatan_id\":7,\"kelurahan_id\":67,\"no_hp\":\"081234567802\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas\",\"created_at\":\"2026-08-21T10:41:30.000000Z\",\"updated_at\":\"2026-08-24T15:57:26.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:50:12', '2026-08-28 09:50:12'),
(126, 1, 'App\\Models\\Jukir', 4, 'updated', '{\"id\":4,\"kode_jukir\":\"JKR-00001\",\"jenis_jukir_id\":1,\"nik\":\"7307010101900001\",\"nama\":\"Ahmad Petugas\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1989-12-31T16:00:00.000000Z\",\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. Persatuan Raya\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"no_hp\":\"081234567801\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":\"Data uji petugas tetap\",\"created_at\":\"2026-08-21T10:39:47.000000Z\",\"updated_at\":\"2026-08-24T15:55:27.000000Z\"}', '{\"nik\":\"7308051306940002\",\"nama\":\"A. HASBI ALAM\",\"alamat\":\"Jl. -\",\"keterangan\":null,\"updated_at\":\"2026-08-28 17:52:16\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:52:16', '2026-08-28 09:52:16'),
(127, 1, 'App\\Models\\Jukir', 6, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307052004900004\",\"nama\":\"AMRI\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1990-01-01 00:00:00\",\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00002\",\"updated_at\":\"2026-08-28 17:53:25\",\"created_at\":\"2026-08-28 17:53:25\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:53:25', '2026-08-28 09:53:25'),
(128, 1, 'App\\Models\\Jukir', 7, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7308031404880002\",\"nama\":\"ANDI AFFANDY\",\"tempat_lahir\":\"Bone\",\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":null,\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00003\",\"updated_at\":\"2026-08-28 17:54:13\",\"created_at\":\"2026-08-28 17:54:13\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:54:13', '2026-08-28 09:54:13'),
(129, 1, 'App\\Models\\Jukir', 8, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7308031211860001\",\"nama\":\"ANDI JUAENI\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":null,\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00004\",\"updated_at\":\"2026-08-28 17:54:59\",\"created_at\":\"2026-08-28 17:54:59\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:54:59', '2026-08-28 09:54:59'),
(130, 1, 'App\\Models\\Jukir', 9, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7308031010820002\",\"nama\":\"ANDI TAPPU\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":null,\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00005\",\"updated_at\":\"2026-08-28 17:55:43\",\"created_at\":\"2026-08-28 17:55:43\",\"id\":9}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:55:43', '2026-08-28 09:55:43'),
(131, 1, 'App\\Models\\Jukir', 10, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307041512910001\",\"nama\":\"ARFAN ARDIANTO\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00006\",\"updated_at\":\"2026-08-28 17:56:27\",\"created_at\":\"2026-08-28 17:56:27\",\"id\":10}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:56:27', '2026-08-28 09:56:27'),
(132, 1, 'App\\Models\\Jukir', 11, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7308073012880001\",\"nama\":\"ASRUN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":null,\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00007\",\"updated_at\":\"2026-08-28 17:57:08\",\"created_at\":\"2026-08-28 17:57:08\",\"id\":11}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:57:08', '2026-08-28 09:57:08'),
(133, 1, 'App\\Models\\Jukir', 12, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307063110970001\",\"nama\":\"BAHARUDDIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00008\",\"updated_at\":\"2026-08-28 17:58:16\",\"created_at\":\"2026-08-28 17:58:16\",\"id\":12}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:58:17', '2026-08-28 09:58:17'),
(134, 1, 'App\\Models\\Jukir', 13, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307040509830001\",\"nama\":\"FAJAR AKSAN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00009\",\"updated_at\":\"2026-08-28 17:58:55\",\"created_at\":\"2026-08-28 17:58:55\",\"id\":13}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:58:55', '2026-08-28 09:58:55'),
(135, 1, 'App\\Models\\Jukir', 14, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307052703880002\",\"nama\":\"FAJRIN USMAN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00010\",\"updated_at\":\"2026-08-28 17:59:32\",\"created_at\":\"2026-08-28 17:59:32\",\"id\":14}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 09:59:32', '2026-08-28 09:59:32'),
(136, 1, 'App\\Models\\Jukir', 15, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307021707000002\",\"nama\":\"HAMDAN JAYA AFIAT\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00011\",\"updated_at\":\"2026-08-28 18:00:30\",\"created_at\":\"2026-08-28 18:00:30\",\"id\":15}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:00:30', '2026-08-28 10:00:30'),
(137, 1, 'App\\Models\\Jukir', 16, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307040205880002\",\"nama\":\"HENDRA\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00012\",\"updated_at\":\"2026-08-28 18:01:10\",\"created_at\":\"2026-08-28 18:01:10\",\"id\":16}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:01:10', '2026-08-28 10:01:10'),
(138, 1, 'App\\Models\\Jukir', 17, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307020709920002\",\"nama\":\"IKBAL\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00013\",\"updated_at\":\"2026-08-28 18:01:49\",\"created_at\":\"2026-08-28 18:01:49\",\"id\":17}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:01:49', '2026-08-28 10:01:49'),
(139, 1, 'App\\Models\\Jukir', 18, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307051807960002\",\"nama\":\"IMAM SYARIF\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00014\",\"updated_at\":\"2026-08-28 18:02:37\",\"created_at\":\"2026-08-28 18:02:37\",\"id\":18}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:02:37', '2026-08-28 10:02:37'),
(140, 1, 'App\\Models\\Jukir', 19, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307032010870004\",\"nama\":\"IRWAN SYAH FAJAR\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00015\",\"updated_at\":\"2026-08-28 18:05:00\",\"created_at\":\"2026-08-28 18:05:00\",\"id\":19}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:05:00', '2026-08-28 10:05:00'),
(141, 1, 'App\\Models\\Jukir', 20, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7302091601840000\",\"nama\":\"IRWANYAH\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00016\",\"updated_at\":\"2026-08-28 18:06:15\",\"created_at\":\"2026-08-28 18:06:15\",\"id\":20}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:06:15', '2026-08-28 10:06:15'),
(142, 1, 'App\\Models\\Jukir', 21, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307022402810004\",\"nama\":\"ISKANDAR ZULKARNAIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00017\",\"updated_at\":\"2026-08-28 18:07:07\",\"created_at\":\"2026-08-28 18:07:07\",\"id\":21}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:07:07', '2026-08-28 10:07:07'),
(143, 1, 'App\\Models\\Jukir', 22, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307053101900002\",\"nama\":\"LUKMANUL HAKIM\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00018\",\"updated_at\":\"2026-08-28 18:07:46\",\"created_at\":\"2026-08-28 18:07:46\",\"id\":22}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:07:46', '2026-08-28 10:07:46'),
(144, 1, 'App\\Models\\Jukir', 23, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307050411000008\",\"nama\":\"MAHDI T\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":null,\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00019\",\"updated_at\":\"2026-08-28 18:09:42\",\"created_at\":\"2026-08-28 18:09:42\",\"id\":23}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:09:42', '2026-08-28 10:09:42'),
(145, 1, 'App\\Models\\Jukir', 24, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307051607010001\",\"nama\":\"MUH ASFARUDDIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00020\",\"updated_at\":\"2026-08-28 18:10:28\",\"created_at\":\"2026-08-28 18:10:28\",\"id\":24}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:10:28', '2026-08-28 10:10:28'),
(146, 1, 'App\\Models\\Jukir', 25, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307082010910001\",\"nama\":\"MUH JALIL\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00021\",\"updated_at\":\"2026-08-28 18:11:06\",\"created_at\":\"2026-08-28 18:11:06\",\"id\":25}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:11:06', '2026-08-28 10:11:06'),
(147, 1, 'App\\Models\\Jukir', 26, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307030405590003\",\"nama\":\"MUHAMAD NASIR\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00022\",\"updated_at\":\"2026-08-28 18:15:40\",\"created_at\":\"2026-08-28 18:15:40\",\"id\":26}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:15:40', '2026-08-28 10:15:40'),
(148, 1, 'App\\Models\\Jukir', 27, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307051507820003\",\"nama\":\"MUHAMMAD HIDAYAT\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00023\",\"updated_at\":\"2026-08-28 18:16:30\",\"created_at\":\"2026-08-28 18:16:30\",\"id\":27}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:16:30', '2026-08-28 10:16:30'),
(149, 1, 'App\\Models\\Jukir', 28, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307052608740001\",\"nama\":\"MUHAMMADIAH\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00024\",\"updated_at\":\"2026-08-28 18:17:33\",\"created_at\":\"2026-08-28 18:17:33\",\"id\":28}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:17:33', '2026-08-28 10:17:33'),
(150, 1, 'App\\Models\\Jukir', 29, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7302070707830000\",\"nama\":\"NANAM KASIM\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00025\",\"updated_at\":\"2026-08-28 18:18:17\",\"created_at\":\"2026-08-28 18:18:17\",\"id\":29}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:18:17', '2026-08-28 10:18:17'),
(151, 1, 'App\\Models\\Jukir', 30, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307052101890001\",\"nama\":\"NASRULLAH\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00026\",\"updated_at\":\"2026-08-28 18:18:56\",\"created_at\":\"2026-08-28 18:18:56\",\"id\":30}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:18:56', '2026-08-28 10:18:56'),
(152, 1, 'App\\Models\\Jukir', 31, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307050811990002\",\"nama\":\"NUR IKRAM\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00027\",\"updated_at\":\"2026-08-28 18:19:32\",\"created_at\":\"2026-08-28 18:19:32\",\"id\":31}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:19:32', '2026-08-28 10:19:32'),
(153, 1, 'App\\Models\\Jukir', 32, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307051503810003\",\"nama\":\"RUSMAN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00028\",\"updated_at\":\"2026-08-28 18:20:08\",\"created_at\":\"2026-08-28 18:20:08\",\"id\":32}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:20:08', '2026-08-28 10:20:08'),
(154, 1, 'App\\Models\\Jukir', 33, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307053112870040\",\"nama\":\"SAHRUDDIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00029\",\"updated_at\":\"2026-08-28 18:20:56\",\"created_at\":\"2026-08-28 18:20:56\",\"id\":33}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:20:56', '2026-08-28 10:20:56'),
(155, 1, 'App\\Models\\Jukir', 34, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307021509860002\",\"nama\":\"SATRIAWAN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00030\",\"updated_at\":\"2026-08-28 18:21:32\",\"created_at\":\"2026-08-28 18:21:32\",\"id\":34}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:21:32', '2026-08-28 10:21:32'),
(156, 1, 'App\\Models\\Jukir', 35, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307051410800006\",\"nama\":\"SIRAJUDDIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00031\",\"updated_at\":\"2026-08-28 18:23:06\",\"created_at\":\"2026-08-28 18:23:06\",\"id\":35}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 10:23:06', '2026-08-28 10:23:06'),
(157, 1, 'App\\Models\\Jukir', 36, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7308030604960001\",\"nama\":\"SUPRIADI\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":null,\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00032\",\"updated_at\":\"2026-08-28 19:30:37\",\"created_at\":\"2026-08-28 19:30:37\",\"id\":36}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:30:37', '2026-08-28 11:30:37'),
(158, 1, 'App\\Models\\Jukir', 37, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307062303690002\",\"nama\":\"SYAMSUDDIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":null,\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00033\",\"updated_at\":\"2026-08-28 19:31:09\",\"created_at\":\"2026-08-28 19:31:09\",\"id\":37}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:31:09', '2026-08-28 11:31:09'),
(159, 1, 'App\\Models\\Jukir', 36, 'updated', '{\"id\":36,\"kode_jukir\":\"JKR-00032\",\"jenis_jukir_id\":1,\"nik\":\"7308030604960001\",\"nama\":\"SUPRIADI\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":null,\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"created_at\":\"2026-08-28T11:30:37.000000Z\",\"updated_at\":\"2026-08-28T11:30:37.000000Z\"}', '{\"jenis_kelamin\":\"L\",\"updated_at\":\"2026-08-28 19:31:25\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:31:25', '2026-08-28 11:31:25'),
(160, 1, 'App\\Models\\Jukir', 37, 'updated', '{\"id\":37,\"kode_jukir\":\"JKR-00033\",\"jenis_jukir_id\":1,\"nik\":\"7307062303690002\",\"nama\":\"SYAMSUDDIN\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":null,\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"created_at\":\"2026-08-28T11:31:09.000000Z\",\"updated_at\":\"2026-08-28T11:31:09.000000Z\"}', '{\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"updated_at\":\"2026-08-28 19:31:43\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:31:43', '2026-08-28 11:31:43'),
(161, 1, 'App\\Models\\Jukir', 38, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307023112700018\",\"nama\":\"UMAR\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":null,\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00034\",\"updated_at\":\"2026-08-28 19:32:21\",\"created_at\":\"2026-08-28 19:32:21\",\"id\":38}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:32:21', '2026-08-28 11:32:21'),
(162, 1, 'App\\Models\\Jukir', 39, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307050505760002\",\"nama\":\"WAHYUDDIN UMAR\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00035\",\"updated_at\":\"2026-08-28 19:32:57\",\"created_at\":\"2026-08-28 19:32:57\",\"id\":39}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:32:57', '2026-08-28 11:32:57'),
(163, 1, 'App\\Models\\Jukir', 40, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307030710950003\",\"nama\":\"ZAKARIAH\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00036\",\"updated_at\":\"2026-08-28 19:33:33\",\"created_at\":\"2026-08-28 19:33:33\",\"id\":40}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:33:33', '2026-08-28 11:33:33'),
(164, 1, 'App\\Models\\Jukir', 41, 'created', NULL, '{\"jenis_jukir_id\":\"1\",\"nik\":\"7307040401880001\",\"nama\":\"SURIADI\",\"tempat_lahir\":null,\"tanggal_lahir\":null,\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":null,\"kelurahan_id\":null,\"no_hp\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2026-01-01 00:00:00\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"kode_jukir\":\"JKR-00037\",\"updated_at\":\"2026-08-28 19:34:16\",\"created_at\":\"2026-08-28 19:34:16\",\"id\":41}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:34:16', '2026-08-28 11:34:16'),
(165, 1, 'App\\Models\\SumberPemasukan', 3, 'deleted', '{\"id\":3,\"kode\":\"P-PARKIR\",\"nama\":\"Pajak Parkir\",\"deskripsi\":\"Pemasukan pajak atas penyelenggaraan parkir.\",\"status\":true,\"created_at\":\"2026-08-20T07:45:21.000000Z\",\"updated_at\":\"2026-08-20T07:45:21.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:36:05', '2026-08-28 11:36:05'),
(166, 1, 'App\\Models\\SumberPemasukan', 6, 'created', NULL, '{\"kode\":\"KIOS\",\"nama\":\"SEWA KIOS\",\"deskripsi\":null,\"status\":\"1\",\"updated_at\":\"2026-08-28 19:38:28\",\"created_at\":\"2026-08-28 19:38:28\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:38:28', '2026-08-28 11:38:28'),
(167, 1, 'App\\Models\\SumberPemasukan', 6, 'deleted', '{\"id\":6,\"kode\":\"KIOS\",\"nama\":\"SEWA KIOS\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-28T11:38:28.000000Z\",\"updated_at\":\"2026-08-28T11:38:28.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:39:48', '2026-08-28 11:39:48'),
(168, 1, 'App\\Models\\SumberPemasukan', 7, 'created', NULL, '{\"kode\":\"SW-KIOS\",\"nama\":\"SEWA KIOS\",\"deskripsi\":null,\"status\":\"1\",\"updated_at\":\"2026-08-28 19:40:16\",\"created_at\":\"2026-08-28 19:40:16\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:40:16', '2026-08-28 11:40:16'),
(169, 1, 'App\\Models\\SumberPemasukan', 7, 'updated', '{\"id\":7,\"kode\":\"SW-KIOS\",\"nama\":\"SEWA KIOS\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-28T11:40:16.000000Z\",\"updated_at\":\"2026-08-28T11:40:16.000000Z\"}', '{\"kode\":\"SW-KIOS-001\",\"nama\":\"Sewa Kios\",\"updated_at\":\"2026-08-28 19:40:45\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:40:45', '2026-08-28 11:40:45'),
(170, 1, 'App\\Models\\SumberPemasukan', 7, 'updated', '{\"id\":7,\"kode\":\"SW-KIOS-001\",\"nama\":\"Sewa Kios\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-28T11:40:16.000000Z\",\"updated_at\":\"2026-08-28T11:40:45.000000Z\"}', '{\"nama\":\"Retribusi Sewa Kios\",\"updated_at\":\"2026-08-28 19:42:44\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:42:44', '2026-08-28 11:42:44'),
(171, 1, 'App\\Models\\Jukir', 4, 'updated', '{\"id\":4,\"kode_jukir\":\"JKR-00001\",\"jenis_jukir_id\":1,\"nik\":\"7308051306940002\",\"nama\":\"A. HASBI ALAM\",\"tempat_lahir\":\"Sinjai\",\"tanggal_lahir\":\"1989-12-31T16:00:00.000000Z\",\"jenis_kelamin\":\"L\",\"alamat\":\"Jl. -\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"no_hp\":\"081234567801\",\"foto\":null,\"foto_ktp\":null,\"dokumen_pendukung\":null,\"nomor_kartu\":null,\"tanggal_terdaftar\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_berakhir\":null,\"status\":\"aktif\",\"keterangan\":null,\"created_at\":\"2026-08-21T10:39:47.000000Z\",\"updated_at\":\"2026-08-28T09:52:16.000000Z\"}', '{\"foto\":\"jukir\\/foto\\/D5aGeLLzRpvHZFjKiE7KoFKTAscLaLtxDyU57ady.png\",\"updated_at\":\"2026-08-28 19:59:38\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 11:59:38', '2026-08-28 11:59:38'),
(172, 1, 'App\\Models\\TitikParkir', 3, 'updated', '{\"id\":3,\"kode_titik\":\"TP-SU-002\",\"nama\":\"Toko Kosmetik Sri\",\"alamat\":\"Jl. G. Bawakaraeng\",\"kecamatan_id\":7,\"kelurahan_id\":64,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1206300\",\"longitude\":\"120.2541200\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-21T10:53:21.000000Z\",\"updated_at\":\"2026-08-24T11:39:14.000000Z\"}', '{\"foto\":\"titik-parkir\\/8N6Xj6uzBNhJ0sKstwaGoWgtYMO7wyzqlqpMebLB.jpg\",\"updated_at\":\"2026-08-28 20:01:27\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 12:01:27', '2026-08-28 12:01:27'),
(173, 1, 'App\\Models\\SumberPemasukan', 7, 'updated', '{\"id\":7,\"kode\":\"SW-KIOS-001\",\"nama\":\"Retribusi Sewa Kios\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-28T11:40:16.000000Z\",\"updated_at\":\"2026-08-28T11:42:44.000000Z\"}', '{\"kode\":\"SW-KIOS\",\"updated_at\":\"2026-08-28 23:12:05\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 15:12:05', '2026-08-28 15:12:05'),
(174, 1, 'App\\Models\\SumberPemasukan', 7, 'deleted', '{\"id\":7,\"kode\":\"SW-KIOS\",\"nama\":\"Retribusi Sewa Kios\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-28T11:40:16.000000Z\",\"updated_at\":\"2026-08-28T15:12:05.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 15:14:02', '2026-08-28 15:14:02'),
(175, 1, 'App\\Models\\ObjekPendapatan', 2, 'deleted', '{\"id\":2,\"sumber_pemasukan_id\":4,\"wajib_pajak_id\":null,\"kode\":\"USAHA-TEST-001\",\"nama\":\"Kios Terminal Test\",\"tipe\":\"tempat_usaha\",\"alamat\":\"Area Terminal Sinjai\",\"nama_pengelola\":\"CV Usaha Sinjai Test\",\"nomor_identitas\":null,\"npwp\":null,\"nop\":null,\"masa_pajak_mulai\":null,\"masa_pajak_sampai\":null,\"tarif_pajak\":null,\"jenis_usaha\":\"Kios makanan\",\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":\"1500000.00\",\"nomor_kontrak\":null,\"kontrak_mulai\":\"2025-12-31T16:00:00.000000Z\",\"kontrak_selesai\":null,\"potensi_harian\":\"50000.00\",\"potensi_bulanan\":\"1500000.00\",\"status\":\"aktif\",\"metadata\":null,\"created_at\":\"2026-08-21T11:04:34.000000Z\",\"updated_at\":\"2026-08-21T11:04:34.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 15:15:03', '2026-08-28 15:15:03'),
(176, 1, 'App\\Models\\JenisParkir', 1, 'updated', '{\"id\":1,\"kode\":\"R-PJTU\",\"nama\":\"Retribusi Pelayanan Parkir Tepi Jalan Umum\",\"deskripsi\":\"Pemasukan retribusi pelayanan parkir di tepi jalan umum.\",\"status\":true,\"created_at\":\"2026-08-20T07:25:12.000000Z\",\"updated_at\":\"2026-08-20T07:30:37.000000Z\"}', '{\"kode\":\"R-PPTJU\",\"updated_at\":\"2026-08-28 23:41:40\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 15:41:40', '2026-08-28 15:41:40'),
(177, 1, 'App\\Models\\JenisParkir', 1, 'updated', '{\"id\":1,\"kode\":\"R-PPTJU\",\"nama\":\"Retribusi Pelayanan Parkir Tepi Jalan Umum\",\"deskripsi\":\"Pemasukan retribusi pelayanan parkir di tepi jalan umum.\",\"status\":true,\"created_at\":\"2026-08-20T07:25:12.000000Z\",\"updated_at\":\"2026-08-28T15:41:40.000000Z\"}', '{\"kode\":\"R-PTJU\",\"updated_at\":\"2026-08-28 23:42:19\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 15:42:20', '2026-08-28 15:42:20'),
(178, 1, 'App\\Models\\CapaianBulanan', 4, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"3\",\"target\":\"97541667\",\"realisasi\":\"45321000\",\"catatan\":null,\"updated_at\":\"2026-08-29 00:42:38\",\"created_at\":\"2026-08-29 00:42:38\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:42:38', '2026-08-28 16:42:38'),
(179, 1, 'App\\Models\\CapaianBulanan', 4, 'updated', '{\"id\":4,\"tahun\":2026,\"bulan\":3,\"target\":\"97541667.00\",\"realisasi\":\"45321000.00\",\"catatan\":null,\"created_at\":\"2026-08-28T16:42:38.000000Z\",\"updated_at\":\"2026-08-28T16:42:38.000000Z\"}', '{\"realisasi\":\"102368000\",\"updated_at\":\"2026-08-29 00:43:15\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:43:15', '2026-08-28 16:43:15'),
(180, 1, 'App\\Models\\CapaianBulanan', 4, 'updated', '{\"id\":4,\"tahun\":2026,\"bulan\":3,\"target\":\"97541667.00\",\"realisasi\":\"102368000.00\",\"catatan\":null,\"created_at\":\"2026-08-28T16:42:38.000000Z\",\"updated_at\":\"2026-08-28T16:43:15.000000Z\"}', '{\"realisasi\":\"120000000\",\"updated_at\":\"2026-08-29 00:43:48\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:43:48', '2026-08-28 16:43:48'),
(181, 1, 'App\\Models\\CapaianBulanan', 4, 'updated', '{\"id\":4,\"tahun\":2026,\"bulan\":3,\"target\":\"97541667.00\",\"realisasi\":\"120000000.00\",\"catatan\":null,\"created_at\":\"2026-08-28T16:42:38.000000Z\",\"updated_at\":\"2026-08-28T16:43:48.000000Z\"}', '{\"realisasi\":\"102368000\",\"updated_at\":\"2026-08-29 00:44:01\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:44:01', '2026-08-28 16:44:01'),
(182, 1, 'App\\Models\\CapaianBulanan', 5, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"4\",\"target\":\"97541667\",\"realisasi\":\"102457000\",\"catatan\":null,\"updated_at\":\"2026-08-29 00:44:46\",\"created_at\":\"2026-08-29 00:44:46\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:44:46', '2026-08-28 16:44:46'),
(183, 1, 'App\\Models\\CapaianBulanan', 6, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"5\",\"target\":\"97541667\",\"realisasi\":\"89581000\",\"catatan\":null,\"updated_at\":\"2026-08-29 00:45:38\",\"created_at\":\"2026-08-29 00:45:38\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:45:38', '2026-08-28 16:45:38'),
(184, 1, 'App\\Models\\CapaianBulanan', 7, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"6\",\"target\":\"97541667\",\"realisasi\":\"100939000\",\"catatan\":null,\"updated_at\":\"2026-08-29 00:46:26\",\"created_at\":\"2026-08-29 00:46:26\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:46:26', '2026-08-28 16:46:26'),
(185, 1, 'App\\Models\\CapaianBulanan', 8, 'created', NULL, '{\"tahun\":\"2026\",\"bulan\":\"7\",\"target\":\"97541667\",\"realisasi\":\"107084000\",\"catatan\":null,\"updated_at\":\"2026-08-29 00:47:24\",\"created_at\":\"2026-08-29 00:47:24\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:47:24', '2026-08-28 16:47:24'),
(186, 1, 'App\\Models\\JenisJukir', 1, 'updated', '{\"id\":1,\"kode\":\"J01\",\"nama\":\"Petugas Tetap\",\"deskripsi\":\"Petugas yang ditugaskan secara tetap pada lokasi parkir tertentu.\",\"status\":true,\"created_at\":\"2026-08-19T02:37:01.000000Z\",\"updated_at\":\"2026-08-20T08:05:47.000000Z\"}', '{\"nama\":\"Petugas (PPPK PW)\",\"updated_at\":\"2026-08-29 00:58:10\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:58:10', '2026-08-28 16:58:10'),
(187, 1, 'App\\Models\\JenisJukir', 3, 'updated', '{\"id\":3,\"kode\":\"J03\",\"nama\":\"Petugas Pengganti\",\"deskripsi\":\"Petugas yang menggantikan petugas lain untuk sementara waktu.\",\"status\":true,\"created_at\":\"2026-08-19T02:37:01.000000Z\",\"updated_at\":\"2026-08-20T08:05:47.000000Z\"}', '{\"nama\":\"Petugas Cadangan\",\"updated_at\":\"2026-08-29 00:58:33\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 16:58:33', '2026-08-28 16:58:33'),
(188, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-28 17:20:34', '2026-08-28 17:20:34'),
(189, 1, 'App\\Models\\SumberPemasukan', 4, 'updated', '{\"id\":4,\"kode\":\"R-JASA-USAHA\",\"nama\":\"Retribusi Jasa Usaha \\/ Pemanfaatan Aset Daerah\",\"deskripsi\":\"Sewa pelataran area terminal untuk kegiatan tertentu.\",\"status\":true,\"created_at\":\"2026-08-20T07:45:21.000000Z\",\"updated_at\":\"2026-08-20T07:45:21.000000Z\"}', '{\"deskripsi\":\"Sewa Kios, Sewa pelataran area terminal untuk kegiatan tertentu.\",\"updated_at\":\"2026-08-29 11:38:08\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 03:38:08', '2026-08-29 03:38:08'),
(190, 1, 'App\\Models\\ObjekPendapatan', 3, 'created', NULL, '{\"sumber_pemasukan_id\":\"4\",\"kode\":\"R-JU\\/PAD\",\"nama\":\"KIOS 1\",\"tipe\":\"tempat_usaha\",\"alamat\":\"Jl. Bulu Pattuku\",\"nama_pengelola\":null,\"nomor_identitas\":null,\"jenis_usaha\":null,\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":\"200000\",\"nomor_kontrak\":null,\"kontrak_mulai\":\"2026-01-01 00:00:00\",\"kontrak_selesai\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"status\":\"aktif\",\"updated_at\":\"2026-08-29 11:58:45\",\"created_at\":\"2026-08-29 11:58:45\",\"id\":3}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 03:58:45', '2026-08-29 03:58:45'),
(191, 1, 'App\\Models\\ObjekPendapatan', 3, 'updated', '{\"id\":3,\"sumber_pemasukan_id\":4,\"wajib_pajak_id\":null,\"kode\":\"R-JU\\/PAD\",\"nama\":\"KIOS 1\",\"tipe\":\"tempat_usaha\",\"alamat\":\"Jl. Bulu Pattuku\",\"nama_pengelola\":null,\"nomor_identitas\":null,\"npwp\":null,\"nop\":null,\"masa_pajak_mulai\":null,\"masa_pajak_sampai\":null,\"tarif_pajak\":null,\"jenis_usaha\":null,\"jenis_aset\":null,\"nomor_aset\":null,\"luas_m2\":null,\"tarif_sewa\":\"200000.00\",\"nomor_kontrak\":null,\"kontrak_mulai\":\"2025-12-31T16:00:00.000000Z\",\"kontrak_selesai\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"status\":\"aktif\",\"metadata\":null,\"created_at\":\"2026-08-29T03:58:45.000000Z\",\"updated_at\":\"2026-08-29T03:58:45.000000Z\"}', '{\"potensi_bulanan\":\"200000\",\"updated_at\":\"2026-08-29 11:59:06\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 03:59:06', '2026-08-29 03:59:06'),
(192, 1, 'App\\Models\\Setoran', 5, 'created', NULL, '{\"sumber_pemasukan_id\":\"4\",\"objek_pendapatan_id\":\"3\",\"jukir_id\":null,\"titik_parkir_id\":null,\"tanggal\":\"2026-08-29 00:00:00\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":200000,\"jumlah_setoran\":200000,\"selisih\":0,\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-08-29 12:00:03\",\"created_at\":\"2026-08-29 12:00:03\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:00:03', '2026-08-29 04:00:03'),
(193, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":5,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":20,\"kapasitas_mobil_besar\":30,\"kapasitas_total\":50,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"210000.00\",\"potensi_bulanan\":\"6300000.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-28T07:40:11.000000Z\"}', '{\"sumber_pemasukan_id\":\"4\",\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"potensi_harian\":\"200000\",\"potensi_bulanan\":\"200000\",\"updated_at\":\"2026-08-29 12:03:25\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:03:25', '2026-08-29 04:03:25'),
(194, 1, 'App\\Models\\Setoran', 5, 'updated', '{\"id\":5,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":3,\"jukir_id\":null,\"titik_parkir_id\":null,\"tanggal\":\"2026-08-28T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"200000.00\",\"jumlah_setoran\":\"200000.00\",\"selisih\":\"0.00\",\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-08-29T04:00:03.000000Z\",\"updated_at\":\"2026-08-29T04:00:03.000000Z\"}', '{\"titik_parkir_id\":\"38\",\"updated_at\":\"2026-08-29 12:03:58\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:03:58', '2026-08-29 04:03:58'),
(195, 1, 'App\\Models\\Setoran', 5, 'updated', '{\"id\":5,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":3,\"jukir_id\":null,\"titik_parkir_id\":38,\"tanggal\":\"2026-08-28T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"200000.00\",\"jumlah_setoran\":\"200000.00\",\"selisih\":\"0.00\",\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-08-29T04:00:03.000000Z\",\"updated_at\":\"2026-08-29T04:03:58.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-08-29 12:04:31\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-08-29 12:04:31\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:04:31', '2026-08-29 04:04:31'),
(196, 1, 'App\\Models\\JenisParkir', 4, 'updated', '{\"id\":4,\"kode\":\"R-PKU\",\"nama\":\"Parkir Kegiatan Usaha\",\"deskripsi\":\"Parkir yang berkaitan dengan kegiatan usaha\",\"status\":true,\"created_at\":\"2026-08-21T10:44:16.000000Z\",\"updated_at\":\"2026-08-24T15:45:15.000000Z\"}', '{\"nama\":\"Retribusi Parkir Kegiatan Usaha\",\"updated_at\":\"2026-08-29 12:25:58\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:25:58', '2026-08-29 04:25:58'),
(197, 1, 'App\\Models\\JenisJukir', 4, 'created', NULL, '{\"kode\":\"J04\",\"nama\":\"Koordinator Kios\",\"deskripsi\":null,\"status\":\"1\",\"updated_at\":\"2026-08-29 12:56:40\",\"created_at\":\"2026-08-29 12:56:40\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:56:40', '2026-08-29 04:56:40'),
(198, 1, 'App\\Models\\JenisJukir', 4, 'updated', '{\"id\":4,\"kode\":\"J04\",\"nama\":\"Koordinator Kios\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-29T04:56:40.000000Z\",\"updated_at\":\"2026-08-29T04:56:40.000000Z\"}', '{\"nama\":\"Petugas (PNS)\",\"updated_at\":\"2026-08-29 12:57:24\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:57:24', '2026-08-29 04:57:24'),
(199, 1, 'App\\Models\\JenisJukir', 4, 'updated', '{\"id\":4,\"kode\":\"J04\",\"nama\":\"Petugas (PNS)\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-29T04:56:40.000000Z\",\"updated_at\":\"2026-08-29T04:57:24.000000Z\"}', '{\"nama\":\"Petugas\\/Koordinator (PNS)\",\"updated_at\":\"2026-08-29 12:57:36\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 04:57:36', '2026-08-29 04:57:36'),
(200, 1, 'App\\Models\\JenisJukir', 4, 'deleted', '{\"id\":4,\"kode\":\"J04\",\"nama\":\"Petugas\\/Koordinator (PNS)\",\"deskripsi\":null,\"status\":true,\"created_at\":\"2026-08-29T04:56:40.000000Z\",\"updated_at\":\"2026-08-29T04:57:36.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 05:01:22', '2026-08-29 05:01:22'),
(201, 1, 'App\\Models\\JenisJukir', 5, 'created', NULL, '{\"kode\":\"J04\",\"nama\":\"Koordinator (PNS)\",\"deskripsi\":\"Petugas yang bertugas mengkoornasikan terkait Retribusi Pemanfaatan Aset Daerah\",\"status\":\"1\",\"updated_at\":\"2026-08-29 13:03:11\",\"created_at\":\"2026-08-29 13:03:11\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 05:03:11', '2026-08-29 05:03:11'),
(202, 1, 'App\\Models\\JenisParkir', 5, 'created', NULL, '{\"kode\":\"R-JU\\/PAD\",\"nama\":\"Sewa Kios\",\"deskripsi\":\"Penerimaan dari pemanfaatan aset daerah berupa kios yang disewakan kepada pihak untuk kegiatan usaha\",\"status\":\"1\",\"updated_at\":\"2026-08-29 15:57:11\",\"created_at\":\"2026-08-29 15:57:11\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 07:57:11', '2026-08-29 07:57:11'),
(203, 1, 'App\\Models\\JenisParkir', 6, 'created', NULL, '{\"kode\":\"R-PAD\",\"nama\":\"Pemanfaatan Aset Daerah\",\"deskripsi\":\"Penerimaan atas pemanfaatan aset daerah yang dikelola UPTD Terminal dan Perparkiran untuk kepentingan tertentu sesuai ketentuan dan perjanjian pemanfaatan yang berlaku\",\"status\":\"1\",\"updated_at\":\"2026-08-29 15:58:13\",\"created_at\":\"2026-08-29 15:58:13\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 07:58:13', '2026-08-29 07:58:13');
INSERT INTO `audit_logs` (`id`, `user_id`, `auditable_type`, `auditable_id`, `action`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(204, 1, 'App\\Models\\JenisParkir', 7, 'created', NULL, '{\"kode\":\"R-PPAT\",\"nama\":\"Penyewaan Pelataran Area Terminal\",\"deskripsi\":\"Penerimaan dari penyewaan pelataran atau area tertentu pada kawasan terminal untuk digunakan oleh pihak tertentu sesuai peruntukan dan ketentuan yang berlaku.\",\"status\":\"1\",\"updated_at\":\"2026-08-29 15:58:52\",\"created_at\":\"2026-08-29 15:58:52\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 07:58:52', '2026-08-29 07:58:52'),
(205, 1, 'App\\Models\\Setoran', 5, 'deleted', '{\"id\":5,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":3,\"jukir_id\":null,\"titik_parkir_id\":38,\"tanggal\":\"2026-08-28T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"200000.00\",\"jumlah_setoran\":\"200000.00\",\"selisih\":\"0.00\",\"status\":\"terverifikasi\",\"keterangan\":null,\"diverifikasi_at\":\"2026-08-29T04:04:31.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-08-29T04:00:03.000000Z\",\"updated_at\":\"2026-08-29T04:04:31.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 08:32:29', '2026-08-29 08:32:29'),
(206, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":4,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":20,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"jumlah_unit\":null,\"luas_m2\":null,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"200000.00\",\"potensi_bulanan\":\"200000.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-29T04:03:25.000000Z\"}', '{\"kapasitas_motor\":null,\"kapasitas_mobil_kecil\":null,\"jumlah_unit\":\"1\",\"luas_m2\":\"0\",\"potensi_harian\":null,\"potensi_bulanan\":null,\"updated_at\":\"2026-08-29 17:01:23\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 09:01:23', '2026-08-29 09:01:23'),
(207, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":4,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":null,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"jumlah_unit\":1,\"luas_m2\":\"0.00\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":null,\"potensi_bulanan\":null,\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-29T09:01:23.000000Z\"}', '{\"sumber_pemasukan_id\":\"5\",\"updated_at\":\"2026-08-29 17:09:52\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 09:09:52', '2026-08-29 09:09:52'),
(208, 1, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":5,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":null,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"jumlah_unit\":1,\"luas_m2\":\"0.00\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":null,\"potensi_bulanan\":null,\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-29T09:09:52.000000Z\"}', '{\"sumber_pemasukan_id\":\"4\",\"updated_at\":\"2026-08-29 17:10:49\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 09:10:49', '2026-08-29 09:10:49'),
(209, 1, 'App\\Models\\Setoran', 6, 'created', NULL, '{\"sumber_pemasukan_id\":\"4\",\"objek_pendapatan_id\":\"3\",\"jukir_id\":\"6\",\"titik_parkir_id\":\"38\",\"tanggal\":\"2026-08-29 00:00:00\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":200000,\"jumlah_setoran\":200000,\"selisih\":0,\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-08-29 20:32:05\",\"created_at\":\"2026-08-29 20:32:05\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 12:32:05', '2026-08-29 12:32:05'),
(210, 1, 'App\\Models\\Setoran', 6, 'updated', '{\"id\":6,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":3,\"jukir_id\":6,\"titik_parkir_id\":38,\"tanggal\":\"2026-08-28T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"200000.00\",\"jumlah_setoran\":\"200000.00\",\"selisih\":\"0.00\",\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-08-29T12:32:05.000000Z\",\"updated_at\":\"2026-08-29T12:32:05.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-08-29 20:32:57\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-08-29 20:32:57\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 12:32:57', '2026-08-29 12:32:57'),
(211, 1, 'App\\Models\\Setoran', 6, 'deleted', '{\"id\":6,\"sumber_pemasukan_id\":4,\"objek_pendapatan_id\":3,\"jukir_id\":6,\"titik_parkir_id\":38,\"tanggal\":\"2026-08-28T16:00:00.000000Z\",\"jumlah_motor\":null,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":null,\"jumlah_mobil_besar\":null,\"pendapatan_bruto\":\"200000.00\",\"jumlah_setoran\":\"200000.00\",\"selisih\":\"0.00\",\"status\":\"terverifikasi\",\"keterangan\":null,\"diverifikasi_at\":\"2026-08-29T12:32:57.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-08-29T12:32:05.000000Z\",\"updated_at\":\"2026-08-29T12:32:57.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 13:49:41', '2026-08-29 13:49:41'),
(212, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-29 14:49:54', '2026-08-29 14:49:54'),
(213, 1, 'App\\Models\\SumberPemasukan', 4, 'updated', '{\"id\":4,\"kode\":\"R-JASA-USAHA\",\"nama\":\"Retribusi Jasa Usaha \\/ Pemanfaatan Aset Daerah\",\"deskripsi\":\"Sewa Kios, Sewa pelataran area terminal untuk kegiatan tertentu.\",\"status\":true,\"created_at\":\"2026-08-20T07:45:21.000000Z\",\"updated_at\":\"2026-08-29T03:38:08.000000Z\"}', '{\"kode\":\"R-JU-PAD\",\"updated_at\":\"2026-08-30 09:41:19\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-30 01:41:19', '2026-08-30 01:41:19'),
(214, 1, 'App\\Models\\SumberPemasukan', 4, 'updated', '{\"id\":4,\"kode\":\"R-JU-PAD\",\"nama\":\"Retribusi Jasa Usaha \\/ Pemanfaatan Aset Daerah\",\"deskripsi\":\"Sewa Kios, Sewa pelataran area terminal untuk kegiatan tertentu.\",\"status\":true,\"created_at\":\"2026-08-20T07:45:21.000000Z\",\"updated_at\":\"2026-08-30T01:41:19.000000Z\"}', '{\"kode\":\"R-SPATKT\",\"nama\":\"Retribusi Sewa Pelataran Area Terminal Untuk Kegiatan Tertentu\",\"deskripsi\":\"Sewa pelataran area terminal untuk kegiatan tertentu.\",\"updated_at\":\"2026-08-30 09:57:25\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-30 01:57:25', '2026-08-30 01:57:25'),
(215, NULL, 'App\\Models\\TitikParkir', 38, 'updated', '{\"id\":38,\"kode_titik\":\"R.Kios-01\",\"nama\":\"KIOS 1\",\"alamat\":\"Jl. Bulu Patukku\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":null,\"sumber_pemasukan_id\":4,\"latitude\":\"-5.1135930\",\"longitude\":\"120.2524340\",\"status\":\"aktif\",\"kapasitas_motor\":null,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"jumlah_unit\":1,\"luas_m2\":\"0.00\",\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":null,\"potensi_bulanan\":null,\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T16:36:30.000000Z\",\"updated_at\":\"2026-08-29T09:10:49.000000Z\"}', '{\"sumber_pemasukan_id\":5,\"updated_at\":\"2026-08-30 10:46:04\"}', '127.0.0.1', 'Symfony', '2026-08-30 02:46:04', '2026-08-30 02:46:04'),
(216, 1, 'App\\Models\\TitikParkir', 39, 'created', NULL, '{\"kode_titik\":\"SW.PLR\",\"nama\":\"Penjualan Usaha Cakar\",\"alamat\":\"Terminal Tellu Limpoe\",\"kecamatan_id\":\"7\",\"kelurahan_id\":\"65\",\"jenis_parkir_id\":\"7\",\"sumber_pemasukan_id\":\"4\",\"latitude\":\"-5.113082\",\"longitude\":\"120.251204\",\"status\":\"aktif\",\"kapasitas_motor\":\"0\",\"kapasitas_mobil_kecil\":\"0\",\"kapasitas_mobil_besar\":\"0\",\"kapasitas_total\":\"0\",\"jumlah_unit\":null,\"luas_m2\":null,\"nama_pengelola\":\"Syarif\",\"telepon_pengelola\":null,\"potensi_harian\":\"0\",\"potensi_bulanan\":\"0\",\"keterangan\":null,\"updated_at\":\"2026-08-30 16:51:49\",\"created_at\":\"2026-08-30 16:51:49\",\"id\":39}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-30 08:51:49', '2026-08-30 08:51:49'),
(217, 1, 'App\\Models\\TitikParkir', 39, 'updated', '{\"id\":39,\"kode_titik\":\"SW.PLR\",\"nama\":\"Penjualan Usaha Cakar\",\"alamat\":\"Terminal Tellu Limpoe\",\"kecamatan_id\":7,\"kelurahan_id\":65,\"jenis_parkir_id\":7,\"sumber_pemasukan_id\":4,\"latitude\":\"-5.1130820\",\"longitude\":\"120.2512040\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"jumlah_unit\":null,\"luas_m2\":null,\"nama_pengelola\":\"Syarif\",\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-30T08:51:49.000000Z\",\"updated_at\":\"2026-08-30T08:51:49.000000Z\"}', '{\"alamat\":\"Jl. Bulu Pattuku (Terminal Tellu Limpoe)\",\"jenis_parkir_id\":null,\"kapasitas_motor\":null,\"kapasitas_mobil_kecil\":null,\"kapasitas_mobil_besar\":null,\"kapasitas_total\":null,\"potensi_harian\":null,\"potensi_bulanan\":null,\"updated_at\":\"2026-08-30 17:29:22\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-30 09:29:22', '2026-08-30 09:29:22'),
(218, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-30 15:01:09', '2026-08-30 15:01:09'),
(219, 1, 'App\\Models\\PenempatanJukir', 4, 'created', NULL, '{\"jukir_id\":\"6\",\"titik_parkir_id\":\"3\",\"role\":\"koordinator\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-08-30 23:29:01\",\"created_at\":\"2026-08-30 23:29:01\",\"id\":4}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-08-30 15:29:01', '2026-08-30 15:29:01'),
(220, 1, 'App\\Models\\PenempatanJukir', 4, 'updated', '{\"id\":4,\"jukir_id\":6,\"titik_parkir_id\":3,\"role\":\"koordinator\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"created_at\":\"2026-08-30T15:29:01.000000Z\",\"updated_at\":\"2026-08-30T15:29:01.000000Z\"}', '{\"titik_parkir_id\":\"21\",\"target_per_hari\":\"90000\",\"updated_at\":\"2026-09-01 22:27:10\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:27:10', '2026-09-01 14:27:10'),
(221, 1, 'App\\Models\\PenempatanJukir', 2, 'updated', '{\"id\":2,\"jukir_id\":4,\"titik_parkir_id\":3,\"role\":\"anggota\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"created_at\":\"2026-08-21T11:05:30.000000Z\",\"updated_at\":\"2026-08-21T11:05:30.000000Z\"}', '{\"jukir_id\":\"36\",\"titik_parkir_id\":\"21\",\"updated_at\":\"2026-09-01 22:28:15\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:28:15', '2026-09-01 14:28:15'),
(222, 1, 'App\\Models\\PenempatanJukir', 5, 'created', NULL, '{\"jukir_id\":\"18\",\"titik_parkir_id\":\"21\",\"role\":\"anggota\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-09-01 22:29:55\",\"created_at\":\"2026-09-01 22:29:55\",\"id\":5}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:29:55', '2026-09-01 14:29:55'),
(223, 1, 'App\\Models\\PenempatanJukir', 6, 'created', NULL, '{\"jukir_id\":\"11\",\"titik_parkir_id\":\"28\",\"role\":\"koordinator\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-09-01 22:31:32\",\"created_at\":\"2026-09-01 22:31:32\",\"id\":6}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:31:32', '2026-09-01 14:31:32'),
(224, 1, 'App\\Models\\PenempatanJukir', 6, 'updated', '{\"id\":6,\"jukir_id\":11,\"titik_parkir_id\":28,\"role\":\"koordinator\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2025-12-31T16:00:00.000000Z\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"created_at\":\"2026-09-01T14:31:32.000000Z\",\"updated_at\":\"2026-09-01T14:31:32.000000Z\"}', '{\"target_per_hari\":\"300000\",\"updated_at\":\"2026-09-01 22:32:05\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:32:05', '2026-09-01 14:32:05'),
(225, 1, 'App\\Models\\PenempatanJukir', 7, 'created', NULL, '{\"jukir_id\":\"23\",\"titik_parkir_id\":\"28\",\"role\":\"anggota\",\"target_per_hari\":null,\"waktu_kerja\":null,\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-09-01 22:35:09\",\"created_at\":\"2026-09-01 22:35:09\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:35:09', '2026-09-01 14:35:09'),
(226, 1, 'App\\Models\\PenempatanJukir', 8, 'created', NULL, '{\"jukir_id\":\"30\",\"titik_parkir_id\":\"29\",\"role\":\"koordinator\",\"target_per_hari\":\"200000\",\"waktu_kerja\":null,\"tanggal_mulai\":\"2026-01-01 00:00:00\",\"tanggal_selesai\":null,\"status\":\"aktif\",\"surat_penugasan\":null,\"keterangan\":null,\"created_by\":1,\"updated_at\":\"2026-09-01 22:36:27\",\"created_at\":\"2026-09-01 22:36:27\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:36:27', '2026-09-01 14:36:27'),
(227, 1, 'App\\Models\\Setoran', 7, 'created', NULL, '{\"sumber_pemasukan_id\":\"2\",\"objek_pendapatan_id\":null,\"jukir_id\":\"30\",\"titik_parkir_id\":\"29\",\"tanggal\":\"2026-07-01 00:00:00\",\"jumlah_motor\":\"25\",\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":\"30\",\"jumlah_mobil_besar\":\"0\",\"pendapatan_bruto\":130000,\"jumlah_setoran\":130000,\"selisih\":0,\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-09-01 22:39:33\",\"created_at\":\"2026-09-01 22:39:33\",\"id\":7}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:39:33', '2026-09-01 14:39:33'),
(228, 1, 'App\\Models\\Setoran', 7, 'updated', '{\"id\":7,\"sumber_pemasukan_id\":2,\"objek_pendapatan_id\":null,\"jukir_id\":30,\"titik_parkir_id\":29,\"tanggal\":\"2026-06-30T16:00:00.000000Z\",\"jumlah_motor\":25,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":30,\"jumlah_mobil_besar\":0,\"pendapatan_bruto\":\"130000.00\",\"jumlah_setoran\":\"130000.00\",\"selisih\":\"0.00\",\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-09-01T14:39:33.000000Z\",\"updated_at\":\"2026-09-01T14:39:33.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-09-01 22:39:48\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-09-01 22:39:48\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:39:48', '2026-09-01 14:39:48'),
(229, 1, 'App\\Models\\Setoran', 7, 'deleted', '{\"id\":7,\"sumber_pemasukan_id\":2,\"objek_pendapatan_id\":null,\"jukir_id\":30,\"titik_parkir_id\":29,\"tanggal\":\"2026-06-30T16:00:00.000000Z\",\"jumlah_motor\":25,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":30,\"jumlah_mobil_besar\":0,\"pendapatan_bruto\":\"130000.00\",\"jumlah_setoran\":\"130000.00\",\"selisih\":\"0.00\",\"status\":\"terverifikasi\",\"keterangan\":null,\"diverifikasi_at\":\"2026-09-01T14:39:48.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-09-01T14:39:33.000000Z\",\"updated_at\":\"2026-09-01T14:39:48.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:40:43', '2026-09-01 14:40:43'),
(230, 1, 'App\\Models\\Setoran', 8, 'created', NULL, '{\"sumber_pemasukan_id\":\"2\",\"objek_pendapatan_id\":null,\"jukir_id\":\"30\",\"titik_parkir_id\":\"29\",\"tanggal\":\"2026-07-01 00:00:00\",\"jumlah_motor\":\"25\",\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":\"30\",\"jumlah_mobil_besar\":\"0\",\"pendapatan_bruto\":140000,\"jumlah_setoran\":140000,\"selisih\":0,\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"updated_at\":\"2026-09-01 22:41:56\",\"created_at\":\"2026-09-01 22:41:56\",\"id\":8}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:41:56', '2026-09-01 14:41:56'),
(231, 1, 'App\\Models\\Setoran', 8, 'updated', '{\"id\":8,\"sumber_pemasukan_id\":2,\"objek_pendapatan_id\":null,\"jukir_id\":30,\"titik_parkir_id\":29,\"tanggal\":\"2026-06-30T16:00:00.000000Z\",\"jumlah_motor\":25,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":30,\"jumlah_mobil_besar\":0,\"pendapatan_bruto\":\"140000.00\",\"jumlah_setoran\":\"140000.00\",\"selisih\":\"0.00\",\"status\":\"belum_verifikasi\",\"keterangan\":null,\"diverifikasi_at\":null,\"diverifikasi_oleh\":null,\"created_at\":\"2026-09-01T14:41:56.000000Z\",\"updated_at\":\"2026-09-01T14:41:56.000000Z\"}', '{\"status\":\"terverifikasi\",\"diverifikasi_at\":\"2026-09-01 22:42:37\",\"diverifikasi_oleh\":1,\"updated_at\":\"2026-09-01 22:42:37\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:42:37', '2026-09-01 14:42:37'),
(232, 1, 'App\\Models\\TitikParkir', 29, 'updated', '{\"id\":29,\"kode_titik\":\"TP-EKS-027\",\"nama\":\"POS TPI LAPPA\",\"alamat\":\"Jl. Kalampeto\",\"kecamatan_id\":7,\"kelurahan_id\":66,\"jenis_parkir_id\":1,\"sumber_pemasukan_id\":2,\"latitude\":\"-5.1077300\",\"longitude\":\"120.2707500\",\"status\":\"aktif\",\"kapasitas_motor\":0,\"kapasitas_mobil\":null,\"kapasitas_mobil_kecil\":0,\"kapasitas_mobil_besar\":0,\"kapasitas_total\":0,\"jumlah_unit\":null,\"luas_m2\":null,\"nama_pengelola\":null,\"telepon_pengelola\":null,\"potensi_harian\":\"0.00\",\"potensi_bulanan\":\"0.00\",\"foto\":null,\"keterangan\":null,\"created_at\":\"2026-08-24T12:51:33.000000Z\",\"updated_at\":\"2026-08-24T12:53:26.000000Z\"}', '{\"potensi_harian\":\"200000\",\"potensi_bulanan\":\"6000000\",\"updated_at\":\"2026-09-01 22:45:35\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:154.0) Gecko/20100101 Firefox/154.0', '2026-09-01 14:45:35', '2026-09-01 14:45:35'),
(233, 1, 'App\\Models\\User', 1, 'updated', '{\"id\":1,\"name\":\"Administrator\",\"email\":\"admin@sijukir.sinjai.go.id\",\"email_verified_at\":null,\"role\":\"admin\",\"status\":\"aktif\",\"created_at\":\"2026-08-19T19:19:44.000000Z\",\"updated_at\":\"2026-08-19T19:19:44.000000Z\"}', '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:155.0) Gecko/20100101 Firefox/155.0', '2026-09-09 01:18:56', '2026-09-09 01:18:56'),
(234, 1, 'App\\Models\\Setoran', 8, 'deleted', '{\"id\":8,\"sumber_pemasukan_id\":2,\"objek_pendapatan_id\":null,\"jukir_id\":30,\"titik_parkir_id\":29,\"tanggal\":\"2026-06-30T16:00:00.000000Z\",\"jumlah_motor\":25,\"jumlah_mobil\":null,\"jumlah_mobil_kecil\":30,\"jumlah_mobil_besar\":0,\"pendapatan_bruto\":\"140000.00\",\"jumlah_setoran\":\"140000.00\",\"selisih\":\"0.00\",\"status\":\"terverifikasi\",\"keterangan\":null,\"diverifikasi_at\":\"2026-09-01T14:42:37.000000Z\",\"diverifikasi_oleh\":1,\"created_at\":\"2026-09-01T14:41:56.000000Z\",\"updated_at\":\"2026-09-01T14:42:37.000000Z\"}', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:159.0) Gecko/20100101 Firefox/159.0', '2026-11-02 12:20:35', '2026-11-02 12:20:35'),
(235, 1, 'App\\Models\\SumberPemasukan', 2, 'updated', '{\"id\":2,\"kode\":\"R-PJTU\",\"nama\":\"Retribusi Parkir Tepi Jalan Umum\",\"deskripsi\":\"Pemasukan retribusi parkir di tepi jalan umum.\",\"status\":true,\"created_at\":\"2026-08-20T07:45:21.000000Z\",\"updated_at\":\"2026-08-20T07:45:21.000000Z\"}', '{\"kode\":\"R-PTJU\",\"updated_at\":\"2026-11-02 20:52:28\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:159.0) Gecko/20100101 Firefox/159.0', '2026-11-02 12:52:28', '2026-11-02 12:52:28'),
(236, 1, 'App\\Models\\SumberPemasukan', 2, 'updated', '{\"id\":2,\"kode\":\"R-PTJU\",\"nama\":\"Retribusi Parkir Tepi Jalan Umum\",\"deskripsi\":\"Pemasukan retribusi parkir di tepi jalan umum.\",\"status\":true,\"created_at\":\"2026-08-20T07:45:21.000000Z\",\"updated_at\":\"2026-11-02T12:52:28.000000Z\"}', '{\"kode\":\"R-PJTU\",\"updated_at\":\"2026-11-02 20:53:51\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:159.0) Gecko/20100101 Firefox/159.0', '2026-11-02 12:53:51', '2026-11-02 12:53:51');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `capaian_bulanans`
--

CREATE TABLE `capaian_bulanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` int(10) UNSIGNED NOT NULL,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `target` decimal(15,2) NOT NULL DEFAULT 0.00,
  `realisasi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `capaian_bulanans`
--

INSERT INTO `capaian_bulanans` (`id`, `tahun`, `bulan`, `target`, `realisasi`, `catatan`, `created_at`, `updated_at`) VALUES
(2, 2026, 1, 97541667.00, 95369000.00, NULL, '2026-08-28 07:04:08', '2026-08-28 07:04:08'),
(3, 2026, 2, 97541667.00, 96046000.00, NULL, '2026-08-28 07:05:40', '2026-08-28 07:05:40'),
(4, 2026, 3, 97541667.00, 102368000.00, NULL, '2026-08-28 16:42:38', '2026-08-28 16:44:01'),
(5, 2026, 4, 97541667.00, 102457000.00, NULL, '2026-08-28 16:44:46', '2026-08-28 16:44:46'),
(6, 2026, 5, 97541667.00, 89581000.00, NULL, '2026-08-28 16:45:38', '2026-08-28 16:45:38'),
(7, 2026, 6, 97541667.00, 100939000.00, NULL, '2026-08-28 16:46:26', '2026-08-28 16:46:26'),
(8, 2026, 7, 97541667.00, 107084000.00, NULL, '2026-08-28 16:47:24', '2026-08-28 16:47:24');

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
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `tanggal_kegiatan` date DEFAULT NULL,
  `gallery_group` char(36) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `urutan` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `judul`, `kategori`, `tanggal_kegiatan`, `gallery_group`, `deskripsi`, `gambar`, `is_active`, `urutan`, `created_at`, `updated_at`) VALUES
(1, 'Kunjungan Kerja', 'Rapat & Kunjungan', '2026-01-01', '0913e997-8b40-4c5c-826d-8447cdeb245f', 'Kunjungan kerja UPTD. Terminal dan Perparkiran Dinas Perhubungan Kab. Sinjai terkait dengan parkir  dan sistem sijukir', 'gallery/N0blfHUO7ivabYOTFd5eqDoudfkWrBdvz0X6FUcS.jpg', 1, 1, '2026-08-28 13:00:51', '2026-08-28 13:41:32'),
(6, 'Kunjungan Kerja', 'Rapat & Kunjungan', '2026-01-01', '0913e997-8b40-4c5c-826d-8447cdeb245f', 'Kunjungan kerja UPTD. Terminal dan Perparkiran Dinas Perhubungan Kab. Sinjai terkait dengan parkir  dan sistem sijukir', 'gallery/ljNUsxZfAYAQKHOwHhegwwQPx0z1w2V23LaRr44x.jpg', 1, 1, '2026-08-28 13:54:04', '2026-08-28 13:54:04'),
(7, 'Kunjungan Kerja', 'Rapat & Kunjungan', '2026-01-01', '0913e997-8b40-4c5c-826d-8447cdeb245f', 'Kunjungan kerja UPTD. Terminal dan Perparkiran Dinas Perhubungan Kab. Sinjai terkait dengan parkir  dan sistem sijukir', 'gallery/AGV57iEBcuS1nxQsgoGBErwSytvRsALieNXne1N1.jpg', 1, 1, '2026-08-28 13:54:04', '2026-08-28 13:54:04'),
(8, '45hjghfdsasnbm', 'Sosialisasi', '2026-08-12', '303221e7-668e-4fce-8e89-bd0728ff4473', 'ertjhkjlkkmvnbcvxzcbn,mvnbc', 'gallery/U9U4sPuzGHPEU6avABDcNGRNbzCOXz6lxjP7TZjO.jpg', 1, 2, '2026-08-28 14:02:26', '2026-08-28 14:02:26'),
(9, 'fghgjkhjhgdfsdf', 'Uji Petik', '2026-08-19', '43744b0d-883e-4de3-bc9f-2a6eb15da821', 'rthgjhkjk,mgfdgsadcbvn', 'gallery/FzdZAjx8n8A3f1jw8wjwNQ2uhS2Bj3ENkLT6b44g.jpg', 1, 3, '2026-08-28 14:03:15', '2026-08-28 14:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_jukirs`
--

CREATE TABLE `jenis_jukirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_jukirs`
--

INSERT INTO `jenis_jukirs` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'J01', 'Petugas (PPPK PW)', 'Petugas yang ditugaskan secara tetap pada lokasi parkir tertentu.', 1, '2026-08-19 02:37:01', '2026-08-28 16:58:10'),
(2, 'J02', 'Petugas Tidak Tetap', 'Petugas yang bertugas berdasarkan kebutuhan atau penugasan tertentu.', 1, '2026-08-19 02:37:01', '2026-08-20 08:05:47'),
(3, 'J03', 'Petugas Cadangan', 'Petugas yang menggantikan petugas lain untuk sementara waktu.', 1, '2026-08-19 02:37:01', '2026-08-28 16:58:33'),
(5, 'J04', 'Koordinator (PNS)', 'Petugas yang bertugas mengkoornasikan terkait Retribusi Pemanfaatan Aset Daerah', 1, '2026-08-29 05:03:11', '2026-08-29 05:03:11');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_parkirs`
--

CREATE TABLE `jenis_parkirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_parkirs`
--

INSERT INTO `jenis_parkirs` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'R-PTJU', 'Retribusi Pelayanan Parkir Tepi Jalan Umum', 'Pemasukan retribusi pelayanan parkir di tepi jalan umum.', 1, '2026-08-20 07:25:12', '2026-08-28 15:42:19'),
(2, 'R-TKP', 'Retribusi Tempat Khusus Parkir', 'Pemasukan retribusi dari tempat khusus parkir.', 1, '2026-08-20 07:25:12', '2026-08-20 07:25:12'),
(4, 'R-PKU', 'Retribusi Parkir Kegiatan Usaha', 'Parkir yang berkaitan dengan kegiatan usaha', 1, '2026-08-21 10:44:16', '2026-08-29 04:25:58'),
(5, 'R-JU/PAD', 'Sewa Kios', 'Penerimaan dari pemanfaatan aset daerah berupa kios yang disewakan kepada pihak untuk kegiatan usaha', 1, '2026-08-29 07:57:11', '2026-08-29 07:57:11'),
(6, 'R-PAD', 'Pemanfaatan Aset Daerah', 'Penerimaan atas pemanfaatan aset daerah yang dikelola UPTD Terminal dan Perparkiran untuk kepentingan tertentu sesuai ketentuan dan perjanjian pemanfaatan yang berlaku', 1, '2026-08-29 07:58:13', '2026-08-29 07:58:13'),
(7, 'R-PPAT', 'Penyewaan Pelataran Area Terminal', 'Penerimaan dari penyewaan pelataran atau area tertentu pada kawasan terminal untuk digunakan oleh pihak tertentu sesuai peruntukan dan ketentuan yang berlaku.', 1, '2026-08-29 07:58:52', '2026-08-29 07:58:52');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jukirs`
--

CREATE TABLE `jukirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_jukir` varchar(30) NOT NULL,
  `jenis_jukir_id` bigint(20) UNSIGNED NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kecamatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kelurahan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_ktp` varchar(255) DEFAULT NULL,
  `dokumen_pendukung` varchar(255) DEFAULT NULL,
  `nomor_kartu` varchar(255) DEFAULT NULL,
  `tanggal_terdaftar` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `status` enum('aktif','nonaktif','ditangguhkan','berhenti') NOT NULL DEFAULT 'aktif',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jukirs`
--

INSERT INTO `jukirs` (`id`, `kode_jukir`, `jenis_jukir_id`, `nik`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `kecamatan_id`, `kelurahan_id`, `no_hp`, `foto`, `foto_ktp`, `dokumen_pendukung`, `nomor_kartu`, `tanggal_terdaftar`, `tanggal_berakhir`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(4, 'JKR-00001', 1, '7308051306940002', 'A. HASBI ALAM', 'Sinjai', '1990-01-01', 'L', 'Jl. -', 7, 64, '081234567801', 'jukir/foto/D5aGeLLzRpvHZFjKiE7KoFKTAscLaLtxDyU57ady.png', NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-21 10:39:47', '2026-08-28 11:59:38'),
(6, 'JKR-00002', 1, '7307052004900004', 'AMRI', 'Sinjai', '1990-01-01', 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:53:25', '2026-08-28 09:53:25'),
(7, 'JKR-00003', 1, '7308031404880002', 'ANDI AFFANDY', 'Bone', NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:54:13', '2026-08-28 09:54:13'),
(8, 'JKR-00004', 1, '7308031211860001', 'ANDI JUAENI', NULL, NULL, NULL, 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:54:59', '2026-08-28 09:54:59'),
(9, 'JKR-00005', 1, '7308031010820002', 'ANDI TAPPU', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:55:43', '2026-08-28 09:55:43'),
(10, 'JKR-00006', 1, '7307041512910001', 'ARFAN ARDIANTO', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:56:27', '2026-08-28 09:56:27'),
(11, 'JKR-00007', 1, '7308073012880001', 'ASRUN', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:57:08', '2026-08-28 09:57:08'),
(12, 'JKR-00008', 1, '7307063110970001', 'BAHARUDDIN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:58:16', '2026-08-28 09:58:16'),
(13, 'JKR-00009', 1, '7307040509830001', 'FAJAR AKSAN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:58:55', '2026-08-28 09:58:55'),
(14, 'JKR-00010', 1, '7307052703880002', 'FAJRIN USMAN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 09:59:32', '2026-08-28 09:59:32'),
(15, 'JKR-00011', 1, '7307021707000002', 'HAMDAN JAYA AFIAT', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:00:30', '2026-08-28 10:00:30'),
(16, 'JKR-00012', 1, '7307040205880002', 'HENDRA', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:01:10', '2026-08-28 10:01:10'),
(17, 'JKR-00013', 1, '7307020709920002', 'IKBAL', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:01:49', '2026-08-28 10:01:49'),
(18, 'JKR-00014', 1, '7307051807960002', 'IMAM SYARIF', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:02:37', '2026-08-28 10:02:37'),
(19, 'JKR-00015', 1, '7307032010870004', 'IRWAN SYAH FAJAR', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:05:00', '2026-08-28 10:05:00'),
(20, 'JKR-00016', 1, '7302091601840000', 'IRWANYAH', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:06:15', '2026-08-28 10:06:15'),
(21, 'JKR-00017', 1, '7307022402810004', 'ISKANDAR ZULKARNAIN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:07:07', '2026-08-28 10:07:07'),
(22, 'JKR-00018', 1, '7307053101900002', 'LUKMANUL HAKIM', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:07:46', '2026-08-28 10:07:46'),
(23, 'JKR-00019', 1, '7307050411000008', 'MAHDI T', NULL, NULL, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:09:42', '2026-08-28 10:09:42'),
(24, 'JKR-00020', 1, '7307051607010001', 'MUH ASFARUDDIN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:10:28', '2026-08-28 10:10:28'),
(25, 'JKR-00021', 1, '7307082010910001', 'MUH JALIL', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:11:06', '2026-08-28 10:11:06'),
(26, 'JKR-00022', 1, '7307030405590003', 'MUHAMAD NASIR', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:15:40', '2026-08-28 10:15:40'),
(27, 'JKR-00023', 1, '7307051507820003', 'MUHAMMAD HIDAYAT', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:16:30', '2026-08-28 10:16:30'),
(28, 'JKR-00024', 1, '7307052608740001', 'MUHAMMADIAH', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:17:33', '2026-08-28 10:17:33'),
(29, 'JKR-00025', 1, '7302070707830000', 'NANAM KASIM', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:18:17', '2026-08-28 10:18:17'),
(30, 'JKR-00026', 1, '7307052101890001', 'NASRULLAH', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:18:56', '2026-08-28 10:18:56'),
(31, 'JKR-00027', 1, '7307050811990002', 'NUR IKRAM', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:19:32', '2026-08-28 10:19:32'),
(32, 'JKR-00028', 1, '7307051503810003', 'RUSMAN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:20:08', '2026-08-28 10:20:08'),
(33, 'JKR-00029', 1, '7307053112870040', 'SAHRUDDIN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:20:56', '2026-08-28 10:20:56'),
(34, 'JKR-00030', 1, '7307021509860002', 'SATRIAWAN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:21:32', '2026-08-28 10:21:32'),
(35, 'JKR-00031', 1, '7307051410800006', 'SIRAJUDDIN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 10:23:06', '2026-08-28 10:23:06'),
(36, 'JKR-00032', 1, '7308030604960001', 'SUPRIADI', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 11:30:37', '2026-08-28 11:31:25'),
(37, 'JKR-00033', 1, '7307062303690002', 'SYAMSUDDIN', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 11:31:09', '2026-08-28 11:31:43'),
(38, 'JKR-00034', 1, '7307023112700018', 'UMAR', NULL, NULL, NULL, 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 11:32:21', '2026-08-28 11:32:21'),
(39, 'JKR-00035', 1, '7307050505760002', 'WAHYUDDIN UMAR', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 11:32:57', '2026-08-28 11:32:57'),
(40, 'JKR-00036', 1, '7307030710950003', 'ZAKARIAH', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 11:33:33', '2026-08-28 11:33:33'),
(41, 'JKR-00037', 1, '7307040401880001', 'SURIADI', NULL, NULL, 'L', 'Jl. -', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, '2026-08-28 11:34:16', '2026-08-28 11:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `karcis_allocations`
--

CREATE TABLE `karcis_allocations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED NOT NULL,
  `jukir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `penerima` varchar(150) NOT NULL,
  `jenis_karcis` varchar(100) NOT NULL,
  `seri_prefix` varchar(30) NOT NULL DEFAULT '',
  `nomor_awal` bigint(20) UNSIGNED NOT NULL,
  `nomor_akhir` bigint(20) UNSIGNED NOT NULL,
  `lebar_nomor` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `nilai_per_karcis` bigint(20) UNSIGNED NOT NULL,
  `tanggal_penyerahan` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `karcis_usages`
--

CREATE TABLE `karcis_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karcis_allocation_id` bigint(20) UNSIGNED NOT NULL,
  `setoran_id` bigint(20) UNSIGNED NOT NULL,
  `nomor_seri` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kecamatans`
--

CREATE TABLE `kecamatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kecamatans`
--

INSERT INTO `kecamatans` (`id`, `kode`, `nama`, `status`, `created_at`, `updated_at`) VALUES
(1, '730706', 'Sinjai Tengah', 1, '2026-08-19 02:20:44', '2026-08-19 02:24:00'),
(2, '730701', 'Sinjai Barat', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(3, '730702', 'Sinjai Borong', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(4, '730703', 'Sinjai Selatan', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(5, '730704', 'Tellulimpoe', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(6, '730705', 'Sinjai Timur', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(7, '730707', 'Sinjai Utara', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(8, '730708', 'Bulupoddo', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00'),
(9, '730709', 'Pulau Sembilan', 1, '2026-08-19 02:24:00', '2026-08-19 02:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `kelurahans`
--

CREATE TABLE `kelurahans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kecamatan_id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelurahans`
--

INSERT INTO `kelurahans` (`id`, `kecamatan_id`, `kode`, `nama`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, '7307010001', 'Gunung Perak', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(2, 2, '7307010002', 'Arabika', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(3, 2, '7307010003', 'Bonto Salama', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(4, 2, '7307010004', 'Turungan Baji', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(5, 2, '7307010005', 'Terasa', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(6, 2, '7307010006', 'Bonto Lempangan', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(7, 2, '7307010007', 'Barania', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(8, 2, '7307010008', 'Tassililu', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(9, 2, '7307010009', 'Balakia', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(10, 3, '7307020001', 'Batu Belerang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(11, 3, '7307020002', 'Biji Nangka', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(12, 3, '7307020003', 'Barambang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(13, 3, '7307020004', 'Bonto Sinala', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(14, 3, '7307020005', 'Kassi Buleng', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(15, 3, '7307020006', 'Bonto Katute', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(16, 3, '7307020007', 'Bonto Tengnga', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(17, 3, '7307020008', 'Pasir Putih', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(18, 4, '7307030001', 'Puncak', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(19, 4, '7307030002', 'Songing', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(20, 4, '7307030003', 'Aska', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(21, 4, '7307030004', 'Talle', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(22, 4, '7307030005', 'Palae', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(23, 4, '7307030006', 'Bulukamase', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(24, 4, '7307030007', 'Palangka', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(25, 4, '7307030008', 'Polewali', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(26, 4, '7307030009', 'Alenangka', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(27, 4, '7307030010', 'Gareccing', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(28, 4, '7307030011', 'Sangiaseri', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(29, 5, '7307040001', 'Saotengnga', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(30, 5, '7307040002', 'Kalobba', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(31, 5, '7307040003', 'Tellulimpoe', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(32, 5, '7307040004', 'Lembang Lohe', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(33, 5, '7307040005', 'Suka Maju', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(34, 5, '7307040006', 'Era Baru', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(35, 5, '7307040007', 'Pattongko', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(36, 5, '7307040008', 'Massaile', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(37, 5, '7307040009', 'Samaturue', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(38, 5, '7307040010', 'Bua', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(39, 5, '7307040011', 'Mannanti', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(40, 6, '7307050001', 'Sanjai', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(41, 6, '7307050002', 'Pattalassang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(42, 6, '7307050003', 'Panaikang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(43, 6, '7307050004', 'Saukang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(44, 6, '7307050005', 'Kampala', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(45, 6, '7307050006', 'Lasiai', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(46, 6, '7307050007', 'Biroro', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(47, 6, '7307050008', 'Kaloling', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(48, 6, '7307050009', 'Pasimarannu', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(49, 6, '7307050010', 'Tongke-Tongke', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(50, 6, '7307050011', 'Salohe', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(51, 6, '7307050012', 'Bongki Lengkese', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(52, 6, '7307050013', 'Samataring', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(53, 1, '7307060001', 'Kompang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(54, 1, '7307060002', 'Baru', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(55, 1, '7307060003', 'Saotengnga', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(56, 1, '7307060004', 'Saohiring', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(57, 1, '7307060005', 'Kanrung', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(58, 1, '7307060006', 'Saotanre', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(59, 1, '7307060007', 'Bonto', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(60, 1, '7307060008', 'Mattunreng Tellue', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(61, 1, '7307060009', 'Gantarang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(62, 1, '7307060010', 'Pattongko', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(63, 1, '7307060011', 'Samaenre', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(64, 7, '7307070001', 'Balangnipa', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(65, 7, '7307070002', 'Bongki', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(66, 7, '7307070003', 'Lappa', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(67, 7, '7307070004', 'Biringere', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(68, 7, '7307070005', 'Alehanuae', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(69, 7, '7307070006', 'Lamatti Rilau', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(70, 8, '7307080001', 'Lamatti Riattang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(71, 8, '7307080002', 'Lamatti Riaja', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(72, 8, '7307080003', 'Lamatti Riawang', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(73, 8, '7307080004', 'Bulu Tellue', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(74, 8, '7307080005', 'Duampanuae', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(75, 8, '7307080006', 'Tompo Bulu', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(76, 8, '7307080007', 'Lappa Cinrana', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(77, 9, '7307090001', 'Pulau Harapan', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(78, 9, '7307090002', 'Pulau Buhung Pitue', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(79, 9, '7307090003', 'Pulau Padaelo', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08'),
(80, 9, '7307090004', 'Pulau Persatuan', 1, '2026-08-19 02:31:08', '2026-08-19 02:31:08');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_19_100030_create_kecamatans_table', 2),
(5, '2026_08_19_100040_create_kelurahans_table', 2),
(6, '2026_08_19_100051_create_jenis_jukirs_table', 2),
(7, '2026_08_19_100201_create_jukirs_table', 2),
(8, '2026_08_19_100319_create_jenis_parkirs_table', 2),
(9, '2026_08_19_100410_create_titik_parkirs_table', 2),
(10, '2026_08_19_100450_create_penempatan_jukirs_table', 3),
(11, '2026_08_19_100533_create_tarifs_table', 3),
(12, '2026_08_20_010314_create_setorans_table', 4),
(13, '2026_08_20_025922_add_role_and_status_to_users_table', 5),
(14, '2026_08_20_030837_add_role_and_status_to_users_table', 6),
(15, '2026_08_20_031818_change_status_and_role_defaults_on_users_table', 7),
(16, '2026_08_20_050000_create_galleries_table', 8),
(17, '2026_08_20_060000_create_pengaduans_table', 9),
(18, '2026_08_20_070000_create_sambutans_table', 10),
(19, '2026_08_20_080000_create_capaian_bulanans_table', 11),
(20, '2026_08_20_061000_add_nik_and_foto_to_pengaduans_table', 12),
(21, '2026_08_20_070000_seed_kategori_pemasukan_parkir', 13),
(22, '2026_08_20_080000_add_sumber_pemasukan_to_setorans', 14),
(23, '2026_08_20_081000_add_retribusi_tempat_kegiatan_usaha', 15),
(24, '2026_08_21_090000_rename_jenis_petugas', 16),
(25, '2026_08_21_100000_add_dokumen_pendukung_to_jukirs_table', 17),
(26, '2026_08_21_110000_add_sumber_pemasukan_to_titik_parkirs', 18),
(27, '2026_08_21_120000_make_jenis_parkir_optional_on_revenue_points', 19),
(28, '2026_08_21_120000_make_setoran_parkir_relations_nullable', 20),
(29, '2026_08_21_130000_create_target_pendapatans_table', 21),
(30, '2026_08_21_140000_create_objek_pendapatans_table', 22),
(31, '2026_08_21_150000_seed_target_pendapatan_2026', 23),
(32, '2026_08_21_160000_add_vehicle_counts_to_setorans', 24),
(33, '2026_08_21_170000_add_tax_fields_to_objek_pendapatans', 25),
(34, '2026_08_21_180000_add_business_asset_fields_to_objek_pendapatans', 26),
(35, '2026_08_21_190000_create_peringatan_capaians_table', 27),
(36, '2026_08_21_200000_create_audit_logs_table', 28),
(37, '2026_08_21_220000_create_tagihans_and_pembayarans_tables', 29),
(38, '2026_08_21_230000_create_unit_usahas_table', 30),
(39, '2026_08_21_231000_add_unit_usaha_to_tagihans', 30),
(40, '2026_08_21_240000_create_wajib_pajaks_table', 31),
(41, '2026_08_21_250000_create_aset_daerah_and_area_asets_tables', 32),
(42, '2026_08_21_260000_add_special_parking_capacity_manager_to_titik_parkirs', 33),
(43, '2026_08_21_270000_create_pemanfaatan_asets_table', 34),
(44, '2026_08_21_280000_link_tagihan_to_pemanfaatan_asets', 35),
(45, '2026_08_21_290000_create_okupansi_parkirs_table', 36),
(46, '2026_08_21_300000_create_unit_usaha_histories_table', 37),
(47, '2026_08_21_310000_add_vehicle_class_capacity_to_titik_parkirs', 38),
(48, '2026_08_21_311000_normalize_legacy_mobil_tariffs', 38),
(49, '2026_08_21_320000_add_vehicle_class_counts_to_setorans', 39),
(50, '2026_08_28_000000_add_tanggal_kegiatan_to_galleries_table', 40),
(51, '2026_08_28_010000_add_gallery_group_to_galleries_table', 41),
(52, '2026_08_29_000001_create_site_settings_table', 42),
(53, '2026_08_29_000002_add_background_color_to_sambutans_table', 43),
(54, '2026_08_29_000001_add_business_capacity_fields_to_titik_parkirs_table', 44),
(55, '2026_08_30_000001_correct_kios_1_revenue_source', 45),
(56, '2026_08_30_000001_add_second_sambutan_leaders_to_sambutans_table', 46),
(57, '2026_08_30_000002_add_role_target_and_time_to_penempatan_jukirs_table', 47),
(58, '2026_09_01_234028_add_jumlah_koordinator_to_titik_parkir', 48),
(59, '2026_09_02_000000_create_karcis_allocations_table', 49),
(60, '2026_11_02_000001_create_news_table', 50);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `ringkasan` varchar(500) DEFAULT NULL,
  `konten` longtext NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `objek_pendapatans`
--

CREATE TABLE `objek_pendapatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED NOT NULL,
  `wajib_pajak_id` bigint(20) UNSIGNED DEFAULT NULL,
  `kode` varchar(50) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tipe` varchar(30) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nama_pengelola` varchar(255) DEFAULT NULL,
  `nomor_identitas` varchar(255) DEFAULT NULL,
  `npwp` varchar(32) DEFAULT NULL,
  `nop` varchar(64) DEFAULT NULL,
  `masa_pajak_mulai` date DEFAULT NULL,
  `masa_pajak_sampai` date DEFAULT NULL,
  `tarif_pajak` decimal(5,2) DEFAULT NULL,
  `jenis_usaha` varchar(255) DEFAULT NULL,
  `jenis_aset` varchar(255) DEFAULT NULL,
  `nomor_aset` varchar(255) DEFAULT NULL,
  `luas_m2` decimal(12,2) DEFAULT NULL,
  `tarif_sewa` decimal(15,2) DEFAULT NULL,
  `nomor_kontrak` varchar(100) DEFAULT NULL,
  `kontrak_mulai` date DEFAULT NULL,
  `kontrak_selesai` date DEFAULT NULL,
  `potensi_harian` decimal(15,2) DEFAULT NULL,
  `potensi_bulanan` decimal(15,2) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `objek_pendapatans`
--

INSERT INTO `objek_pendapatans` (`id`, `sumber_pemasukan_id`, `wajib_pajak_id`, `kode`, `nama`, `tipe`, `alamat`, `nama_pengelola`, `nomor_identitas`, `npwp`, `nop`, `masa_pajak_mulai`, `masa_pajak_sampai`, `tarif_pajak`, `jenis_usaha`, `jenis_aset`, `nomor_aset`, `luas_m2`, `tarif_sewa`, `nomor_kontrak`, `kontrak_mulai`, `kontrak_selesai`, `potensi_harian`, `potensi_bulanan`, `status`, `metadata`, `created_at`, `updated_at`) VALUES
(3, 4, NULL, 'R-JU/PAD', 'KIOS 1', 'tempat_usaha', 'Jl. Bulu Pattuku', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200000.00, NULL, '2026-01-01', NULL, 0.00, 200000.00, 'aktif', NULL, '2026-08-29 03:58:45', '2026-08-29 03:59:06');

-- --------------------------------------------------------

--
-- Table structure for table `okupansi_parkirs`
--

CREATE TABLE `okupansi_parkirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titik_parkir_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_motor` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `jumlah_mobil` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pemanfaatan_asets`
--

CREATE TABLE `pemanfaatan_asets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_aset_id` bigint(20) UNSIGNED NOT NULL,
  `tagihan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `pihak_pemanfaat` varchar(255) NOT NULL,
  `jenis_kegiatan` varchar(255) NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tarif_sewa` decimal(15,2) DEFAULT NULL,
  `nilai_sewa` decimal(15,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'direncanakan',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tagihan_id` bigint(20) UNSIGNED NOT NULL,
  `dibuat_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal_bayar` date NOT NULL,
  `jumlah_bayar` decimal(15,2) NOT NULL,
  `metode` varchar(30) DEFAULT NULL,
  `referensi` varchar(100) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penempatan_jukirs`
--

CREATE TABLE `penempatan_jukirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jukir_id` bigint(20) UNSIGNED NOT NULL,
  `titik_parkir_id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'anggota',
  `target_per_hari` decimal(15,2) DEFAULT NULL,
  `waktu_kerja` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status` enum('aktif','selesai','dibatalkan') NOT NULL DEFAULT 'aktif',
  `surat_penugasan` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penempatan_jukirs`
--

INSERT INTO `penempatan_jukirs` (`id`, `jukir_id`, `titik_parkir_id`, `role`, `target_per_hari`, `waktu_kerja`, `tanggal_mulai`, `tanggal_selesai`, `status`, `surat_penugasan`, `keterangan`, `created_by`, `created_at`, `updated_at`) VALUES
(2, 36, 21, 'anggota', NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, NULL, 1, '2026-08-21 11:05:30', '2026-09-01 14:28:15'),
(4, 6, 21, 'koordinator', 90000.00, NULL, '2026-01-01', NULL, 'aktif', NULL, NULL, 1, '2026-08-30 15:29:01', '2026-09-01 14:27:10'),
(5, 18, 21, 'anggota', NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, NULL, 1, '2026-09-01 14:29:55', '2026-09-01 14:29:55'),
(6, 11, 28, 'koordinator', 300000.00, NULL, '2026-01-01', NULL, 'aktif', NULL, NULL, 1, '2026-09-01 14:31:32', '2026-09-01 14:32:05'),
(7, 23, 28, 'anggota', NULL, NULL, '2026-01-01', NULL, 'aktif', NULL, NULL, 1, '2026-09-01 14:35:09', '2026-09-01 14:35:09'),
(8, 30, 29, 'koordinator', 200000.00, NULL, '2026-01-01', NULL, 'aktif', NULL, NULL, 1, '2026-09-01 14:36:27', '2026-09-01 14:36:27');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduans`
--

CREATE TABLE `pengaduans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `telepon` varchar(30) NOT NULL,
  `titik_parkir` varchar(255) DEFAULT NULL,
  `lokasi_parkir` varchar(255) NOT NULL,
  `jenis` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'baru',
  `dibaca_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peringatan_capaians`
--

CREATE TABLE `peringatan_capaians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titik_parkir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `objek_pendapatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun` smallint(5) UNSIGNED NOT NULL,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `scope` varchar(30) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `target` decimal(15,2) NOT NULL DEFAULT 0.00,
  `realisasi` decimal(15,2) NOT NULL DEFAULT 0.00,
  `persentase` decimal(7,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'terbuka',
  `catatan` text DEFAULT NULL,
  `ditindaklanjuti_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `ditindaklanjuti_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sambutans`
--

CREATE TABLE `sambutans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_kepala_dinas` varchar(255) NOT NULL,
  `jabatan` varchar(255) NOT NULL DEFAULT 'Kepala Dinas Perhubungan Kabupaten Sinjai',
  `nama_sekda` varchar(255) DEFAULT NULL,
  `jabatan_sekda` varchar(255) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `foto_kadis` varchar(255) DEFAULT NULL,
  `foto_sekda` varchar(255) DEFAULT NULL,
  `background_color` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sambutans`
--

INSERT INTO `sambutans` (`id`, `nama_kepala_dinas`, `jabatan`, `nama_sekda`, `jabatan_sekda`, `deskripsi`, `foto`, `foto_kadis`, `foto_sekda`, `background_color`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'AKBAR, S.Sos.,M.Si.', 'Kepala Dinas Perhubungan Kab. Sinjai', 'Andi Jefrianto Asapa, S.Sos.,M.Si.', 'Sekretaris Daerah Kab. Sinjai', '\"Melalui SAPA JUKIR, kami berkomitmen untuk mewujudkan pengelolaan retribusi/pendapatan yang modern, tertib, transparan, dan memberikan manfaat nyata bagi masyarakat. \r\nMari bersama mendukung pelayanan perparkiran yang aman, nyaman dan berorientasi pada kepuasan masyarakat\"', 'sambutan/LXTvX9bopbJa3jJ2TZsH7IBzLrnqFMgdREgWi6Le.jpg', 'sambutan/TpKNtq954BLFEId78DdaN37Ma30T5f3qFnWWPQfg.png', 'sambutan/21QhIMoIWwvBNsNqUZEBtBdz0RP7ADCIj6ZLfETV.jpg', '#0000ff', 1, '2026-08-20 01:22:25', '2026-09-06 11:57:02');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7xEZCGjs78Sti4501mIoqsxnv6aPhR46EzHDJYtc', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:160.0) Gecko/20100101 Firefox/160.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZlVucjZJZ0JsUmtFOEV6SjdNVklSdTFLZFJ2RFE1ZHI4YU5USU1aNyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbiI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1794452994),
('dOOK7kzc9ONhj3GK5Lecfl9yocvML706d4rISBgN', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:160.0) Gecko/20100101 Firefox/160.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiclR0NmpScWE4RG9wYXA1elBKWDVrZTA2aEJwRmJ5Q2hRdFFIVExKQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794786277),
('ML26ji9VsbMOhIDNL5VVw8zYrouMXXJ45rTMG5Xo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:160.0) Gecko/20100101 Firefox/160.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV2F0Mkx4VjNPdTVvRXVwUzRrYXZJdUhlZmw2ZmhzM21sTTlLekVBYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1794540365);

-- --------------------------------------------------------

--
-- Table structure for table `setorans`
--

CREATE TABLE `setorans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `objek_pendapatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `jukir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titik_parkir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jumlah_motor` int(10) UNSIGNED DEFAULT NULL,
  `jumlah_mobil` int(10) UNSIGNED DEFAULT NULL,
  `jumlah_mobil_kecil` int(10) UNSIGNED DEFAULT NULL,
  `jumlah_mobil_besar` int(10) UNSIGNED DEFAULT NULL,
  `karcis_nomor` text DEFAULT NULL,
  `jumlah_karcis` int(10) UNSIGNED DEFAULT NULL,
  `pendapatan_bruto` decimal(15,2) NOT NULL DEFAULT 0.00,
  `jumlah_setoran` decimal(15,2) NOT NULL DEFAULT 0.00,
  `selisih` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('belum_verifikasi','terverifikasi','ditolak') NOT NULL DEFAULT 'belum_verifikasi',
  `keterangan` text DEFAULT NULL,
  `diverifikasi_at` timestamp NULL DEFAULT NULL,
  `diverifikasi_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_description` text DEFAULT NULL,
  `service_hours` varchar(255) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `location_url` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `whatsapp_url` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `hero_image`, `hero_title`, `hero_description`, `service_hours`, `location_name`, `location_url`, `whatsapp_number`, `whatsapp_url`, `instagram`, `email`, `created_at`, `updated_at`) VALUES
(1, 'site-settings/7POFNKFj6q5ni1YHvEKoOAqGefyaYMePjkyM3jW9.png', 'Selamat Datang di SAPA JUKIR', 'SAPA JUKIR (Sistem Administrasi Pelayanan dan Aduan Juru Parkir) adalah Sistem terintegrasi untuk mengelola dan memantau retribusi/pendapatan pada UPTD Terminal dan Perparkiran Dinas Perhubungan Kabupaten Sinjai secara transparan, akuntabel, dan profesional.', '08.00 – 16.00 Wita', 'Dishub Kab. Sinjai', 'https://maps.google.com/?q=Dinas+Perhubungan+Kabupaten+Sinjai', '089 990 843 43', 'https://wa.me/628999084343', '@uptdterminalsinjai @dishub_sinjai', 'uptdterminalsinjai@gmail.com', '2026-08-29 05:38:40', '2026-08-31 14:15:24');

-- --------------------------------------------------------

--
-- Table structure for table `sumber_pemasukans`
--

CREATE TABLE `sumber_pemasukans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(30) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sumber_pemasukans`
--

INSERT INTO `sumber_pemasukans` (`id`, `kode`, `nama`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 'R-TKP', 'Retribusi Tempat Khusus Parkir', 'Pemasukan retribusi dari tempat khusus parkir.', 1, '2026-08-20 07:45:21', '2026-08-20 07:45:21'),
(2, 'R-PJTU', 'Retribusi Parkir Tepi Jalan Umum', 'Pemasukan retribusi parkir di tepi jalan umum.', 1, '2026-08-20 07:45:21', '2026-11-02 12:53:51'),
(4, 'R-SPATKT', 'Retribusi Sewa Pelataran Area Terminal Untuk Kegiatan Tertentu', 'Sewa pelataran area terminal untuk kegiatan tertentu.', 1, '2026-08-20 07:45:21', '2026-08-30 01:57:25'),
(5, 'R-TKU', 'Retribusi Penyediaan Tempat Kegiatan Usaha', 'Penyediaan tempat kegiatan usaha berupa pasar, grosir, pertokoan, dan tempat kegiatan usaha lainnya.', 1, '2026-08-20 07:46:35', '2026-08-20 07:46:35');

-- --------------------------------------------------------

--
-- Table structure for table `tagihans`
--

CREATE TABLE `tagihans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED NOT NULL,
  `objek_pendapatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_usaha_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nomor_tagihan` varchar(80) NOT NULL,
  `pihak_tertagih` varchar(255) DEFAULT NULL,
  `uraian` varchar(255) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `nilai_tagihan` decimal(15,2) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'terbit',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `target_pendapatans`
--

CREATE TABLE `target_pendapatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED NOT NULL,
  `objek_pendapatan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `titik_parkir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tahun` smallint(5) UNSIGNED NOT NULL,
  `bulan` tinyint(3) UNSIGNED NOT NULL,
  `target` decimal(15,2) NOT NULL DEFAULT 0.00,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `target_pendapatans`
--

INSERT INTO `target_pendapatans` (`id`, `sumber_pemasukan_id`, `objek_pendapatan_id`, `titik_parkir_id`, `tahun`, `bulan`, `target`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, 2026, 1, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(2, 2, NULL, NULL, 2026, 2, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(3, 2, NULL, NULL, 2026, 3, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(4, 2, NULL, NULL, 2026, 4, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(5, 2, NULL, NULL, 2026, 5, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(6, 2, NULL, NULL, 2026, 6, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(7, 2, NULL, NULL, 2026, 7, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(8, 2, NULL, NULL, 2026, 8, 54166666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(9, 2, NULL, NULL, 2026, 9, 54166666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(10, 2, NULL, NULL, 2026, 10, 54166666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(11, 2, NULL, NULL, 2026, 11, 54166666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(12, 2, NULL, NULL, 2026, 12, 54166666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(13, 5, NULL, NULL, 2026, 1, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(14, 5, NULL, NULL, 2026, 2, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(15, 5, NULL, NULL, 2026, 3, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(16, 5, NULL, NULL, 2026, 4, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(17, 5, NULL, NULL, 2026, 5, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(18, 5, NULL, NULL, 2026, 6, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(19, 5, NULL, NULL, 2026, 7, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(20, 5, NULL, NULL, 2026, 8, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(21, 5, NULL, NULL, 2026, 9, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(22, 5, NULL, NULL, 2026, 10, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(23, 5, NULL, NULL, 2026, 11, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(24, 5, NULL, NULL, 2026, 12, 2600000.00, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(25, 1, NULL, NULL, 2026, 1, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(26, 1, NULL, NULL, 2026, 2, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(27, 1, NULL, NULL, 2026, 3, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(28, 1, NULL, NULL, 2026, 4, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(29, 1, NULL, NULL, 2026, 5, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(30, 1, NULL, NULL, 2026, 6, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(31, 1, NULL, NULL, 2026, 7, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(32, 1, NULL, NULL, 2026, 8, 39941666.67, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(33, 1, NULL, NULL, 2026, 9, 39941666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(34, 1, NULL, NULL, 2026, 10, 39941666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(35, 1, NULL, NULL, 2026, 11, 39941666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(36, 1, NULL, NULL, 2026, 12, 39941666.66, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(37, 4, NULL, NULL, 2026, 1, 833333.34, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(38, 4, NULL, NULL, 2026, 2, 833333.34, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(39, 4, NULL, NULL, 2026, 3, 833333.34, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(40, 4, NULL, NULL, 2026, 4, 833333.34, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(41, 4, NULL, NULL, 2026, 5, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(42, 4, NULL, NULL, 2026, 6, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(43, 4, NULL, NULL, 2026, 7, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(44, 4, NULL, NULL, 2026, 8, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(45, 4, NULL, NULL, 2026, 9, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(46, 4, NULL, NULL, 2026, 10, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(47, 4, NULL, NULL, 2026, 11, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35'),
(48, 4, NULL, NULL, 2026, 12, 833333.33, 'Target tahunan UPTD Terminal dan Perparkiran tahun 2026 dibagi rata per bulan.', '2026-08-20 18:51:35', '2026-08-20 18:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `tarifs`
--

CREATE TABLE `tarifs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jenis_parkir_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_kendaraan` varchar(50) NOT NULL,
  `nominal` decimal(15,2) NOT NULL,
  `berlaku_mulai` date NOT NULL,
  `berlaku_sampai` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tarifs`
--

INSERT INTO `tarifs` (`id`, `jenis_parkir_id`, `jenis_kendaraan`, `nominal`, `berlaku_mulai`, `berlaku_sampai`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 1, 'motor', 2000.00, '2026-01-01', NULL, 1, NULL, '2026-08-20 23:11:57', '2026-08-20 23:11:57'),
(4, 1, 'mobil_kecil', 3000.00, '2026-01-01', NULL, 1, NULL, '2026-08-20 23:12:22', '2026-08-20 23:12:22'),
(5, 1, 'mobil_besar', 5000.00, '2026-01-01', NULL, 1, NULL, '2026-08-20 23:12:46', '2026-08-20 23:12:46'),
(6, 2, 'motor', 2000.00, '2026-01-01', NULL, 1, NULL, '2026-08-24 15:21:04', '2026-08-24 15:21:04'),
(7, 2, 'mobil_kecil', 3000.00, '2026-01-01', NULL, 1, NULL, '2026-08-24 15:21:44', '2026-08-24 15:21:44'),
(8, 2, 'mobil_besar', 5000.00, '2026-01-01', NULL, 1, NULL, '2026-08-24 15:22:07', '2026-08-24 15:22:07'),
(9, 4, 'motor', 2000.00, '2026-01-01', NULL, 1, NULL, '2026-08-24 15:22:37', '2026-08-24 15:22:37'),
(10, 4, 'mobil_kecil', 3000.00, '2026-01-01', NULL, 1, NULL, '2026-08-24 15:22:55', '2026-08-24 15:22:55'),
(11, 4, 'mobil_besar', 5000.00, '2026-01-01', NULL, 1, NULL, '2026-08-24 15:23:12', '2026-08-24 15:23:12');

-- --------------------------------------------------------

--
-- Table structure for table `titik_parkirs`
--

CREATE TABLE `titik_parkirs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_titik` varchar(30) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `kecamatan_id` bigint(20) UNSIGNED NOT NULL,
  `kelurahan_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_parkir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sumber_pemasukan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `status` enum('aktif','nonaktif','sementara','bermasalah') NOT NULL DEFAULT 'aktif',
  `kapasitas_motor` int(10) UNSIGNED DEFAULT NULL,
  `kapasitas_mobil` int(10) UNSIGNED DEFAULT NULL,
  `kapasitas_mobil_kecil` int(10) UNSIGNED DEFAULT NULL,
  `kapasitas_mobil_besar` int(10) UNSIGNED DEFAULT NULL,
  `kapasitas_total` int(10) UNSIGNED DEFAULT NULL,
  `jumlah_unit` int(10) UNSIGNED DEFAULT NULL,
  `luas_m2` decimal(12,2) DEFAULT NULL,
  `nama_pengelola` varchar(255) DEFAULT NULL,
  `telepon_pengelola` varchar(30) DEFAULT NULL,
  `potensi_harian` decimal(15,2) DEFAULT NULL,
  `potensi_bulanan` decimal(15,2) DEFAULT NULL,
  `jumlah_koordinator` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'Jumlah koordinator/regu yang diperbolehkan di titik parkir ini (1 atau 2)',
  `foto` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `titik_parkirs`
--

INSERT INTO `titik_parkirs` (`id`, `kode_titik`, `nama`, `alamat`, `kecamatan_id`, `kelurahan_id`, `jenis_parkir_id`, `sumber_pemasukan_id`, `latitude`, `longitude`, `status`, `kapasitas_motor`, `kapasitas_mobil`, `kapasitas_mobil_kecil`, `kapasitas_mobil_besar`, `kapasitas_total`, `jumlah_unit`, `luas_m2`, `nama_pengelola`, `telepon_pengelola`, `potensi_harian`, `potensi_bulanan`, `jumlah_koordinator`, `foto`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 'TP-SU-002', 'Toko Kosmetik Sri', 'Jl. G. Bawakaraeng', 7, 64, 1, 2, -5.1206300, 120.2541200, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, 'titik-parkir/8N6Xj6uzBNhJ0sKstwaGoWgtYMO7wyzqlqpMebLB.jpg', NULL, '2026-08-21 10:53:21', '2026-08-28 12:01:27'),
(4, 'TP-SU-001', 'Taman Topekkong Demma', 'Jl. Bhayangkara', 7, 65, 1, 2, -5.1208500, 120.2517400, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-21 10:56:53', '2026-08-24 11:35:27'),
(5, 'TP-SU-003', 'Klinik Dokter Nanang', 'Jl. Persatuan Raya No. 56', 7, 64, 1, 2, -5.1200200, 120.2556400, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:33:17', '2026-08-24 11:33:17'),
(6, 'TP-SU-004', 'RM Legenda', 'Jl. Persatuan Raya', 7, 67, 1, 2, -5.1199000, 120.2558500, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:38:23', '2026-08-24 11:39:58'),
(7, 'TP-SU-005', 'Kuliner Hisana,Momoyo,Pelangi', 'Jl. Persatuan Raya', 7, 65, 1, 2, -5.1173900, 120.2568700, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:41:34', '2026-08-24 11:42:03'),
(8, 'TP-SU-006', 'RM PASUNDAN & ALFAMIDI', 'Jl. Sungai Tangka', 7, 64, 1, 2, -5.1152300, 120.2583400, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:43:42', '2026-08-24 11:44:59'),
(9, 'TP-SU-007', 'Dsimple & Karampuang', 'Jl. Baso Kalaka', 7, 64, 1, 2, -5.1264800, 120.2509800, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:46:34', '2026-08-24 11:47:34'),
(10, 'TP-SU-008', 'CAFE DR HAMKA 1', 'Jl. Dokter Hamka', 7, 67, 1, 2, -5.1255900, 120.2507100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:48:55', '2026-08-24 11:52:21'),
(11, 'TP-SU-009', 'DR HAMKA 2', 'Jl. Dokter Hamka', 7, 67, 1, 2, -5.1256700, 120.2507600, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:51:18', '2026-08-24 11:52:08'),
(12, 'TP-SU-010', 'TONDONG UJUNG', 'Jl. H.A. Abdul Latief', 7, 67, 1, 2, -5.1253600, 120.2501100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:53:42', '2026-08-24 12:12:13'),
(13, 'TP-SU-011', 'KAYTAMA', 'Jl. Jend. Sudirman', 7, 65, 1, 2, -5.1229000, 120.2510700, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:57:24', '2026-08-24 12:11:53'),
(14, 'TP-SU-012', 'Hana dan', 'Jl. H. A. Abdul Latif', 7, 67, 1, 2, -5.1213400, 120.2489500, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 11:59:31', '2026-08-24 12:00:04'),
(15, 'TP-SU-013', 'PRAKTEK DOKTER/KLINIK', 'Jl. A. Abdul Latief', 7, 67, 1, 2, -5.1250300, 120.2480700, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:01:15', '2026-08-24 12:02:23'),
(16, 'TP-EKS-014', 'ALUN-ALUN 1', 'Jl. A.Abdul Latief', 7, 67, 1, 2, -5.1247100, 120.2483700, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:04:30', '2026-08-24 12:11:35'),
(17, 'TP-EKS-015', 'ALUN-ALUN 2', 'Sinjai Utara', 7, 67, 1, 2, -5.1247900, 120.2486000, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:08:36', '2026-08-24 12:09:21'),
(18, 'TP-EKS-016', 'ALUN-ALUN 3', 'Jl. H.A. Abdul Latief', 7, 67, 1, 2, -5.1249500, 120.2490200, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:13:43', '2026-08-24 12:13:43'),
(19, 'TP-EKS-017', 'ALUN-ALUN 4', 'Sinjai Utara', 7, 67, 1, 2, -5.1251100, 120.2494200, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:15:26', '2026-08-24 12:15:26'),
(20, 'TP-EKS-018', 'ALUN-ALUN 5', 'Jl, H.A. Abdul Latief', 7, 67, 2, 1, -5.1250700, 120.2497700, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:23:22', '2026-08-24 12:46:44'),
(21, 'TP-EKS-019', 'ALUN-ALUN 6', 'Jl. H.A. Abdul Latief', 7, 67, 1, 2, -5.1251600, 120.2497900, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:25:08', '2026-08-24 12:25:08'),
(22, 'TP-EKS-020', 'PASAR ATAS 1', 'Jl. Bulu Bicara', 7, 65, 1, 2, -5.1201400, 120.2517900, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:29:06', '2026-08-24 12:30:05'),
(23, 'TP-EKS-021', 'PASAR ATAS 2', 'Jl. Bulu Bicara', 7, 65, 1, 2, -5.1200500, 120.2518100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:30:58', '2026-08-24 12:31:25'),
(24, 'TP-EKS-022', 'POS DEMMA', 'Demma', 7, 65, 1, 2, -5.1212900, 120.2532900, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:32:27', '2026-08-24 12:32:27'),
(25, 'TP-EKS-023', 'POS BULU SALAKA', 'Jl. Bulu Salaka', 7, 65, 1, 2, -5.1188400, 120.2539100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:34:04', '2026-08-24 12:35:27'),
(26, 'TP-EKS-024', 'PASAR RUKO PRAMUKA', 'Jl. Pramuka', 7, 65, 2, 1, -5.1180700, 120.2560100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:36:43', '2026-08-24 12:45:32'),
(27, 'TP-EKS-025', 'PASAR RUKO 2', 'Jl. Persatuan Raya', 7, 65, 2, 1, -5.1194000, 120.2554400, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:41:54', '2026-08-24 12:44:16'),
(28, 'TP-EKS-026', 'POS BONTO', 'Jl. Petta Ponggawae', 7, 65, 1, 2, -5.0954400, 120.2463200, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:49:13', '2026-08-24 12:49:13'),
(29, 'TP-EKS-027', 'POS TPI LAPPA', 'Jl. Kalampeto', 7, 66, 1, 2, -5.1077300, 120.2707500, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 200000.00, 6000000.00, 1, NULL, NULL, '2026-08-24 12:51:33', '2026-09-01 14:45:35'),
(30, 'TP-EKS-028', 'PASAR BARINGENG', 'Jl. Poros Sinjai-Kajang', 6, 42, 1, 2, -5.1692800, 120.2723900, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 12:56:46', '2026-08-24 12:58:00'),
(31, 'TP-EKS-029', 'PASAR LAGORA', 'Jl. Poros Manipi', 1, 63, 2, 1, -5.1655720, 120.1687040, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:00:08', '2026-08-24 13:06:12'),
(32, 'TP-EKS-030', 'PASAR MANIMPAHOI', 'Jl. Sultan Hasanuddin', 1, 55, 2, 1, -5.1908850, 120.1122920, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:10:11', '2026-08-24 13:13:23'),
(33, 'TP-EKS-031', 'PASAR TASSILILU', 'Komp. Pasar Manipi', 2, 8, 2, 1, -5.2048300, 120.0002700, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:17:01', '2026-08-24 13:17:01'),
(34, 'TP-EKS-032', 'PASAR BIKERU', 'Jl. Rambutan', 4, 28, 1, 2, -5.2477400, 120.1581100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:27:28', '2026-08-24 13:27:28'),
(35, 'TP-EKS-033', 'PASAR MANNANTI', 'Mannanti', 5, 39, 1, 2, -5.2658600, 120.2350100, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:29:55', '2026-08-24 13:29:55'),
(36, 'TP-EKS-034', 'PASAR MATAJANG', 'Lamatti Riattang', 8, 70, 2, 1, -5.0967100, 120.1525900, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, 'AHMAD', NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:32:59', '2026-08-24 13:32:59'),
(37, 'TP-EKS-035', 'PASAR INRULAMUNG PASIR PUTIH', 'Jl. Melati', 3, 17, 1, 2, -5.3249100, 120.0655800, 'aktif', 0, NULL, 0, 0, 0, NULL, NULL, NULL, NULL, 0.00, 0.00, 1, NULL, NULL, '2026-08-24 13:35:47', '2026-08-24 16:47:08'),
(38, 'R.Kios-01', 'KIOS 1', 'Jl. Bulu Patukku', 7, 65, NULL, 5, -5.1135930, 120.2524340, 'aktif', NULL, NULL, NULL, NULL, NULL, 1, 0.00, NULL, NULL, NULL, NULL, 1, NULL, NULL, '2026-08-24 16:36:30', '2026-08-30 02:46:18'),
(39, 'SW.PLR', 'Penjualan Usaha Cakar', 'Jl. Bulu Pattuku (Terminal Tellu Limpoe)', 7, 65, NULL, 4, -5.1130820, 120.2512040, 'aktif', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Syarif', NULL, NULL, NULL, 1, NULL, NULL, '2026-08-30 08:51:49', '2026-08-30 09:29:22');

-- --------------------------------------------------------

--
-- Table structure for table `unit_usahas`
--

CREATE TABLE `unit_usahas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `objek_pendapatan_id` bigint(20) UNSIGNED NOT NULL,
  `kode_unit` varchar(50) NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `jenis_unit` varchar(255) DEFAULT NULL,
  `penyewa_nama` varchar(255) DEFAULT NULL,
  `penyewa_identitas` varchar(255) DEFAULT NULL,
  `luas_m2` decimal(12,2) DEFAULT NULL,
  `tarif_sewa` decimal(15,2) DEFAULT NULL,
  `kontrak_mulai` date DEFAULT NULL,
  `kontrak_selesai` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'kosong',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_usaha_histories`
--

CREATE TABLE `unit_usaha_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_usaha_id` bigint(20) UNSIGNED NOT NULL,
  `diubah_oleh` bigint(20) UNSIGNED DEFAULT NULL,
  `aksi` varchar(30) NOT NULL,
  `nilai_lama` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`nilai_lama`)),
  `nilai_baru` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`nilai_baru`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `role` varchar(30) NOT NULL DEFAULT 'operator',
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@sijukir.sinjai.go.id', NULL, '$2y$12$xHTVfHQ3L/vxV6As3s5u9OACjSjww0AcbfSM3rzfWYdf6hr9jmFCa', 'admin', 'aktif', '7SyZyt1BAjCg8zK5iGkY8B0TAh07gwgwdQja2785pfrfkaCLeQbz5qEbthgL', '2026-08-19 19:19:44', '2026-08-19 19:19:44'),
(2, 'Akbar, S.Sos.,M.Si', 'akbar@gmail.com', NULL, '$2y$12$VIILxbPlN1B36C7tYeJxEOeT0ukI9KqmVR5oOL0CH5Aqbgg9MIChi', 'pimpinan', 'aktif', NULL, '2026-08-24 16:57:30', '2026-08-24 16:57:30');

-- --------------------------------------------------------

--
-- Table structure for table `wajib_pajaks`
--

CREATE TABLE `wajib_pajaks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `npwp` varchar(32) DEFAULT NULL,
  `nik` varchar(32) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'aktif',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wajib_pajaks`
--

INSERT INTO `wajib_pajaks` (`id`, `nama`, `npwp`, `nik`, `alamat`, `nomor_telepon`, `email`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 'PT Sinjai Parkir Test', '123456789012345', 'WP-TEST-001', 'Jl. Persatuan No. 10', '081234567804', 'pajak-test@example.com', 'aktif', NULL, '2026-08-21 10:58:28', '2026-08-21 10:58:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_asets`
--
ALTER TABLE `area_asets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `area_asets_aset_daerah_id_kode_area_unique` (`aset_daerah_id`,`kode_area`),
  ADD KEY `area_asets_aset_daerah_id_status_index` (`aset_daerah_id`,`status`);

--
-- Indexes for table `aset_daerahs`
--
ALTER TABLE `aset_daerahs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `aset_daerahs_kode_aset_unique` (`kode_aset`),
  ADD UNIQUE KEY `aset_daerahs_nomor_register_unique` (`nomor_register`);

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_auditable_type_auditable_id_index` (`auditable_type`,`auditable_id`),
  ADD KEY `audit_logs_user_id_created_at_index` (`user_id`,`created_at`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `capaian_bulanans`
--
ALTER TABLE `capaian_bulanans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `capaian_bulanans_tahun_bulan_unique` (`tahun`,`bulan`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_gallery_group_index` (`gallery_group`);

--
-- Indexes for table `jenis_jukirs`
--
ALTER TABLE `jenis_jukirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jenis_jukirs_kode_unique` (`kode`);

--
-- Indexes for table `jenis_parkirs`
--
ALTER TABLE `jenis_parkirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jenis_parkirs_kode_unique` (`kode`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jukirs`
--
ALTER TABLE `jukirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jukirs_kode_jukir_unique` (`kode_jukir`),
  ADD UNIQUE KEY `jukirs_nik_unique` (`nik`),
  ADD KEY `jukirs_jenis_jukir_id_foreign` (`jenis_jukir_id`),
  ADD KEY `jukirs_kecamatan_id_foreign` (`kecamatan_id`),
  ADD KEY `jukirs_kelurahan_id_foreign` (`kelurahan_id`),
  ADD KEY `jukirs_nama_index` (`nama`),
  ADD KEY `jukirs_status_index` (`status`);

--
-- Indexes for table `karcis_allocations`
--
ALTER TABLE `karcis_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `karcis_allocations_jukir_id_foreign` (`jukir_id`),
  ADD KEY `karcis_allocation_series_idx` (`sumber_pemasukan_id`,`seri_prefix`,`nomor_awal`,`nomor_akhir`);

--
-- Indexes for table `karcis_usages`
--
ALTER TABLE `karcis_usages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karcis_usage_unique_series` (`karcis_allocation_id`,`nomor_seri`),
  ADD KEY `karcis_usages_setoran_id_index` (`setoran_id`);

--
-- Indexes for table `kecamatans`
--
ALTER TABLE `kecamatans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kecamatans_kode_unique` (`kode`),
  ADD KEY `kecamatans_nama_index` (`nama`);

--
-- Indexes for table `kelurahans`
--
ALTER TABLE `kelurahans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelurahans_kode_unique` (`kode`),
  ADD KEY `kelurahans_nama_index` (`nama`),
  ADD KEY `kelurahans_kecamatan_id_index` (`kecamatan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`),
  ADD KEY `news_is_published_published_at_index` (`is_published`,`published_at`);

--
-- Indexes for table `objek_pendapatans`
--
ALTER TABLE `objek_pendapatans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `objek_pendapatan_source_code_uq` (`sumber_pemasukan_id`,`kode`),
  ADD KEY `objek_pendapatan_source_type_idx` (`sumber_pemasukan_id`,`tipe`),
  ADD KEY `objek_pendapatans_status_index` (`status`),
  ADD KEY `objek_pendapatans_wajib_pajak_id_foreign` (`wajib_pajak_id`);

--
-- Indexes for table `okupansi_parkirs`
--
ALTER TABLE `okupansi_parkirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `okupansi_parkirs_titik_parkir_id_tanggal_unique` (`titik_parkir_id`,`tanggal`),
  ADD KEY `okupansi_parkirs_tanggal_index` (`tanggal`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pemanfaatan_asets`
--
ALTER TABLE `pemanfaatan_asets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemanfaatan_asets_area_aset_id_status_index` (`area_aset_id`,`status`),
  ADD KEY `pemanfaatan_asets_tanggal_mulai_tanggal_selesai_index` (`tanggal_mulai`,`tanggal_selesai`),
  ADD KEY `pemanfaatan_asets_tagihan_id_foreign` (`tagihan_id`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_dibuat_oleh_foreign` (`dibuat_oleh`),
  ADD KEY `pembayarans_tagihan_id_tanggal_bayar_index` (`tagihan_id`,`tanggal_bayar`);

--
-- Indexes for table `penempatan_jukirs`
--
ALTER TABLE `penempatan_jukirs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `penempatan_jukirs_jukir_id_foreign` (`jukir_id`),
  ADD KEY `penempatan_jukirs_titik_parkir_id_foreign` (`titik_parkir_id`),
  ADD KEY `penempatan_jukirs_created_by_foreign` (`created_by`);

--
-- Indexes for table `pengaduans`
--
ALTER TABLE `pengaduans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peringatan_capaians`
--
ALTER TABLE `peringatan_capaians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `peringatan_capaian_scope_period_uq` (`scope`,`sumber_pemasukan_id`,`titik_parkir_id`,`objek_pendapatan_id`,`tahun`,`bulan`),
  ADD KEY `peringatan_capaians_sumber_pemasukan_id_foreign` (`sumber_pemasukan_id`),
  ADD KEY `peringatan_capaians_titik_parkir_id_foreign` (`titik_parkir_id`),
  ADD KEY `peringatan_capaians_objek_pendapatan_id_foreign` (`objek_pendapatan_id`),
  ADD KEY `peringatan_capaians_ditindaklanjuti_oleh_foreign` (`ditindaklanjuti_oleh`),
  ADD KEY `peringatan_capaians_status_tahun_bulan_index` (`status`,`tahun`,`bulan`);

--
-- Indexes for table `sambutans`
--
ALTER TABLE `sambutans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `setorans`
--
ALTER TABLE `setorans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `setorans_diverifikasi_oleh_foreign` (`diverifikasi_oleh`),
  ADD KEY `setorans_jukir_id_tanggal_index` (`jukir_id`,`tanggal`),
  ADD KEY `setorans_titik_parkir_id_tanggal_index` (`titik_parkir_id`,`tanggal`),
  ADD KEY `setorans_status_index` (`status`),
  ADD KEY `setorans_sumber_pemasukan_id_foreign` (`sumber_pemasukan_id`),
  ADD KEY `setorans_objek_pendapatan_id_foreign` (`objek_pendapatan_id`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sumber_pemasukans`
--
ALTER TABLE `sumber_pemasukans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sumber_pemasukans_kode_unique` (`kode`);

--
-- Indexes for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tagihans_nomor_tagihan_unique` (`nomor_tagihan`),
  ADD KEY `tagihans_objek_pendapatan_id_foreign` (`objek_pendapatan_id`),
  ADD KEY `tagihans_sumber_pemasukan_id_status_tanggal_jatuh_tempo_index` (`sumber_pemasukan_id`,`status`,`tanggal_jatuh_tempo`),
  ADD KEY `tagihans_unit_usaha_id_foreign` (`unit_usaha_id`);

--
-- Indexes for table `target_pendapatans`
--
ALTER TABLE `target_pendapatans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_pendapatans_titik_parkir_id_foreign` (`titik_parkir_id`),
  ADD KEY `target_pendapatan_scope_idx` (`sumber_pemasukan_id`,`titik_parkir_id`,`tahun`,`bulan`),
  ADD KEY `target_pendapatans_objek_pendapatan_id_foreign` (`objek_pendapatan_id`);

--
-- Indexes for table `tarifs`
--
ALTER TABLE `tarifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tarifs_jenis_parkir_id_jenis_kendaraan_index` (`jenis_parkir_id`,`jenis_kendaraan`),
  ADD KEY `tarifs_berlaku_mulai_berlaku_sampai_index` (`berlaku_mulai`,`berlaku_sampai`);

--
-- Indexes for table `titik_parkirs`
--
ALTER TABLE `titik_parkirs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `titik_parkirs_kode_titik_unique` (`kode_titik`),
  ADD KEY `titik_parkirs_kecamatan_id_foreign` (`kecamatan_id`),
  ADD KEY `titik_parkirs_kelurahan_id_foreign` (`kelurahan_id`),
  ADD KEY `titik_parkirs_jenis_parkir_id_foreign` (`jenis_parkir_id`),
  ADD KEY `titik_parkirs_nama_index` (`nama`),
  ADD KEY `titik_parkirs_status_index` (`status`),
  ADD KEY `titik_parkirs_latitude_longitude_index` (`latitude`,`longitude`),
  ADD KEY `titik_parkirs_sumber_pemasukan_id_foreign` (`sumber_pemasukan_id`);

--
-- Indexes for table `unit_usahas`
--
ALTER TABLE `unit_usahas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unit_usahas_objek_pendapatan_id_kode_unit_unique` (`objek_pendapatan_id`,`kode_unit`),
  ADD KEY `unit_usahas_objek_pendapatan_id_status_index` (`objek_pendapatan_id`,`status`);

--
-- Indexes for table `unit_usaha_histories`
--
ALTER TABLE `unit_usaha_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_usaha_histories_diubah_oleh_foreign` (`diubah_oleh`),
  ADD KEY `unit_usaha_histories_unit_usaha_id_created_at_index` (`unit_usaha_id`,`created_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wajib_pajaks`
--
ALTER TABLE `wajib_pajaks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wajib_pajaks_npwp_unique` (`npwp`),
  ADD UNIQUE KEY `wajib_pajaks_nik_unique` (`nik`),
  ADD KEY `wajib_pajaks_status_index` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_asets`
--
ALTER TABLE `area_asets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `aset_daerahs`
--
ALTER TABLE `aset_daerahs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=237;

--
-- AUTO_INCREMENT for table `capaian_bulanans`
--
ALTER TABLE `capaian_bulanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jenis_jukirs`
--
ALTER TABLE `jenis_jukirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jenis_parkirs`
--
ALTER TABLE `jenis_parkirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jukirs`
--
ALTER TABLE `jukirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `karcis_allocations`
--
ALTER TABLE `karcis_allocations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `karcis_usages`
--
ALTER TABLE `karcis_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kecamatans`
--
ALTER TABLE `kecamatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `kelurahans`
--
ALTER TABLE `kelurahans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `objek_pendapatans`
--
ALTER TABLE `objek_pendapatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `okupansi_parkirs`
--
ALTER TABLE `okupansi_parkirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pemanfaatan_asets`
--
ALTER TABLE `pemanfaatan_asets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penempatan_jukirs`
--
ALTER TABLE `penempatan_jukirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengaduans`
--
ALTER TABLE `pengaduans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `peringatan_capaians`
--
ALTER TABLE `peringatan_capaians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sambutans`
--
ALTER TABLE `sambutans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `setorans`
--
ALTER TABLE `setorans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sumber_pemasukans`
--
ALTER TABLE `sumber_pemasukans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tagihans`
--
ALTER TABLE `tagihans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `target_pendapatans`
--
ALTER TABLE `target_pendapatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tarifs`
--
ALTER TABLE `tarifs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `titik_parkirs`
--
ALTER TABLE `titik_parkirs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `unit_usahas`
--
ALTER TABLE `unit_usahas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_usaha_histories`
--
ALTER TABLE `unit_usaha_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wajib_pajaks`
--
ALTER TABLE `wajib_pajaks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `area_asets`
--
ALTER TABLE `area_asets`
  ADD CONSTRAINT `area_asets_aset_daerah_id_foreign` FOREIGN KEY (`aset_daerah_id`) REFERENCES `aset_daerahs` (`id`);

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `jukirs`
--
ALTER TABLE `jukirs`
  ADD CONSTRAINT `jukirs_jenis_jukir_id_foreign` FOREIGN KEY (`jenis_jukir_id`) REFERENCES `jenis_jukirs` (`id`),
  ADD CONSTRAINT `jukirs_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `jukirs_kelurahan_id_foreign` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahans` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `karcis_allocations`
--
ALTER TABLE `karcis_allocations`
  ADD CONSTRAINT `karcis_allocations_jukir_id_foreign` FOREIGN KEY (`jukir_id`) REFERENCES `jukirs` (`id`),
  ADD CONSTRAINT `karcis_allocations_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`);

--
-- Constraints for table `karcis_usages`
--
ALTER TABLE `karcis_usages`
  ADD CONSTRAINT `karcis_usages_karcis_allocation_id_foreign` FOREIGN KEY (`karcis_allocation_id`) REFERENCES `karcis_allocations` (`id`),
  ADD CONSTRAINT `karcis_usages_setoran_id_foreign` FOREIGN KEY (`setoran_id`) REFERENCES `setorans` (`id`);

--
-- Constraints for table `kelurahans`
--
ALTER TABLE `kelurahans`
  ADD CONSTRAINT `kelurahans_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`);

--
-- Constraints for table `objek_pendapatans`
--
ALTER TABLE `objek_pendapatans`
  ADD CONSTRAINT `objek_pendapatans_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`),
  ADD CONSTRAINT `objek_pendapatans_wajib_pajak_id_foreign` FOREIGN KEY (`wajib_pajak_id`) REFERENCES `wajib_pajaks` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `okupansi_parkirs`
--
ALTER TABLE `okupansi_parkirs`
  ADD CONSTRAINT `okupansi_parkirs_titik_parkir_id_foreign` FOREIGN KEY (`titik_parkir_id`) REFERENCES `titik_parkirs` (`id`);

--
-- Constraints for table `pemanfaatan_asets`
--
ALTER TABLE `pemanfaatan_asets`
  ADD CONSTRAINT `pemanfaatan_asets_area_aset_id_foreign` FOREIGN KEY (`area_aset_id`) REFERENCES `area_asets` (`id`),
  ADD CONSTRAINT `pemanfaatan_asets_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihans` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `pembayarans_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihans` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `penempatan_jukirs`
--
ALTER TABLE `penempatan_jukirs`
  ADD CONSTRAINT `penempatan_jukirs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `penempatan_jukirs_jukir_id_foreign` FOREIGN KEY (`jukir_id`) REFERENCES `jukirs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `penempatan_jukirs_titik_parkir_id_foreign` FOREIGN KEY (`titik_parkir_id`) REFERENCES `titik_parkirs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `peringatan_capaians`
--
ALTER TABLE `peringatan_capaians`
  ADD CONSTRAINT `peringatan_capaians_ditindaklanjuti_oleh_foreign` FOREIGN KEY (`ditindaklanjuti_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peringatan_capaians_objek_pendapatan_id_foreign` FOREIGN KEY (`objek_pendapatan_id`) REFERENCES `objek_pendapatans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peringatan_capaians_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `peringatan_capaians_titik_parkir_id_foreign` FOREIGN KEY (`titik_parkir_id`) REFERENCES `titik_parkirs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `setorans`
--
ALTER TABLE `setorans`
  ADD CONSTRAINT `setorans_diverifikasi_oleh_foreign` FOREIGN KEY (`diverifikasi_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `setorans_jukir_id_foreign` FOREIGN KEY (`jukir_id`) REFERENCES `jukirs` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `setorans_objek_pendapatan_id_foreign` FOREIGN KEY (`objek_pendapatan_id`) REFERENCES `objek_pendapatans` (`id`),
  ADD CONSTRAINT `setorans_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`),
  ADD CONSTRAINT `setorans_titik_parkir_id_foreign` FOREIGN KEY (`titik_parkir_id`) REFERENCES `titik_parkirs` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tagihans`
--
ALTER TABLE `tagihans`
  ADD CONSTRAINT `tagihans_objek_pendapatan_id_foreign` FOREIGN KEY (`objek_pendapatan_id`) REFERENCES `objek_pendapatans` (`id`),
  ADD CONSTRAINT `tagihans_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`),
  ADD CONSTRAINT `tagihans_unit_usaha_id_foreign` FOREIGN KEY (`unit_usaha_id`) REFERENCES `unit_usahas` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `target_pendapatans`
--
ALTER TABLE `target_pendapatans`
  ADD CONSTRAINT `target_pendapatans_objek_pendapatan_id_foreign` FOREIGN KEY (`objek_pendapatan_id`) REFERENCES `objek_pendapatans` (`id`),
  ADD CONSTRAINT `target_pendapatans_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`),
  ADD CONSTRAINT `target_pendapatans_titik_parkir_id_foreign` FOREIGN KEY (`titik_parkir_id`) REFERENCES `titik_parkirs` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tarifs`
--
ALTER TABLE `tarifs`
  ADD CONSTRAINT `tarifs_jenis_parkir_id_foreign` FOREIGN KEY (`jenis_parkir_id`) REFERENCES `jenis_parkirs` (`id`);

--
-- Constraints for table `titik_parkirs`
--
ALTER TABLE `titik_parkirs`
  ADD CONSTRAINT `titik_parkirs_jenis_parkir_id_foreign` FOREIGN KEY (`jenis_parkir_id`) REFERENCES `jenis_parkirs` (`id`),
  ADD CONSTRAINT `titik_parkirs_kecamatan_id_foreign` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatans` (`id`),
  ADD CONSTRAINT `titik_parkirs_kelurahan_id_foreign` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahans` (`id`),
  ADD CONSTRAINT `titik_parkirs_sumber_pemasukan_id_foreign` FOREIGN KEY (`sumber_pemasukan_id`) REFERENCES `sumber_pemasukans` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `unit_usahas`
--
ALTER TABLE `unit_usahas`
  ADD CONSTRAINT `unit_usahas_objek_pendapatan_id_foreign` FOREIGN KEY (`objek_pendapatan_id`) REFERENCES `objek_pendapatans` (`id`);

--
-- Constraints for table `unit_usaha_histories`
--
ALTER TABLE `unit_usaha_histories`
  ADD CONSTRAINT `unit_usaha_histories_diubah_oleh_foreign` FOREIGN KEY (`diubah_oleh`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `unit_usaha_histories_unit_usaha_id_foreign` FOREIGN KEY (`unit_usaha_id`) REFERENCES `unit_usahas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
