-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: wahyu_konveksi_mysql:3306
-- Generation Time: Oct 16, 2026 at 03:07 PM
-- Server version: 8.0.45
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wahyu_konveksi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_us`
--

CREATE TABLE `about_us` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `about_us`
--

INSERT INTO `about_us` (`id`, `title`, `description`, `image`, `banner_image`, `banner_title`, `created_at`, `updated_at`) VALUES
(16, 'JASA KONVEKSI TERBAIK DI JOGJA', 'Kamu cari jasa vendor konveksi tempat bikin seragam jaket, kemeja pdl/pdh/korsa, jas almamater, wearpack, atau rompi dengan HARGA EKONOMIS? Kamu berada di tempat yg tepat! WHS Konveksindo adalah vendor konveksi semi garment di Jogja dengan pelayanan terbaik mengedepankan kualitas, profesionalitas, dan Intergritas!', 'about/zHygqW0j5qYsI0eXRFMbr9ZHelfLxp6E1KyLcHRq.png', 'about/banner/NkqximsxXCQwnf9sZDlUqVvQBEeCQ5aKrZu1BgqH.jpg', 'Tentang Kami', '2025-09-25 16:33:51', '2025-09-25 16:33:51'),
(17, 'WHS Konveksindo', 'WHS Konveksindo perusahaan bergerak dalam bidang konveksi garment spesialis memproduksi seragam jaket, kemeja pdl/pdh/korsa, jas almamater, weacpack terusan, rompi, tidak hanya itu, kami juga bisa membantu pengadaan topi, tas ransel, atau totebag. Lokasi kantor konveksi dan tempat produksi berada di Jl. Nitiprayan No.89B Ngestiharjo Kasihan Bantul D.I. yogyakarta. Vendor konveksi dengan peralatan mesin-mesin besar dapat memproduksi dengan kapasitas besar dan cepat. Dikerjakan dengan 4unit mesin bordir dan banyak penjahit yang handal dalam spesialis masing-masing produk.', 'about/JM3ObEfyoiG4uHyJRGFqRcvMNDNzdT4ODCZE6OrT.png', NULL, NULL, '2025-09-27 15:52:28', '2025-09-27 16:09:47');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `module` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `description`, `action`, `module`, `created_at`, `updated_at`) VALUES
(1, 11, 'Menghapus user: Israel Strosin', 'delete', 'user', '2025-09-22 15:37:14', '2025-09-22 15:37:14'),
(2, 11, 'Memperbarui user: Wahyu', 'update', 'user', '2025-09-23 10:16:30', '2025-09-23 10:16:30'),
(3, 11, 'Menambahkan user: YDK', 'create', 'user', '2026-01-15 17:22:20', '2026-01-15 17:22:20');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `layout` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` bigint UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `user_id`, `layout`, `is_published`, `meta_title`, `meta_description`, `keywords`, `views`, `created_at`, `updated_at`) VALUES
(4, 'Mengenal Usaha Konveksi Baju dan Jenis-Jenisnya', 'mengenal-usaha-konveksi-baju-dan-jenis-jenisnya', '<p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Biasanya pekerja di dunia konveksi akan memproduksi pakaian sesuai dengan permintaan pelanggan. Bisnis jasa ini juga bisa membuat produk sebagai kebutuhan bisnis. Oleh karena itu, kamu bisa meningkatkan pemasukan karena bantuan dari usaha konveksi.</p><h2 id=\"apa-itu-konveksi-baju\" style=\"font-weight: 500; font-family: Alte, sans-serif; line-height: 1.1; color: rgb(0, 48, 103); margin-top: 20px; margin-bottom: 10px; font-size: 30px;\"><span class=\"ez-toc-section\" id=\"Apa_Itu_Konveksi_Baju\" ez-toc-data-id=\"#Apa_Itu_Konveksi_Baju\"></span><span style=\"font-weight: 700;\">Apa Itu Konveksi Baju?</span><span class=\"ez-toc-section-end\"></span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\"><img fetchpriority=\"high\" decoding=\"async\" class=\"wp-image-17308 aligncenter entered lazyloaded\" src=\"https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju.webp\" alt=\"apa itu konveksi baju\" width=\"369\" height=\"369\" data-lazy-srcset=\"https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju.webp 512w, https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju-300x300.webp 300w, https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju-150x150.webp 150w, https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju-500x500.webp 500w\" data-lazy-sizes=\"(max-width: 369px) 100vw, 369px\" data-lazy-src=\"https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju.webp\" data-ll-status=\"loaded\" sizes=\"(max-width: 369px) 100vw, 369px\" srcset=\"https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju.webp 512w, https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju-300x300.webp 300w, https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju-150x150.webp 150w, https://tshirtbar.id/wp-content/uploads/2022/11/apa-itu-konveksi-baju-500x500.webp 500w\" style=\"height: auto; max-width: 100%; border: 0px; clear: both;\"></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Konveksi baju termasuk dalam kategori Industri Tekstil dan Produk Tekstil atau yang disebut dengan TPT Indonesia. Ada jenis usaha dalam TPT Indonesia yaitu penenunan dan perajutan, industri serat dan benang, pemintalan serta garmen.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Usaha konveksi baju berarti akan membuat banyak produk sesuai dengan permintaan. Adapun pakaiannya itu&nbsp; ada berbagai ukuran mulai dari S, M, L, dan XL. Atau bisa menyesuaikan dengan ukuran pembeli.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Menjalankan bisnis konveksi ini tidak bisa sendirian. Biasanya ada produsen, distributor pakaian dan pemilik usaha itu sendiri. Tidak jarang pemilik konveksi juga bekerjasama dengan pihak penjual label baju, pihak yang membantu proses&nbsp;<i>packaging</i>&nbsp;dan pembordir.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Terdapat tiga jenis pengusaha jasa ini yaitu mulai dari yang kecil, menengah hingga besar. Perbedaannya terdapat pada jangkauan penjualan, luasnya lokasi usaha, jumlah pegawai dan jumlah barang yang diproduksi.</p><h2 id=\"apa-saja-jenis-jenis-konveksi-\" style=\"font-weight: 500; font-family: Alte, sans-serif; line-height: 1.1; color: rgb(0, 48, 103); margin-top: 20px; margin-bottom: 10px; font-size: 30px;\"><span class=\"ez-toc-section\" id=\"Apa_Saja_Jenis-Jenis_Konveksi_Baju\" ez-toc-data-id=\"#Apa_Saja_Jenis-Jenis_Konveksi_Baju\"></span><span style=\"font-weight: 700;\">Apa Saja Jenis-Jenis Konveksi Baju?</span><span class=\"ez-toc-section-end\"></span></h2><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\"><img decoding=\"async\" class=\"wp-image-17309 aligncenter entered lazyloaded\" src=\"https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju.webp\" alt=\"jenis jenis konveksi baju\" width=\"374\" height=\"374\" data-lazy-srcset=\"https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju.webp 512w, https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju-300x300.webp 300w, https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju-150x150.webp 150w, https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju-500x500.webp 500w\" data-lazy-sizes=\"(max-width: 374px) 100vw, 374px\" data-lazy-src=\"https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju.webp\" data-ll-status=\"loaded\" sizes=\"(max-width: 374px) 100vw, 374px\" srcset=\"https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju.webp 512w, https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju-300x300.webp 300w, https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju-150x150.webp 150w, https://tshirtbar.id/wp-content/uploads/2022/11/jenis-jenis-konveksi-baju-500x500.webp 500w\" style=\"height: auto; max-width: 100%; border: 0px; clear: both;\"></p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Sesuai dengan pengertian di atas, konveksi baju adalah sebuah jasa yang bergerak dibidang produsen pakaian besar-besaran. Ada beragam jenis produk yang biasanya diproduksi dan setiap konveksi berbeda-beda.</p><h3 id=\"-&nbsp;-&nbsp;-&nbsp;--usaha-konveksi-paka\" style=\"font-weight: 500; font-family: Alte, sans-serif; line-height: 1.1; color: rgb(0, 48, 103); margin-top: 20px; margin-bottom: 10px; font-size: 24px;\"><span class=\"ez-toc-section\" id=\"1_Usaha_Konveksi_Pakaian_Muslim_Wanita_dan_Laki-Laki\" ez-toc-data-id=\"#1_Usaha_Konveksi_Pakaian_Muslim_Wanita_dan_Laki-Laki\"></span><span style=\"font-weight: 700;\">1.&nbsp;</span><span style=\"font-weight: 700;\">Usaha Konveksi Pakaian Muslim Wanita dan Laki-Laki</span><span class=\"ez-toc-section-end\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Jenis usaha pertama bergerak di bidang konveksi pakaian muslim laki-laki dan wanita. Biasanya jenis pakaian yang diproduksi adalah gamis, baju koko, dan sebagainya. Usaha konveksi pakaian muslim ini akan banyak peminat ketika memasuki musim Hari Raya Idul Fitri.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Tentunya semua orang berlomba-lomba ingin tampil dengan pakaian terbaru. Oleh karena itu pihak konveksi memanfaatkan momentum ini untuk meraup banyak penghasilan. Semakin tahun desain yang dibuat juga semakin beragam sehingga peminatnya tidak pernah redup.</p><h3 id=\"-&nbsp;-&nbsp;-&nbsp;--usaha-konveksi-hija\" style=\"font-weight: 500; font-family: Alte, sans-serif; line-height: 1.1; color: rgb(0, 48, 103); margin-top: 20px; margin-bottom: 10px; font-size: 24px;\"><span class=\"ez-toc-section\" id=\"2_Usaha_Konveksi_Hijab\" ez-toc-data-id=\"#2_Usaha_Konveksi_Hijab\"></span><span style=\"font-weight: 700;\">2.</span>&nbsp;<span style=\"font-weight: 700;\">Usaha Konveksi Hijab</span><span class=\"ez-toc-section-end\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Walaupun usaha konveksi baju adalah jasa yang memproduksi pakaian, namun ada juga konveksi hijab. Di negara dengan mayoritas Muslim ini, kebutuhan akan hijab semakin hari kian meningkat. Oleh karena itu, bisnis konveksi hijab bisa dijadikan sebagai ladang usaha yang cukup menjanjikan.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Seiring dengan berkembangnya waktu, mulai bermunculan trend-trend hijab yang unik. Hal inilah yang membuat peminat untuk membeli hijab semakin meningkat khususnya di kalangan perempuan. Akan tetapi, hal terpenting sebelum memulai bisnis ini adalah membuat desain hijab menarik.</p><h3 id=\"-&nbsp;-&nbsp;-&nbsp;--usaha-konveksi-kaos\" style=\"font-weight: 500; font-family: Alte, sans-serif; line-height: 1.1; color: rgb(0, 48, 103); margin-top: 20px; margin-bottom: 10px; font-size: 24px;\"><span class=\"ez-toc-section\" id=\"3_Usaha_Konveksi_Kaos\" ez-toc-data-id=\"#3_Usaha_Konveksi_Kaos\"></span><span style=\"font-weight: 700;\">3.</span>&nbsp;<span style=\"font-weight: 700;\">Usaha Konveksi Kaos</span><span class=\"ez-toc-section-end\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px; color: rgb(51, 51, 51); font-family: Alte, sans-serif;\">Terakhir adalah usaha di bidang kaos yang sudah merajalela, dibandingkan dengan dua jenis konveksi di atas, konveksi kaos lebih banyak pesaingnya. Oleh karena itu, jika kamu bergerak di bidang ini maka harus pintar-pintar dalam melakukan pemasaran.</p><p style=\"margin-right: 0px; margin-bottom: 10px; margin-left: 0px;\"><font color=\"#333333\" face=\"Alte, sans-serif\">Tidak hanya itu, kualitas layanan juga perlu ditingkatkan agar pelanggan merasa puas. Konveksi baju adalah sebuah usaha yang mementingkan kualitas karena dengan cara ini kamu akan mendapatkan banyak pembeli. Selain itu, sebagai pemilik bisnis kamu juga harus menyiapkan modal yang besar.</font><br><br><br><br></p>', 11, 'default', 1, 'Usaha-Konveksi', 'Usaha-Konveksi', 'Usaha-Konveksi', 27, '2025-10-06 16:06:37', '2026-01-12 04:19:01'),
(5, 'dsadad barrketuuu', 'dsadad-barrketuuu', '<p>dsadsad<br>dsadadsasdad<br>sASAsSDSDADAD</p><p>ssad<iframe frameborder=\"0\" src=\"//www.youtube.com/embed/Yv8xg0FMDXw\" width=\"640\" height=\"360\" class=\"note-video-clip\"></iframe></p><p><br></p><p><br></p>', 11, 'default', 1, 'sdad', 'dsadsa', 'sdada', 34, '2025-10-07 01:31:59', '2026-01-14 01:44:49'),
(7, 'Bahan Katun Poly: Pengertian, Karakteristik, hingga Kelebihannya!', 'bahan-katun-poly-pengertian-karakteristik-hingga-kelebihannya', '<h2 style=\"margin: 3rem 0px 20px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 24px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span style=\"font-weight: bolder; margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\">Karakteristik Bahan Katun Poly</span><span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h2><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\"><a href=\"https://master-sellers.gramedia.com/wp-content/uploads/2024/05/pexels-photo-6851140.webp\" style=\"transition-property: all; cursor: pointer; border-width: 0px; border-style: solid;\"><img class=\"wp-image-94096 aligncenter ls-is-cached lazyloaded\" src=\"https://master-sellers.gramedia.com/wp-content/uploads/2024/05/pexels-photo-6851140.webp\" alt=\"\" width=\"416\" height=\"277\" srcset=\"https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140.webp 2250w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-300x200.webp 300w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-1024x683.webp 1024w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-768x512.webp 768w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-1536x1024.webp 1536w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-2048x1365.webp 2048w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-561x374.webp 561w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-1122x748.webp 1122w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-364x243.webp 364w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-728x485.webp 728w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-608x405.webp 608w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-758x505.webp 758w, https://cdnwpseller.gramedia.net/wp-content/uploads/2024/05/pexels-photo-6851140-1152x768.webp 1152w\" sizes=\"(max-width: 416px) 100vw, 416px\" style=\"vertical-align: baseline; border-style: solid; margin: 0px auto; padding: 0px; border-width: 0px; outline: 0px; background: 0px 0px; max-width: 100%; height: auto; display: table; opacity: 1; transition: opacity 300ms;\"></a></p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif; text-align: center;\">(Sumber foto: www.pexels.com)</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Bahan katun poly memiliki sejumlah karakteristik yang membuatnya unik dan populer di berbagai industri tekstil. Berikut adalah beberapa karakteristik utama dari bahan katun poly:</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"1_Kombinasi_Serat_Katun_dan_Poliester\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>1. Kombinasi Serat Katun dan Poliester<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Bahan katun poly terbuat dari campuran serat katun dan poliester dalam berbagai proporsi, yang memberikan kain kelembutan alami dari katun dan kekuatan serta daya tahan dari poliester. Proporsi katun biasanya lebih dominan, namun persentasenya dapat bervariasi tergantung pada kebutuhan aplikasi dan preferensi produsen.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"2_Kenyamanan_dan_Kelembutan\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>2. Kenyamanan dan Kelembutan<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Kehadiran serat katun memberikan kenyamanan alami pada kain, membuatnya nyaman dipakai di kulit. Kelembutan kain ini membuatnya cocok untuk berbagai jenis pakaian, dari kaos hingga pakaian tidur.</p><div class=\"maste-tes\" id=\"maste-169822076\" style=\"background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\"></div><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"3_Kekuatan_dan_Ketahanan\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>3. Kekuatan dan Ketahanan<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Poliester memberikan kekuatan ekstra pada kain, membuatnya tahan terhadap kerutan, kusut, dan aus. Kekuatan ini menjadikan bahan katun poly cocok untuk digunakan dalam pakaian yang sering dipakai atau dalam produk rumah tangga yang memerlukan daya tahan ekstra.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"4_Perawatan_yang_Mudah\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>4. Perawatan yang Mudah<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Bahan katun poly cenderung mudah dirawat dan tidak memerlukan perawatan khusus. Kain ini biasanya dapat dicuci dengan mesin cuci biasa dan cepat kering, serta tidak mudah kusut, sehingga memudahkan dalam penggunaan sehari-hari.</p><div class=\"maste-promo\" id=\"maste-472960777\" style=\"background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\"><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></p><center style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"><br></center><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></p></div><div class=\"maste-content\" id=\"maste-1476960337\" style=\"background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\"></div><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"5_Sirkulasi_Udara\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>5. Sirkulasi Udara<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Meskipun memiliki campuran poliester, bahan katun poly masih mempertahankan sirkulasi udara yang cukup baik, terutama karena dominasi serat katun. Hal ini membuatnya tetap nyaman dipakai di berbagai kondisi suhu dan aktivitas.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"6_Harga_yang_Terjangkau\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>6. Harga yang Terjangkau<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Secara umum, bahan katun poly memiliki harga yang lebih terjangkau daripada beberapa bahan alami murni seperti katun organik. Harga yang lebih rendah membuatnya menjadi pilihan yang ekonomis tanpa mengorbankan kualitas atau kenyamanan.</p><div class=\"maste-adss2_2\" id=\"maste-419545757\" style=\"background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\"></div><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><h3 style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 21px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"><span class=\"ez-toc-section\" id=\"7_Beragam_Aplikasi\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span>7. Beragam Aplikasi<span class=\"ez-toc-section-end\" style=\"margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; background: 0px 0px;\"></span></h3><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Bahan katun poly digunakan dalam berbagai jenis produk tekstil, mulai dari pakaian sehari-hari hingga perlengkapan rumah tangga seperti sprei dan gorden. Fleksibilitas dan ketahanan bahan ini membuatnya cocok untuk berbagai aplikasi dan gaya desain.</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">Dengan kombinasi kelembutan katun dan kekuatan poliester, serta kemudahan perawatannya, bahan katun poly telah menjadi pilihan yang populer di berbagai industri tekstil. Karakteristiknya yang unik membuatnya cocok untuk berbagai kebutuhan dan preferensi konsumen, menjadikannya salah satu bahan favorit dalam dunia fashion dan produksi tekstil.</p><div class=\"maste-multiplex-2\" id=\"maste-1176254818\" style=\"background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; margin: 0px; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\"></div><h2 style=\"margin: 3rem 0px 20px; font-variant-numeric: normal; font-variant-east-asian: normal; font-variant-alternates: normal; font-size-adjust: none; font-kerning: auto; font-optical-sizing: auto; font-feature-settings: normal; font-variation-settings: normal; font-variant-position: normal; font-variant-emoji: normal; font-stretch: normal; font-size: 24px; line-height: 1.125; font-family: Poppins, Roboto, sans-serif; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; vertical-align: baseline; letter-spacing: -0.025em; color: rgb(0, 0, 0);\"></h2><p style=\"margin-right: 0px; margin-bottom: 20px; margin-left: 0px; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial; padding: 0px; border-width: 0px; border-style: solid; outline: 0px; font-size: 18px; vertical-align: baseline; color: rgb(102, 102, 102); font-family: Roboto, sans-serif;\">&nbsp;</p>', 11, 'default', 1, 'bahan kain', 'bahan kain', 'bahan kain', 17, '2025-10-10 00:40:50', '2026-09-24 02:43:29'),
(11, 'gdgdgdgdg', 'gdgdgdgdg', '<p>gdgdgdg</p>', 11, 'default', 1, 'gdgd', 'gdgdg', 'gdgdgd', 0, '2026-01-14 01:45:23', '2026-01-14 01:45:23');
INSERT INTO `articles` (`id`, `title`, `slug`, `content`, `user_id`, `layout`, `is_published`, `meta_title`, `meta_description`, `keywords`, `views`, `created_at`, `updated_at`) VALUES
(12, '10 Model Kaos Terbaik dan Paling Populer Saat ini', '10-model-kaos-terbaik-dan-paling-populer-saat-ini', '<h2 id=\"apa-itu-kaos\" style=\"font-family: &quot;Open Sans&quot;; color: rgb(17, 17, 17); font-weight: 400; margin: 30px auto 20px; font-size: 27px; line-height: 38px; text-align: justify;\"><b style=\"font-weight: bold;\">Apa itu Kaos?</b></h2><article class=\"text-token-text-primary w-full focus:outline-none [content-visibility:auto] supports-[content-visibility:auto]:[contain-intrinsic-size:auto_100lvh] scroll-mt-[calc(var(--header-height)+min(200px,max(70px,20svh)))]\" dir=\"auto\" tabindex=\"-1\" data-turn-id=\"request-68d5eb41-acf4-832d-842a-2fc495912548-18\" data-testid=\"conversation-turn-70\" data-scroll-anchor=\"true\" data-turn=\"assistant\" style=\"margin-left: auto; margin-right: auto; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\"><div class=\"text-base my-auto mx-auto pb-10 [--thread-content-margin:--spacing(4)] thread-sm:[--thread-content-margin:--spacing(6)] thread-lg:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:40rem] thread-lg:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col agent-turn\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\" dir=\"auto\" data-message-author-role=\"assistant\" data-message-id=\"602e79be-144e-4eb3-a043-3d0518dafa95\" data-message-model-slug=\"gpt-5-instant\"><div class=\"flex w-full flex-col gap-1 empty:hidden first:pt-[3px]\"><div class=\"markdown prose dark:prose-invert w-full break-words dark markdown-new-styling\"><p data-start=\"0\" data-end=\"182\" data-is-last-node=\"\" data-is-only-node=\"\" style=\"margin-bottom: 26px; overflow-wrap: break-word;\">Apa itu kaos? Kaos adalah pakaian sederhana yang dirancang untuk dipakai sehari-hari, memberikan kenyamanan sekaligus melindungi tubuh Knittopreneurs dari debu maupun sinar matahari.</p></div></div></div></div></div></div></article><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Kaos adalah pakaian universal yang bisa dipakai oleh siapa saja, baik laki-laki maupun perempuan. Dari anak-anak hingga orang dewasa, semua kalangan usia dapat menggunakan jenis pakaian ini.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\">Sejak dulu hingga kini, kaos menjadi pakaian yang wajib dimiliki karena nyaman dipakai dalam berbagai aktivitas dan mudah ditemukan. Selain cocok untuk bersantai atau tidur, kaos juga bisa dikenakan saat bepergian hingga acara formal jika dipadukan dengan blazer atau jas.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\"><strong style=\"font-weight: bold;\">Baca Juga:&nbsp;<a href=\"https://blog.knitto.co.id/1-kg-bahan-cotton-combed-24s-jadi-berapa-kaos/\" target=\"_blank\" rel=\"noopener\" style=\"color: rgb(0, 36, 255); pointer-events: auto;\">1 Kg Bahan Combed 24s jadi Berapa Kaos?</a></strong></p><h2 id=\"jenis-jenis-model-kaos-berdasarkan-bahannya\" style=\"font-family: &quot;Open Sans&quot;; color: rgb(17, 17, 17); font-weight: 400; margin: 30px auto 20px; font-size: 27px; line-height: 38px; text-align: justify;\"><b style=\"font-weight: bold;\">Jenis-Jenis Model Kaos Berdasarkan Bahannya</b></h2><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\"><a href=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABwAAAAQAAQMAAADcMd/BAAAABlBMVEUAAAD///+l2Z/dAAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAPVJREFUeNrtwQENAAAAwqD3T+3sARQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAN4QtAAFm5A6rAAAAAElFTkSuQmCC\" class=\"td-modal-image\" style=\"color: rgb(0, 36, 255); pointer-events: auto;\"><img class=\"aligncenter wp-image-22650 size-full lazyautosizes lazyloaded td-animation-stack-type0-2\" title=\"Model Kaos (2)\" src=\"https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2.jpg\" alt=\"Model Kaos \" width=\"1792\" height=\"1024\" data-src=\"https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2.jpg\" decoding=\"async\" data-srcset=\"https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2.jpg 1792w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-300x171.jpg 300w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-1024x585.jpg 1024w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-768x439.jpg 768w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-1536x878.jpg 1536w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-735x420.jpg 735w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-150x86.jpg 150w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-696x398.jpg 696w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-1068x610.jpg 1068w\" data-sizes=\"auto\" data-eio-rwidth=\"1792\" data-eio-rheight=\"1024\" sizes=\"696px\" srcset=\"https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2.jpg 1792w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-300x171.jpg 300w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-1024x585.jpg 1024w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-768x439.jpg 768w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-1536x878.jpg 1536w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-735x420.jpg 735w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-150x86.jpg 150w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-696x398.jpg 696w, https://blog.knitto.co.id/wp-content/uploads/2020/03/Model-Kaos-2-1068x610.jpg 1068w\" style=\"height: auto; max-width: 100%; border: 0px; clear: both; text-align: center; display: block; margin: 6px auto 21px; transition: opacity 0.3s cubic-bezier(0.39, 0.76, 0.51, 0.56); opacity: 0;\"></a></p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Kaos sebenarnya memiliki beragam jenis. Tetapi yang banyak digunakan untuk sehari hari hanya beberapa saja. Jika dilihat dari segi jenis bahannya, ada beberapa yang memang menjadi favorit masyarakat Indonesia.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Jenis bahan bisa menjadi penentu kualitas sebuah kaos yang Knittopreneurs pilih. Contohnya, jika menggunakan bahan combed, kaos tersebut termasuk berkualitas baik dan setara dengan standar kaos distro.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Jika Knittopreneurs memilih kaos berbahan cotton bamboo atau cotton modal, maka kualitasnya termasuk premium dengan kenyamanan yang lebih unggul. Tentunya, harga kaos tersebut biasanya lebih tinggi di bandingkan kaos dengan bahan standar.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Selain bahan premium, ada juga kaos berbahan carded yang harganya lebih terjangkau. Kaos&nbsp;<a href=\"https://blog.knitto.co.id/5-perbedaan-combed-vs-carded-wajib-ketahui/\" target=\"_blank\" rel=\"noopener\" style=\"color: rgb(0, 36, 255); pointer-events: auto;\">carded</a>&nbsp;sering dipilih sebagai alternatif jika Knittopreneurs ingin kualitas cukup baik namun lebih murah dibandingkan combed.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Selain itu, ada juga kaos-kaos yang mempunyai harga lebih terjangkau dari bahan-bahan yang sudah kami sebutkan diatas yaitu kaos bahan CVC, TC dan&nbsp;<a href=\"https://blog.knitto.co.id/bahan-polyester/\" target=\"_blank\" rel=\"noopener\" style=\"color: rgb(0, 36, 255); pointer-events: auto;\">Polyester</a>.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Kaos dengan bahan tersebut biasanya dijual dengan harga yang sangat terjangkau, biasanya digunakan untuk keperluan kaos-kaos gathering, kaos promosi atau kaos partai.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Kualitas dari kaos dengan 3 bahan ini biasanya tidak sebaik bahan Combed karena komposisi atau kandungan dari bahannya pun berbeda sehingga membuat kualitas dari kaos ini pun menjadi berbeda.&nbsp;</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\"><strong style=\"font-weight: bold;\">Baca Juga:&nbsp;<a href=\"https://blog.knitto.co.id/5-perbedaan-combed-vs-carded-wajib-ketahui/\" target=\"_blank\" rel=\"noopener\" style=\"color: rgb(0, 36, 255); pointer-events: auto;\">Perbedaan Cotton Combed vs Cotton Carded</a></strong></p><h2 id=\"10-model-kaos-yang-ada-di-pasaran\" style=\"font-family: &quot;Open Sans&quot;; color: rgb(17, 17, 17); font-weight: 400; margin: 30px auto 20px; font-size: 27px; line-height: 38px; text-align: justify;\"><b style=\"font-weight: bold;\">10 Model Kaos yang Ada di Pasaran</b></h2><article class=\"text-token-text-primary w-full focus:outline-none [content-visibility:auto] supports-[content-visibility:auto]:[contain-intrinsic-size:auto_100lvh] scroll-mt-[calc(var(--header-height)+min(200px,max(70px,20svh)))]\" dir=\"auto\" tabindex=\"-1\" data-turn-id=\"request-68d5eb41-acf4-832d-842a-2fc495912548-24\" data-testid=\"conversation-turn-82\" data-scroll-anchor=\"true\" data-turn=\"assistant\" style=\"margin-left: auto; margin-right: auto; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\"><div class=\"text-base my-auto mx-auto pb-10 [--thread-content-margin:--spacing(4)] thread-sm:[--thread-content-margin:--spacing(6)] thread-lg:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:40rem] thread-lg:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col agent-turn\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\" dir=\"auto\" data-message-author-role=\"assistant\" data-message-id=\"62e76af6-f420-4f33-be59-e1a97ca91b42\" data-message-model-slug=\"gpt-5-instant\"><div class=\"flex w-full flex-col gap-1 empty:hidden first:pt-[3px]\"><div class=\"markdown prose dark:prose-invert w-full break-words dark markdown-new-styling\"><p data-start=\"0\" data-end=\"197\" data-is-last-node=\"\" data-is-only-node=\"\" style=\"margin-bottom: 26px; overflow-wrap: break-word;\">Kaos tidak hanya dibedakan dari jenis bahannya, tetapi juga dari model atau bentuknya. Dengan begitu, Knittopreneurs bisa menemukan variasi kaos yang sesuai dengan kebutuhan dan gaya masing-masing.</p></div></div></div></div></div></div></article><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Seiring waktu, model kaos kini semakin beragam dan tidak hanya terbatas pada kerah “O” standar saja. Banyak pengusaha kaos yang menghadirkan desain lebih kreatif sehingga pilihan untuk Knittopreneurs pun semakin luas.</p><article class=\"text-token-text-primary w-full focus:outline-none [content-visibility:auto] supports-[content-visibility:auto]:[contain-intrinsic-size:auto_100lvh] scroll-mt-[calc(var(--header-height)+min(200px,max(70px,20svh)))]\" dir=\"auto\" tabindex=\"-1\" data-turn-id=\"request-68d5eb41-acf4-832d-842a-2fc495912548-26\" data-testid=\"conversation-turn-86\" data-scroll-anchor=\"true\" data-turn=\"assistant\" style=\"margin-left: auto; margin-right: auto; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px;\"><div class=\"text-base my-auto mx-auto pb-10 [--thread-content-margin:--spacing(4)] thread-sm:[--thread-content-margin:--spacing(6)] thread-lg:[--thread-content-margin:--spacing(16)] px-(--thread-content-margin)\"><div class=\"[--thread-content-max-width:40rem] thread-lg:[--thread-content-max-width:48rem] mx-auto max-w-(--thread-content-max-width) flex-1 group/turn-messages focus-visible:outline-hidden relative flex w-full min-w-0 flex-col agent-turn\" tabindex=\"-1\"><div class=\"flex max-w-full flex-col grow\"><div class=\"min-h-8 text-message relative flex w-full flex-col items-end gap-2 text-start break-words whitespace-normal [.text-message+&amp;]:mt-5\" dir=\"auto\" data-message-author-role=\"assistant\" data-message-id=\"f7c9c799-4322-4071-a391-029548b23153\" data-message-model-slug=\"gpt-5-instant\"><div class=\"flex w-full flex-col gap-1 empty:hidden first:pt-[3px]\"><div class=\"markdown prose dark:prose-invert w-full break-words dark markdown-new-styling\"><p data-start=\"0\" data-end=\"216\" data-is-last-node=\"\" data-is-only-node=\"\" style=\"margin-bottom: 26px; overflow-wrap: break-word;\">Variasi kaos kini tidak hanya terlihat dari kerahnya, tetapi juga dari detail tambahan pada desainnya. Berikut beberapa jenis model kaos yang perlu Knittopreneurs ketahui, terutama jika berencana memulai bisnis kaos.</p></div></div></div></div></div></div></article><h3 id=\"1-model-kaos-o-neck\" style=\"font-family: &quot;Open Sans&quot;; color: rgb(17, 17, 17); font-weight: 400; margin: 27px auto 17px; font-size: 22px; line-height: 30px; text-align: justify;\"><b style=\"font-weight: bold;\">1. Model Kaos O-Neck</b></h3><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Salah satu model kaos standar yang sudah ada sejak dulu adalah jenis kaos dengan model kerah “O” Neck atau sering disebut juga dengan sebutan kaos polos biasa.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Kaos O-Neck mempunyai bentuk leher berbentuk O atau bulat seperti biasa.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Tapi kaos O-Neck pun bisa divariasikan bentuk kerahnya atau lebih lebar yang disengaja. Jika dilihat bentuk bagian leher kaosnya menyerupai oval.</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Untuk membentuk leher, pada kaos biasanya digunakan aksesoris tambahan atau disebut dengan rib. Apakah semua kaos harus menggunakan rib?</p><p style=\"margin-right: auto; margin-bottom: 26px; margin-left: auto; overflow-wrap: break-word; color: rgb(34, 34, 34); font-family: &quot;Open Sans&quot;; font-size: 15px; text-align: justify;\">Sebagian besar kaos memang menggunakan aksesoris tambahan berupa rib, tetapi hal ini tetap bergantung pada selera dan kreativitas. Ada juga model O-neck yang tidak memakai rib di bagian leher dan dikenal dengan sebutan self-fabric t-shirt.</p>', 11, 'default', 1, '10 Model Kaos Terbaik dan Paling Populer Saat ini', 'kaos terbaik', '10 Model Kaos Terbaik dan Paling Populer Saat ini', 1, '2026-01-16 15:49:22', '2026-01-16 15:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `article_images`
--

CREATE TABLE `article_images` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `caption` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `article_images`
--

INSERT INTO `article_images` (`id`, `article_id`, `image_path`, `caption`, `created_at`, `updated_at`) VALUES
(11, 4, 'articles/Cjq8vozl53HQYkvNSegQd6jNZ8vAFvrqJGFl0a44.jpg', '', '2025-10-06 16:06:37', '2025-10-06 16:06:37'),
(12, 5, 'articles/7YEaHgIKiyhuNxvaQnV3v7wvshNsGkEFZ7vbmaJw.jpg', '', '2025-10-07 01:31:59', '2025-10-07 01:31:59'),
(15, 7, 'articles/DnuPigygdM2I175MGwN4tJFdgaZosnas7IXOs26L.png', '', '2025-10-10 01:03:51', '2025-10-10 01:03:51'),
(20, 11, 'articles/hMGoX5UFSCA42S1UVoWN2mSmmerMQjDandT6NPP1.jpg', '', '2026-01-14 01:45:23', '2026-01-14 01:45:23'),
(21, 12, 'articles/RXlrlykjiqdzDUzzrj2BPuSVJ6M5RA3ce6FBe4UH.jpg', '', '2026-01-16 15:49:22', '2026-01-16 15:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL DEFAULT '1',
  `price` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(2, 'Jaket Parka', '[\"categories\\/sWW9MB4IVOXS5qwsiHQlfmYGY0Kz9yQjTsaYGRpz.jpg\",\"categories\\/a53suVcJuMd3U2zsk5pLn7CZawm1kmIbon4KaWMS.jpg\"]', 'jaket-parka', NULL, '2025-09-26 16:57:43', '2025-09-26 17:09:30'),
(3, 'Jaket Pria', '[\"categories\\/6pUf2eDkFQwZU0ZugfhtXdoLJQ82SBQ8bEWLAKh3.jpg\",\"categories\\/U7xorIiRNB7BFpOUEJxLOovh98h5w9S9Us2YukV4.jpg\",\"categories\\/SJJTkIhsdZukeV2WStucH63jJyl044RmFLFLanm1.jpg\",\"categories\\/4dW7A483hQyKgvGIBaR3QLvVrmocQGRPX7sGCN55.jpg\"]', 'jaket-merah', NULL, '2025-09-26 17:11:15', '2025-12-31 08:41:11'),
(4, 'jaket wanita', '[\"categories\\/slcfuGPWmUhMgsaSKdd4UMvOphNP6mSrym9pviKO.jpg\",\"categories\\/8rXOkPS9KW5zY4gOw8fNT8JS3RnDVXRJKTjtzPwq.jpg\"]', 'jaket-wanita', NULL, '2025-09-26 17:15:04', '2025-09-26 17:15:04'),
(5, 'Gaun wanita', '[\"categories\\/8riKAHpJ1GRrWyQaWXwth1ZLle3TpdckU46BoICD.jpg\",\"categories\\/XqdTzNNmnIha5dN72XpHvq4DimUmdyVc4jYf1fwf.jpg\"]', 'gaun-wanita', NULL, '2025-09-26 17:15:47', '2026-01-13 04:56:48'),
(6, 'Kaos Pria Warna', '[\"categories\\/zu9mnJfLTJzHN62xhplVNdjUph0UwGBkX0W0CmfM.jpg\",\"categories\\/7LK0y4E9zm9L4q7E9tj62lWV3YBfpfJWUYYpScqJ.jpg\",\"categories\\/s4paWPKH6qTehHhIHrsAZWVaHq3HEiPsiH8TP2sU.jpg\"]', 'kaos-pria', NULL, '2025-09-26 17:16:51', '2026-01-05 14:06:42'),
(7, 'Aksesoris', '[\"categories\\/IdTWU7WlhX1IM9WGpwzSjkUabozlsKh3l32m9kQ7.jpg\"]', 'aksesoris', NULL, '2025-09-26 17:18:00', '2025-09-26 17:18:00'),
(8, 'Jaket Hodie Oversize  Hodie', '[\"categories\\/DPKAPTmnFNYyokwDZvWInhlTh93mbtJyYFm1f9DC.png\",\"categories\\/T0yPlXEcpgjhGmXt2JNOLDo3vwQssFlqvHiJiQPx.png\"]', 'jaket-hodie-oversize', NULL, '2026-01-01 16:40:22', '2026-01-13 04:37:43'),
(11, 'Jaket Hodie Oversize', '[\"categories\\/ztQ7aFnM51fzW3MIV8SvzY2ZGT3VJMRgzgrM2Pqo.png\",\"categories\\/M4PPRVGG6qKkqkxZzYPLwJ4wxiEE2ZpPcYZXWO6s.png\",\"categories\\/QbQyF6IjVgNBBrLXsADIuGqOXMnBUm37E5E1ikRA.png\"]', 'jaket-hodie-oversize-1', NULL, '2026-01-13 04:32:43', '2026-01-13 04:32:43'),
(16, 'Yans Pro asoy', '[\"categories\\/Au1PDdaJJxB0yB94wOmPO3nCtpbDK8IkEvRHQ3UA.png\"]', 'yans-pro', NULL, '2026-01-14 01:42:00', '2026-01-14 01:42:11'),
(17, 'Rompi Jaket', '[\"categories\\/mLmodN7Fk7DmMJdBxb7QU13GDw0KOWcOU6KFAWxB.jpg\"]', 'rompi-jaket', NULL, '2026-01-21 04:07:45', '2026-01-21 04:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` tinyint NOT NULL DEFAULT '5',
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `name`, `email`, `rating`, `comment`, `is_approved`, `created_at`, `updated_at`) VALUES
(5, 5, 'adit', NULL, 4, 'dsasda', 1, '2025-10-07 07:17:03', '2025-10-07 07:17:03'),
(6, 4, 'tisa', NULL, 4, 'erwerwrwdwee\r\nDadwqdweq', 1, '2025-10-09 02:15:15', '2025-10-09 02:15:15'),
(7, 5, 'dika', NULL, 5, 'bagus', 1, '2025-12-29 15:07:57', '2025-12-29 15:07:57'),
(8, 5, 'Yayan Dwi Kusuma', 'yayan@gmail.com', 5, 'eas', 1, '2026-01-12 04:10:22', '2026-01-12 04:10:22'),
(9, 7, 'Yayan Dwi Kusuma', 'yayan@gmail.com', 2, 'tes', 1, '2026-01-12 04:29:00', '2026-01-12 04:29:00'),
(10, 7, 'bagas', 'bagas@gmail.com', 5, 'rgrs', 1, '2026-09-24 02:43:24', '2026-09-24 02:43:24');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `password`, `is_active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Yayan Dwi Kusuma', 'yayan@gmail.com', '089650159285', 'Prenggan ,Kota Gede Yogyakarta 55172', '$2y$12$xgxPU/xdYUV/KGwopcjs8uITVj7OIc9CMTP1l2iggS.Sqs1sVCfDa', 1, NULL, '2025-12-24 07:34:14', '2025-12-30 14:50:18'),
(2, 'Andi Poto', 'andi@gmail.com', '089650159285', 'Patalan KG2/685a RT :37 RW : 08 , Prenggan , Kotagede ,Jogjakarta Rumah bapak surojo gang nakula 200 m keselatan rumah tingkat kori jalan waena orange', '$2y$12$LZQD6pOGnroLtT.4ufUQ5O43NYc.LVVhPx0Cp7NQfnajjoN9Jea6K', 1, NULL, '2026-01-05 10:38:14', '2026-01-05 10:38:14'),
(3, 'bagas', 'bagas@gmail.com', '089650159285', 'Patalan Kotagede', '$2y$12$WDDz3/lMI/7YMubwXxoSTetclgGvC2P0DZz8gHvOEXgbMQ1gtjEsK', 1, NULL, '2026-01-15 12:50:15', '2026-01-15 12:50:15');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` json NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `category_id`, `title`, `image`, `description`, `status`, `created_at`, `updated_at`) VALUES
(10, 2, 'Jaket Parka tipe Tiger Camo', '\"[\\\"galleries\\\\/SkpS0Hd5U86lvgDIw4TEyCjYR5c8jrtbMH7tcOJW.jpg\\\",\\\"galleries\\\\/m0QenhFLo5L3WlIPUQCnBbUxTqhFoyJN9Bh1ASMy.jpg\\\",\\\"galleries\\\\/kWIdchCdU3inxTs8Sc1XJYAqwtHGbI5p3VF8FCEB.jpg\\\",\\\"galleries\\\\/bZorT1RUUEmPy6LtzZnegdXslKbrpd0Zo7e3BcX1.jpg\\\",\\\"galleries\\\\/OcBFIhW0iYlkcHEihLobmqUw5CEpjjzPORFI5C7A.jpg\\\"]\"', 'Jaket Parka tipe Tiger Camo', 'active', '2025-12-30 15:59:14', '2025-12-30 16:52:34'),
(11, 2, 'Jaket Parka tiger camo coklat', '\"[\\\"galleries\\\\/F0WccMeh3tEws166S87vSK9amLKTfKk7nr5UF9Nn.jpg\\\",\\\"galleries\\\\/HHaU6RHRclTzPiJmnnAFefSScQtvzYQik3mySUKx.jpg\\\",\\\"galleries\\\\/nDOfMKmGXzijCO5VPhEKSKzVPbCnEW6eJSErA822.jpg\\\",\\\"galleries\\\\/jQ0KNOe5kCYEyYB0EncGFjeejluh6WMxPG8YsBly.jpg\\\",\\\"galleries\\\\/HDSEwuiHTf6xi3h155bt6VEPMZtA05ZqUQ1nn8NM.jpg\\\",\\\"galleries\\\\/fnlCZWPkRPmMBcyLICRP2zTCCMjlEF19qoZMlZZB.jpg\\\"]\"', 'Jaket Parka tiger camo coklat', 'active', '2025-12-30 17:01:21', '2025-12-30 17:01:21'),
(12, NULL, 'jaket no Name yasudah', '\"[\\\"galleries\\\\/RQEpT0x4NkLjNWqXn2Rcdw6QGm4chc4OciaiArQr.jpg\\\",\\\"galleries\\\\/MdXyA1BuLNGCjIntu3TnvKPbKltPYX8BXFMw57Yx.jpg\\\",\\\"galleries\\\\/pL6ijar0NSS1zRULQ0oqbwlLWiG5SvIdi0aYdMJo.jpg\\\",\\\"galleries\\\\/5ESJkFsR5ifopJ4TNQJhNXc47DHCuFLYOM165fUO.jpg\\\"]\"', 'jaket no Name', 'inactive', '2025-12-30 17:55:47', '2026-01-14 02:07:06'),
(13, NULL, 'Jaket Tanpa Kategori', '\"[\\\"galleries\\\\/18bMMJcDZP92YshDaFzlMbuJECpEmeebGxVTZPIB.jpg\\\",\\\"galleries\\\\/AJwdmT828RhbTWTiLQKSAxgw4Seh96UWjYMb0MZs.jpg\\\",\\\"galleries\\\\/cj7apkKawYAbTXSIx9e46ySNe7XPq09qEcgvO1e4.jpg\\\",\\\"galleries\\\\/MHnfiuAnnK91jI67AGZs8XJaA9AsuYudeEwNnKs2.jpg\\\"]\"', 'Jaket Tanpa Kategori', 'active', '2025-12-30 18:04:58', '2025-12-30 18:04:58'),
(14, 2, 'Jaket Parka Merah', '\"[\\\"galleries\\\\/REMm25WtYYjih1ONfh6KP6nkfO3g5ltYuZeK4CKM.jpg\\\",\\\"galleries\\\\/zWI3MTVdtZEUhmDyoCEhmbolVWp7vwQpc8HclPAV.jpg\\\",\\\"galleries\\\\/mQ2VlSO87vd5ti2gwr12mI8CRxHK5JMtEzFY1EZk.jpg\\\",\\\"galleries\\\\/ZTHQh84TSYNHWJn82tRDDJ46IeiwQGW4pxVEQ08k.jpg\\\"]\"', 'Jaket Parka Merah', 'active', '2025-12-30 18:07:35', '2025-12-30 18:07:35');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_12_13_144216_create_products_table', 1),
(7, '2023_12_14_134344_add_roles_phone_at_users', 1),
(8, '2023_12_27_135124_add_favorite_at_products', 1),
(9, '2024_01_03_145442_create_orders_table', 1),
(10, '2024_01_03_145447_create_order_items_table', 1),
(11, '2024_09_08_025520_create_categories_table', 1),
(12, '2024_09_08_030550_alter_category_products', 1),
(13, '2025_07_01_084719_add_roles_and_phone_to_users_table', 1),
(14, '2025_07_01_092720_modify_roles_enum_on_users_table', 1),
(15, '2025_07_01_093334_finalize_roles_enum_on_users_table', 1),
(16, '2025_07_01_133719_add_photo_to_users_table', 1),
(17, '2025_07_09_235735_create_activity_logs_table', 1),
(18, '2025_07_10_110911_create_settings_table', 1),
(19, '2025_07_11_015306_add_extra_fields_to_settings_table', 1),
(20, '2025_09_23_091000_create_navigation_menus_table', 2),
(21, '2025_09_23_135419_create_sliders_table', 3),
(22, '2025_09_23_153346_create_about_us_table', 4),
(23, '2025_09_26_161726_add_fields_to_categories_table', 5),
(24, '2025_09_28_161641_create_galleries_table', 6),
(25, '2025_09_28_163557_add_status_to_galleries_table', 7),
(26, '2025_10_02_032551_create_articles_table', 8),
(27, '2025_10_02_032703_create_article_images_table', 8),
(28, '2025_10_02_032715_create_comments_table', 8),
(29, '2025_10_02_032728_create_reviews_table', 8),
(30, '2025_10_03_095530_add_rating_to_comments_table', 9),
(31, '2025_12_23_162253_create_customers_table', 10),
(32, '2025_12_31_025712_update_products_for_custom_convection', 11),
(33, '2025_12_31_030453_create_product_options_table', 12),
(34, '2025_12_31_030529_create_product_option_values_table', 12),
(35, '2025_12_31_084753_remove_category_column_from_products', 13),
(36, '2026_01_03_141416_update_orders_table', 14),
(37, '2026_01_03_141452_update_order_items_table', 15),
(38, '2026_01_03_141523_create_order_item_options_table', 15),
(39, '2026_01_03_141548_create_order_item_processes_table', 15),
(42, '2026_01_03_160432_create_cart_items_table', 16),
(43, '2026_01_05_044847_create_order_statuses_table', 16),
(44, '2026_01_05_050015_create_production_processes_table', 17),
(45, '2026_01_05_050050_create_order_item_process_logs_table', 18),
(46, '2026_01_05_050711_add_status_id_to_orders_table', 19),
(47, '2026_01_12_135328_add_slug_to_products_table', 20),
(48, '2026_01_15_195427_add_is_read_to_orders_table', 21);

-- --------------------------------------------------------

--
-- Table structure for table `navigation_menus`
--

CREATE TABLE `navigation_menus` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('internal','external') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'internal',
  `parent_id` bigint UNSIGNED DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `open_in_new_tab` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `navigation_menus`
--

INSERT INTO `navigation_menus` (`id`, `title`, `slug`, `url`, `type`, `parent_id`, `order`, `icon`, `active`, `open_in_new_tab`, `created_at`, `updated_at`) VALUES
(2, 'Beranda', 'beranda', '/beranda', 'internal', NULL, 1, NULL, 1, 0, '2025-09-23 12:33:08', '2025-09-26 01:06:20'),
(3, 'Tentang Kami', 'tentang-kami', '/tentang-kami', 'internal', NULL, 2, NULL, 1, 0, '2025-09-23 12:33:37', '2025-09-27 15:26:45'),
(4, 'Produk', 'produk', '/produk', 'internal', NULL, 3, NULL, 1, 0, '2025-09-23 12:35:45', '2025-12-31 16:22:23'),
(5, 'Kategori', 'kategori', '/kategori', 'internal', NULL, 4, NULL, 0, 0, '2025-09-27 03:53:45', '2025-12-29 12:06:49'),
(6, 'Gallery', 'gallery', '/gallery', 'internal', NULL, 5, NULL, 1, 0, '2025-09-28 16:07:52', '2025-10-01 02:13:55'),
(7, 'Artikel', 'artikel', '/artikel', 'internal', NULL, 6, NULL, 1, 0, '2025-10-03 04:06:49', '2025-10-03 04:06:49'),
(10, 'Contact Person', 'contact-person', '/contact-person', 'internal', NULL, 7, NULL, 0, 0, '2026-01-21 00:44:07', '2026-01-21 00:45:02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `status_id` bigint UNSIGNED DEFAULT NULL,
  `customer_id` bigint UNSIGNED NOT NULL,
  `order_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `transaction_time` timestamp NOT NULL,
  `total_price` int NOT NULL,
  `total_item` int NOT NULL,
  `subtotal` int NOT NULL,
  `payment_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'COD',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_status_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `status_id`, `customer_id`, `order_code`, `status`, `is_read`, `note`, `transaction_time`, `total_price`, `total_item`, `subtotal`, `payment_method`, `created_at`, `updated_at`, `updated_status_at`) VALUES
(5, NULL, 1, 'OC-NT74OX', 'Proses', 0, NULL, '2026-01-03 19:09:56', 220000, 3, 120000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-03 19:09:56', '2026-01-03 19:09:56', NULL),
(6, NULL, 1, 'OC-BWYNVJ', 'menunggu_konfirmasi', 1, NULL, '2026-01-03 19:15:50', 30000, 1, 30000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-03 19:15:50', '2026-01-21 01:38:58', NULL),
(7, NULL, 1, 'OC-UDEING', 'dp_received', 0, NULL, '2026-01-05 05:59:05', 1057780, 13, 1013780, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-05 05:59:05', '2026-01-05 10:34:00', NULL),
(8, NULL, 2, 'OC-EEELB2', 'ready_shipping', 0, NULL, '2026-01-05 10:39:26', 179756, 2, 175756, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-05 10:39:26', '2026-01-08 10:13:58', NULL),
(9, NULL, 1, 'OC-7ZMY78', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 08:09:06', 1452000, 6, 1380000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 08:09:06', '2026-01-15 20:25:51', NULL),
(10, NULL, 1, 'OC-UN4KGN', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 08:47:46', 320000, 1, 320000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 08:47:46', '2026-01-15 20:25:51', NULL),
(11, NULL, 1, 'OC-SOKHGR', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 08:49:39', 1081000, 4, 1040000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 08:49:39', '2026-01-15 20:25:51', NULL),
(12, NULL, 1, 'OC-TIF6D3', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 08:57:58', 1065000, 3, 1050000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 08:57:58', '2026-01-15 20:25:51', NULL),
(13, NULL, 1, 'OC-AHN568', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:01:28', 412000, 4, 180000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:01:28', '2026-01-15 20:25:43', NULL),
(14, NULL, 1, 'OC-N3B9QB', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:09:12', 1420000, 4, 1400000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:09:12', '2026-01-15 20:25:43', NULL),
(15, NULL, 1, 'OC-PNBTGG', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:10:31', 355000, 1, 350000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:10:31', '2026-01-15 20:25:43', NULL),
(16, NULL, 1, 'OC-QXTEE9', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:16:16', 135000, 3, 135000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:16:16', '2026-01-15 20:25:43', NULL),
(17, NULL, 1, 'OC-VR8T27', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:35:27', 1420000, 4, 1400000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:35:27', '2026-01-15 20:25:43', NULL),
(18, NULL, 1, 'OC-RP21UZ', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:36:35', 355000, 1, 350000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:36:35', '2026-01-15 20:25:26', NULL),
(19, NULL, 1, 'OC-OBUQLS', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:45:25', 640000, 2, 640000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:45:25', '2026-01-15 20:25:26', NULL),
(20, NULL, 1, 'OC-VVGTZQ', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 09:53:55', 1065000, 3, 1050000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 09:53:55', '2026-01-15 20:25:26', NULL),
(21, NULL, 1, 'OC-2NCKE3', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 14:14:18', 355000, 1, 350000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 14:14:18', '2026-01-15 20:25:26', NULL),
(22, NULL, 1, 'OC-X4N7HK', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 14:34:01', 1385000, 4, 1370000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 14:34:01', '2026-01-15 20:25:26', NULL),
(23, NULL, 1, 'OC-EZQDZ4', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 14:38:08', 484000, 2, 460000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 14:38:08', '2026-01-15 20:22:06', NULL),
(24, NULL, 1, 'OC-CLWMIS', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 14:41:25', 309000, 3, 135000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 14:41:25', '2026-01-15 20:22:06', NULL),
(25, NULL, 1, 'OC-PIOMS5', 'Menunggu Konfirmasi', 1, NULL, '2026-01-10 15:12:21', 730000, 4, 730000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-10 15:12:21', '2026-01-15 20:22:06', NULL),
(26, NULL, 1, 'OC-OI7OI9', 'Menunggu Konfirmasi', 1, NULL, '2026-01-11 15:29:25', 2529000, 13, 2480000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-11 15:29:25', '2026-01-15 20:22:06', NULL),
(27, NULL, 1, 'OC-GDPUSL', 'waiting_dp', 0, NULL, '2026-01-12 14:29:50', 1301000, 8, 1185000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-12 14:29:50', '2026-01-12 14:31:39', NULL),
(28, NULL, 1, 'OC-ICO4DB', 'dikonfirmasi', 0, NULL, '2026-01-13 02:51:57', 98000, 1, 45000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-13 02:51:57', '2026-01-13 02:58:00', NULL),
(29, NULL, 3, 'OC-ELB6GR', 'selesai', 0, NULL, '2026-01-15 12:52:26', 1280000, 4, 1280000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 12:52:26', '2026-01-15 18:50:28', NULL),
(30, NULL, 3, 'OC-JAPOLN', 'Menunggu Konfirmasi', 1, NULL, '2026-01-15 19:49:25', 135000, 3, 135000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 19:49:25', '2026-01-15 20:22:06', NULL),
(31, NULL, 3, 'OC-V3VUQ9', 'Menunggu Konfirmasi', 1, NULL, '2026-01-15 20:00:46', 242000, 1, 230000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 20:00:46', '2026-01-15 20:21:54', NULL),
(32, NULL, 3, 'OC-XBAYIX', 'Menunggu Konfirmasi', 1, NULL, '2026-01-15 20:08:43', 760000, 1, 760000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 20:08:43', '2026-01-15 20:21:54', NULL),
(33, NULL, 3, 'OC-JKD09I', 'Menunggu Konfirmasi', 1, NULL, '2026-01-15 20:14:59', 87878, 1, 87878, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 20:14:59', '2026-01-15 20:21:54', NULL),
(34, NULL, 3, 'OC-I2T7GJ', 'Menunggu Konfirmasi', 1, NULL, '2026-01-15 20:15:35', 135000, 3, 135000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 20:15:35', '2026-01-15 20:21:54', NULL),
(35, NULL, 3, 'OC-V8NZRI', 'dibatalkan', 1, NULL, '2026-01-15 20:19:15', 355000, 1, 350000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 20:19:15', '2026-01-16 15:22:28', NULL),
(36, NULL, 3, 'OC-IUJOO1', 'menunggu_konfirmasi', 1, NULL, '2026-01-15 20:28:18', 170000, 1, 170000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-15 20:28:18', '2026-01-21 00:23:50', NULL),
(37, NULL, 3, 'OC-UDSN3E', 'Menunggu Konfirmasi', 1, NULL, '2026-01-21 00:24:39', 355000, 1, 350000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-21 00:24:39', '2026-01-21 00:25:04', NULL),
(38, NULL, 3, 'OC-CGZHAV', 'dikonfirmasi', 0, NULL, '2026-01-21 00:35:24', 320000, 1, 320000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-21 00:35:24', '2026-01-21 00:36:49', NULL),
(39, NULL, 3, 'OC-EQNLZF', 'menunggu_konfirmasi', 1, NULL, '2026-01-21 01:33:23', 45000, 1, 45000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-21 01:33:23', '2026-01-21 01:38:58', NULL),
(40, NULL, 3, 'OC-2HJVS4', 'dikonfirmasi', 1, NULL, '2026-01-21 01:38:45', 206000, 2, 90000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-01-21 01:38:45', '2026-01-21 01:39:35', NULL),
(41, NULL, 3, 'OC-JLC6UM', 'menunggu_konfirmasi', 1, NULL, '2026-02-12 12:42:13', 2940000, 25, 2940000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-02-12 12:42:13', '2026-02-12 16:47:33', NULL),
(42, NULL, 3, 'OC-JW0SVI', 'menunggu_konfirmasi', 1, NULL, '2026-02-12 16:12:44', 1415000, 7, 1415000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-02-12 16:12:44', '2026-02-12 16:47:33', NULL),
(43, NULL, 3, 'OC-YHUBWK', 'dikonfirmasi', 0, NULL, '2026-03-26 14:48:30', 1210000, 5, 1150000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-03-26 14:48:30', '2026-03-26 14:49:23', NULL),
(44, NULL, 3, 'OC-RVGSLN', 'menunggu_konfirmasi', 1, NULL, '2026-09-22 01:40:24', 920000, 4, 920000, 'Transfer Rek.Mandiri 0754343 AN.Wahyu', '2026-09-22 01:40:24', '2026-09-22 01:58:22', NULL),
(45, NULL, 3, 'OC-BWP2KE', 'menunggu_konfirmasi', 1, NULL, '2026-09-22 01:57:37', 1150000, 5, 1150000, 'Transfer Rek.Mandiri 0754343 AN.Yayan dwi kusuma', '2026-09-22 01:57:37', '2026-09-22 01:58:22', NULL),
(46, NULL, 3, 'OC-SZZIW0', 'menunggu_konfirmasi', 1, NULL, '2026-09-22 02:14:27', 1410000, 6, 1380000, 'Transfer Rek.Mandiri 0754343 AN.Yayan dwi kusuma', '2026-09-22 02:14:27', '2026-09-22 15:58:36', NULL),
(47, NULL, 3, 'OC-JEYCKB', 'menunggu_konfirmasi', 1, NULL, '2026-09-22 02:18:35', 1380000, 6, 1380000, 'Transfer Rek.Mandiri 0754343 AN.Yayan dwi kusuma', '2026-09-22 02:18:35', '2026-09-22 15:58:36', NULL),
(48, NULL, 3, 'OC-XGOHBN', 'menunggu_dp', 1, NULL, '2026-09-22 02:19:59', 1380000, 6, 1380000, 'Transfer Rek.Mandiri 0754343 AN.Yayan dwi kusuma', '2026-09-22 02:19:59', '2026-09-23 09:56:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `customer_id` bigint UNSIGNED DEFAULT NULL,
  `order_id` bigint UNSIGNED DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `price` int NOT NULL,
  `qty` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `customer_id`, `order_id`, `product_id`, `price`, `qty`, `note`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 11, 45000, 2, 'ok', 190000, '2026-01-03 17:41:14', '2026-01-03 19:09:56'),
(2, 1, 5, 10, 30000, 1, 'ok', 30000, '2026-01-03 18:12:51', '2026-01-03 19:09:56'),
(3, 1, 6, 10, 30000, 1, NULL, 30000, '2026-01-03 19:15:37', '2026-01-03 19:15:50'),
(4, 1, 7, 8, 87878, 10, 'di buat secepat kilat', 898780, '2026-01-05 05:58:17', '2026-01-05 05:59:05'),
(5, 1, 7, 11, 45000, 3, 'warna hitam semua', 159000, '2026-01-05 05:58:53', '2026-01-05 05:59:05'),
(6, 2, 8, 8, 87878, 2, 'ok', 179756, '2026-01-05 10:39:19', '2026-01-05 10:39:26'),
(7, 1, 9, 21, 230000, 3, NULL, 726000, '2026-01-09 18:28:52', '2026-01-10 08:09:06'),
(8, 1, 9, 21, 230000, 3, NULL, 726000, '2026-01-09 18:40:04', '2026-01-10 08:09:06'),
(12, NULL, 10, 20, 320000, 2, NULL, 640000, '2026-01-10 08:47:37', '2026-01-10 08:47:46'),
(13, NULL, 11, 21, 230000, 3, NULL, 726000, '2026-01-10 08:49:04', '2026-01-10 08:49:39'),
(14, NULL, 11, 19, 350000, 1, NULL, 355000, '2026-01-10 08:49:26', '2026-01-10 08:49:39'),
(15, NULL, 12, 19, 350000, 3, 'ukuran cstom sudah ok', 1065000, '2026-01-10 08:57:52', '2026-01-10 08:57:58'),
(16, NULL, 13, 11, 45000, 4, NULL, 412000, '2026-01-10 09:01:16', '2026-01-10 09:01:28'),
(17, NULL, 14, 19, 350000, 4, NULL, 1420000, '2026-01-10 09:09:06', '2026-01-10 09:09:12'),
(18, NULL, 15, 19, 350000, 2, NULL, 710000, '2026-01-10 09:10:27', '2026-01-10 09:10:31'),
(19, NULL, 16, 11, 45000, 3, NULL, 135000, '2026-01-10 09:15:51', '2026-01-10 09:16:16'),
(20, NULL, 17, 19, 350000, 4, NULL, 1420000, '2026-01-10 09:23:32', '2026-01-10 09:35:27'),
(21, NULL, 18, 19, 350000, 1, NULL, 355000, '2026-01-10 09:36:14', '2026-01-10 09:36:35'),
(22, NULL, 19, 20, 320000, 2, NULL, 640000, '2026-01-10 09:45:16', '2026-01-10 09:45:25'),
(23, NULL, 20, 19, 350000, 3, NULL, 1065000, '2026-01-10 09:46:52', '2026-01-10 09:53:55'),
(24, NULL, 21, 19, 350000, 1, NULL, 355000, '2026-01-10 14:14:12', '2026-01-10 14:14:18'),
(28, NULL, 22, 19, 350000, 3, NULL, 1065000, '2026-01-10 14:32:07', '2026-01-10 14:34:01'),
(30, NULL, 22, 20, 320000, 1, NULL, 320000, '2026-01-10 14:33:57', '2026-01-10 14:34:01'),
(31, NULL, 23, 21, 230000, 2, NULL, 484000, '2026-01-10 14:38:04', '2026-01-10 14:38:08'),
(32, NULL, 24, 11, 45000, 3, NULL, 309000, '2026-01-10 14:41:10', '2026-01-10 14:41:25'),
(33, NULL, 25, 20, 320000, 2, 'xl:10 \nm:20', 640000, '2026-01-10 15:00:32', '2026-01-10 15:12:21'),
(34, NULL, 25, 11, 45000, 2, NULL, 90000, '2026-01-10 15:11:54', '2026-01-10 15:12:21'),
(36, NULL, 26, 19, 350000, 5, NULL, 1775000, '2026-01-11 09:30:01', '2026-01-11 15:29:25'),
(38, NULL, 26, 11, 45000, 6, NULL, 270000, '2026-01-11 14:56:33', '2026-01-11 15:29:25'),
(39, NULL, 26, 21, 230000, 2, NULL, 484000, '2026-01-11 15:18:34', '2026-01-11 15:29:25'),
(45, NULL, 27, 20, 320000, 3, 'mantap jiwa', 960000, '2026-01-11 15:48:56', '2026-01-12 14:29:50'),
(46, NULL, 27, 11, 45000, 2, 'ok', 206000, '2026-01-12 14:27:41', '2026-01-12 14:29:50'),
(47, NULL, 27, 11, 45000, 3, NULL, 135000, '2026-01-12 14:29:42', '2026-01-12 14:29:50'),
(49, NULL, 28, 11, 45000, 1, NULL, 98000, '2026-01-13 02:51:48', '2026-01-13 02:51:57'),
(50, NULL, 29, 20, 320000, 4, 'kancing tg bagus\nuhijlik;uogyiuhjkl;\ndtryguhiljk;', 1280000, '2026-01-15 12:51:22', '2026-01-15 12:52:26'),
(51, NULL, 30, 11, 45000, 3, NULL, 135000, '2026-01-15 19:49:18', '2026-01-15 19:49:25'),
(52, NULL, 31, 21, 230000, 1, NULL, 242000, '2026-01-15 20:00:39', '2026-01-15 20:00:46'),
(53, NULL, 32, 7, 760000, 1, NULL, 760000, '2026-01-15 20:08:38', '2026-01-15 20:08:43'),
(54, NULL, 33, 8, 87878, 1, NULL, 87878, '2026-01-15 20:14:53', '2026-01-15 20:14:59'),
(55, NULL, 34, 11, 45000, 3, NULL, 135000, '2026-01-15 20:15:24', '2026-01-15 20:15:35'),
(56, NULL, 35, 19, 350000, 1, NULL, 355000, '2026-01-15 20:19:06', '2026-01-15 20:19:15'),
(57, NULL, 36, 9, 170000, 1, NULL, 170000, '2026-01-15 20:28:09', '2026-01-15 20:28:18'),
(58, NULL, 37, 19, 350000, 1, NULL, 355000, '2026-01-21 00:24:32', '2026-01-21 00:24:39'),
(59, NULL, 38, 20, 320000, 1, NULL, 320000, '2026-01-21 00:34:10', '2026-01-21 00:35:24'),
(60, NULL, 39, 11, 45000, 1, NULL, 45000, '2026-01-21 01:33:08', '2026-01-21 01:33:23'),
(61, NULL, 40, 11, 45000, 2, NULL, 206000, '2026-01-21 01:38:38', '2026-01-21 01:38:45'),
(67, NULL, 41, 10, 30000, 22, NULL, 660000, '2026-02-12 12:41:37', '2026-02-12 12:42:13'),
(68, NULL, 41, 7, 760000, 3, NULL, 2280000, '2026-02-12 12:42:05', '2026-02-12 12:42:13'),
(70, NULL, 42, 20, 320000, 4, 'kancing tg bagus\nuhijlik;uogyiuhjkl;\ndtryguhiljk;', 1280000, '2026-02-12 16:12:27', '2026-02-12 16:12:44'),
(71, NULL, 43, 21, 230000, 5, 'artyuixdcfghjk', 1210000, '2026-03-26 14:48:19', '2026-03-26 14:48:30'),
(72, NULL, 44, 21, 230000, 4, 'artyuixdcfghjk', 920000, '2026-09-21 17:22:44', '2026-09-22 01:40:24'),
(73, NULL, 45, 21, 230000, 6, 'artyuixdcfghjk', 1380000, '2026-09-22 01:57:30', '2026-09-22 01:57:37'),
(74, NULL, 46, 22, 230000, 6, 'ok', 1410000, '2026-09-22 02:14:18', '2026-09-22 02:14:27'),
(75, NULL, 47, 22, 230000, 6, 'ok', 1410000, '2026-09-22 02:17:35', '2026-09-22 02:18:35'),
(76, NULL, 48, 22, 230000, 6, 'ok', 1380000, '2026-09-22 02:19:50', '2026-09-22 02:19:59'),
(79, 3, NULL, 10, 30000, 1, NULL, 30000, '2026-09-23 01:27:55', '2026-09-23 01:27:55'),
(80, 3, NULL, 22, 230000, 11, NULL, 2530000, '2026-09-23 01:29:06', '2026-09-23 09:24:53'),
(81, 3, NULL, 20, 320000, 1, NULL, 320000, '2026-09-23 01:31:12', '2026-09-23 01:31:12'),
(82, 3, NULL, 22, 230000, 1, NULL, 230000, '2026-09-23 01:33:14', '2026-09-23 01:33:14'),
(83, 3, NULL, 21, 230000, 1, NULL, 230000, '2026-09-23 01:33:19', '2026-09-23 01:33:19'),
(84, 3, NULL, 20, 320000, 1, NULL, 320000, '2026-09-23 01:35:01', '2026-09-23 01:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_options`
--

CREATE TABLE `order_item_options` (
  `id` bigint UNSIGNED NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `product_option_id` bigint UNSIGNED DEFAULT NULL,
  `option_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_price` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_options`
--

INSERT INTO `order_item_options` (`id`, `order_item_id`, `product_option_id`, `option_name`, `extra_price`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '3x5cm (+Rp 50,000)', 50000, '2026-01-03 17:41:14', '2026-01-03 17:41:14'),
(2, 4, NULL, '3434 (+Rp 2,000)', 2000, '2026-01-05 05:58:17', '2026-01-05 05:58:17'),
(3, 5, NULL, 'YKK (+Rp 3,000)', 3000, '2026-01-05 05:58:53', '2026-01-05 05:58:53'),
(4, 5, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-05 05:58:53', '2026-01-05 05:58:53'),
(5, 6, NULL, '3434 (+Rp 2,000)', 2000, '2026-01-05 10:39:19', '2026-01-05 10:39:19'),
(6, 7, NULL, 'YKK (+Rp 10,000)', 10000, '2026-01-09 18:28:52', '2026-01-09 18:28:52'),
(7, 7, NULL, 'label (+Rp 2,000)', 2000, '2026-01-09 18:28:52', '2026-01-09 18:28:52'),
(8, 8, NULL, 'YKK (+Rp 10,000)', 10000, '2026-01-09 18:40:04', '2026-01-09 18:40:04'),
(9, 8, NULL, 'label (+Rp 2,000)', 2000, '2026-01-09 18:40:04', '2026-01-09 18:40:04'),
(11, 13, NULL, 'YKK (+Rp 10,000)', 10000, '2026-01-10 08:49:04', '2026-01-10 08:49:04'),
(12, 13, NULL, 'label (+Rp 2,000)', 2000, '2026-01-10 08:49:04', '2026-01-10 08:49:04'),
(13, 14, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 08:49:26', '2026-01-10 08:49:26'),
(14, 15, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 08:57:52', '2026-01-10 08:57:52'),
(15, 16, NULL, '3x5cm (+Rp 50,000)', 50000, '2026-01-10 09:01:16', '2026-01-10 09:01:16'),
(16, 16, NULL, 'YKK (+Rp 3,000)', 3000, '2026-01-10 09:01:16', '2026-01-10 09:01:16'),
(17, 16, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 09:01:16', '2026-01-10 09:01:16'),
(18, 17, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 09:09:06', '2026-01-10 09:09:06'),
(19, 18, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 09:10:27', '2026-01-10 09:10:27'),
(20, 20, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 09:23:32', '2026-01-10 09:23:32'),
(21, 21, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 09:36:14', '2026-01-10 09:36:14'),
(22, 23, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 09:46:52', '2026-01-10 09:46:52'),
(23, 24, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 14:14:12', '2026-01-10 14:14:12'),
(27, 28, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 14:32:07', '2026-01-10 14:32:07'),
(28, 31, NULL, 'YKK (+Rp 10,000)', 10000, '2026-01-10 14:38:04', '2026-01-10 14:38:04'),
(29, 31, NULL, 'label (+Rp 2,000)', 2000, '2026-01-10 14:38:04', '2026-01-10 14:38:04'),
(30, 32, NULL, '3x5cm (+Rp 50,000)', 50000, '2026-01-10 14:41:10', '2026-01-10 14:41:10'),
(31, 32, NULL, 'YKK (+Rp 3,000)', 3000, '2026-01-10 14:41:10', '2026-01-10 14:41:10'),
(32, 32, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-10 14:41:10', '2026-01-10 14:41:10'),
(33, 36, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-11 09:30:01', '2026-01-11 09:30:01'),
(34, 39, NULL, 'YKK (+Rp 10,000)', 10000, '2026-01-11 15:18:34', '2026-01-11 15:18:34'),
(35, 39, NULL, 'label (+Rp 2,000)', 2000, '2026-01-11 15:18:34', '2026-01-11 15:18:34'),
(36, 46, NULL, '3x5cm (+Rp 50,000)', 50000, '2026-01-12 14:27:41', '2026-01-12 14:27:41'),
(37, 46, NULL, 'YKK (+Rp 3,000)', 3000, '2026-01-12 14:27:41', '2026-01-12 14:27:41'),
(38, 46, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-12 14:27:41', '2026-01-12 14:27:41'),
(39, 49, NULL, '3x5cm (+Rp 50,000)', 50000, '2026-01-13 02:51:48', '2026-01-13 02:51:48'),
(40, 49, NULL, 'YKK (+Rp 3,000)', 3000, '2026-01-13 02:51:48', '2026-01-13 02:51:48'),
(41, 52, NULL, 'YKK (+Rp 10,000)', 10000, '2026-01-15 20:00:39', '2026-01-15 20:00:39'),
(42, 52, NULL, 'label (+Rp 2,000)', 2000, '2026-01-15 20:00:39', '2026-01-15 20:00:39'),
(43, 56, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-15 20:19:06', '2026-01-15 20:19:06'),
(44, 58, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-21 00:24:32', '2026-01-21 00:24:32'),
(45, 61, NULL, '3x5cm (+Rp 50,000)', 50000, '2026-01-21 01:38:38', '2026-01-21 01:38:38'),
(46, 61, NULL, 'YKK (+Rp 3,000)', 3000, '2026-01-21 01:38:38', '2026-01-21 01:38:38'),
(47, 61, NULL, 'Rayon (+Rp 5,000)', 5000, '2026-01-21 01:38:38', '2026-01-21 01:38:38'),
(49, 71, NULL, 'YKK (+Rp 10,000)', 10000, '2026-03-26 14:48:19', '2026-03-26 14:48:19'),
(50, 71, NULL, 'label (+Rp 2,000)', 2000, '2026-03-26 14:48:19', '2026-03-26 14:48:19'),
(51, 74, NULL, 'YKK (+Rp 5,000)', 5000, '2026-09-22 02:14:18', '2026-09-22 02:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_processes`
--

CREATE TABLE `order_item_processes` (
  `id` bigint UNSIGNED NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `process` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_item_processes`
--

INSERT INTO `order_item_processes` (`id`, `order_item_id`, `process`, `status`, `started_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 4, '2', 'processing', '2026-01-05 09:17:41', NULL, '2026-01-05 09:17:41', '2026-01-05 09:17:41'),
(2, 5, '1', 'processing', '2026-01-05 09:17:41', NULL, '2026-01-05 09:17:41', '2026-01-05 09:17:41'),
(3, 5, '2', 'processing', '2026-01-05 09:22:47', NULL, '2026-01-05 09:22:47', '2026-01-05 09:22:47'),
(4, 4, '4', 'processing', '2026-01-05 09:25:37', NULL, '2026-01-05 09:25:37', '2026-01-05 09:25:37'),
(5, 4, '1', 'processing', '2026-01-05 09:31:53', NULL, '2026-01-05 09:31:53', '2026-01-05 09:31:53'),
(6, 4, '2', 'processing', '2026-01-05 09:35:34', NULL, '2026-01-05 09:35:34', '2026-01-05 09:35:34'),
(7, 5, '1', 'processing', '2026-01-05 09:35:34', NULL, '2026-01-05 09:35:34', '2026-01-05 09:35:34'),
(8, 5, '2', 'processing', '2026-01-05 09:35:46', NULL, '2026-01-05 09:35:46', '2026-01-05 09:35:46'),
(9, 4, '4', 'processing', '2026-01-05 09:38:13', NULL, '2026-01-05 09:38:13', '2026-01-05 09:38:13'),
(10, 4, 'Potong Kain', 'processing', '2026-01-05 09:44:59', NULL, '2026-01-05 09:44:59', '2026-01-05 09:44:59'),
(11, 5, 'Jahit', 'processing', '2026-01-05 09:44:59', NULL, '2026-01-05 09:44:59', '2026-01-05 09:44:59'),
(12, 4, 'Jahit', 'processing', '2026-01-05 09:46:39', NULL, '2026-01-05 09:46:39', '2026-01-05 09:46:39'),
(13, 4, 'Belum Diproses', 'processing', '2026-01-05 09:50:30', NULL, '2026-01-05 09:50:30', '2026-01-05 09:50:30'),
(14, 4, 'Jahit', 'processing', '2026-01-05 09:53:16', NULL, '2026-01-05 09:53:16', '2026-01-05 09:53:16'),
(15, 4, 'QC', 'processing', '2026-01-05 09:53:42', NULL, '2026-01-05 09:53:42', '2026-01-05 09:53:42'),
(16, 5, 'Sablon', 'processing', '2026-01-05 09:53:42', NULL, '2026-01-05 09:53:42', '2026-01-05 09:53:42'),
(17, 6, 'Belum Diproses', 'processing', '2026-01-05 10:40:05', NULL, '2026-01-05 10:40:05', '2026-01-05 10:40:05'),
(18, 6, 'Potong Kain', 'processing', '2026-01-05 14:15:16', NULL, '2026-01-05 14:15:16', '2026-01-05 14:15:16'),
(19, 6, 'Jahit', 'processing', '2026-01-05 14:29:55', NULL, '2026-01-05 14:29:55', '2026-01-05 14:29:55'),
(20, 6, 'Bordir', 'processing', '2026-01-08 10:04:54', NULL, '2026-01-08 10:04:54', '2026-01-08 10:04:54'),
(21, 6, 'Sablon', 'processing', '2026-01-08 10:13:58', NULL, '2026-01-08 10:13:58', '2026-01-08 10:13:58'),
(22, 45, 'Potong Kain', 'processing', '2026-01-12 14:31:39', NULL, '2026-01-12 14:31:39', '2026-01-12 14:31:39'),
(23, 46, 'Bordir', 'processing', '2026-01-12 14:31:39', NULL, '2026-01-12 14:31:39', '2026-01-12 14:31:39'),
(24, 47, 'Jahit', 'processing', '2026-01-12 14:31:39', NULL, '2026-01-12 14:31:39', '2026-01-12 14:31:39'),
(25, 49, 'Potong Kain', 'processing', '2026-01-13 02:58:00', NULL, '2026-01-13 02:58:00', '2026-01-13 02:58:00'),
(26, 50, 'Potong Kain', 'processing', '2026-01-15 12:55:43', NULL, '2026-01-15 12:55:43', '2026-01-15 12:55:43'),
(27, 50, 'Jahit', 'processing', '2026-01-15 16:52:14', NULL, '2026-01-15 16:52:14', '2026-01-15 16:52:14'),
(28, 50, 'Finishing', 'completed', '2026-01-15 18:50:29', '2026-01-15 18:58:28', '2026-01-15 18:50:29', '2026-01-15 18:58:28'),
(29, 3, 'Belum Diproses', 'processing', '2026-01-15 19:42:16', NULL, '2026-01-15 19:42:16', '2026-01-15 19:42:16'),
(30, 57, 'Potong Kain', 'processing', '2026-01-16 15:21:41', NULL, '2026-01-16 15:21:41', '2026-01-16 15:21:41'),
(31, 56, 'Belum Diproses', 'processing', '2026-01-16 15:22:28', NULL, '2026-01-16 15:22:28', '2026-01-16 15:22:28'),
(32, 59, 'Jahit', 'processing', '2026-01-21 00:36:49', NULL, '2026-01-21 00:36:49', '2026-01-21 00:36:49'),
(33, 61, 'Belum Diproses', 'processing', '2026-01-21 01:39:35', NULL, '2026-01-21 01:39:35', '2026-01-21 01:39:35'),
(34, 71, 'Potong Kain', 'processing', '2026-03-26 14:49:23', NULL, '2026-03-26 14:49:23', '2026-03-26 14:49:23'),
(35, 67, 'Finishing', 'processing', '2026-09-22 01:22:14', NULL, '2026-09-22 01:22:14', '2026-09-22 01:22:14'),
(36, 68, 'Belum Diproses', 'processing', '2026-09-22 01:22:14', NULL, '2026-09-22 01:22:14', '2026-09-22 01:22:14'),
(37, 76, 'Belum Diproses', 'processing', '2026-09-23 09:56:40', NULL, '2026-09-23 09:56:40', '2026-09-23 09:56:40');

-- --------------------------------------------------------

--
-- Table structure for table `order_item_process_logs`
--

CREATE TABLE `order_item_process_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `order_item_id` bigint UNSIGNED NOT NULL,
  `production_process_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','running','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `started_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_statuses`
--

CREATE TABLE `order_statuses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'secondary',
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_statuses`
--

INSERT INTO `order_statuses` (`id`, `name`, `slug`, `color`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Menunggu Konfirmasi', 'menunggu_konfirmasi', 'warning', 1, 1, NULL, NULL),
(2, 'Dikonfirmasi', 'dikonfirmasi', 'primary', 2, 1, NULL, NULL),
(3, 'Menunggu DP', 'menunggu_dp', 'info', 3, 1, NULL, NULL),
(4, 'DP Diterima', 'dp_diterima', 'success', 4, 1, NULL, NULL),
(5, 'Produksi', 'produksi', 'info', 5, 1, NULL, NULL),
(6, 'Produksi Ditunda', 'produksi_ditunda', 'secondary', 6, 1, NULL, NULL),
(7, 'Siap Dikirim', 'siap_dikirim', 'primary', 7, 1, NULL, NULL),
(8, 'Selesai', 'selesai', 'success', 8, 1, NULL, NULL),
(9, 'Dibatalkan', 'dibatalkan', 'danger', 9, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_processes`
--

CREATE TABLE `production_processes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `production_processes`
--

INSERT INTO `production_processes` (`id`, `name`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Belum Diproses', 1, 1, NULL, NULL),
(2, 'Potong Kain', 2, 1, NULL, NULL),
(3, 'Jahit', 3, 1, NULL, NULL),
(4, 'Bordir', 4, 1, NULL, NULL),
(5, 'Sablon', 5, 1, NULL, NULL),
(6, 'QC', 6, 1, NULL, NULL),
(7, 'Finishing', 7, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `price` int NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT '0',
  `is_custom` tinyint(1) NOT NULL DEFAULT '1',
  `auto_select_all_custom` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` bigint UNSIGNED DEFAULT NULL,
  `images` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`, `deleted_at`, `is_best_seller`, `is_custom`, `auto_select_all_custom`, `is_active`, `category_id`, `images`) VALUES
(6, 'dsadsa', 'dsadsa', 'dsdsd', 43000, 0, NULL, '2025-12-31 10:01:04', '2025-12-31 10:43:19', '2025-12-31 10:43:19', 0, 1, 0, 1, 6, '[\"products/ideTvkFMpEaO5SYcHZYxePZGVHTMnbspJOtLnlSu.jpg\", \"products/HuehD4nAxkbc37q8TKGARugnAIJVEyxRjZjr6bPV.jpg\", \"products/sgFTaBMkugUdFfgKnUyRQFvG8riGQLt8EUbzU3nT.jpg\"]'),
(7, 'eed', 'eed', 'ddd', 760000, 0, NULL, '2025-12-31 10:01:47', '2025-12-31 10:01:47', NULL, 0, 1, 0, 1, 2, '[\"products/DEKznDsZApVIedHbnY5HCrWfq2mh4apfbYm85SGe.jpg\", \"products/b3n1Wal9114Xt0qBeTvQ8NKQI1o0kRoIs3SkKcxV.jpg\", \"products/INKAc0Oxn3HgVsn4p01Vaq2dvtyUbIXBdbmrF2N8.jpg\"]'),
(8, 'rewrwer', 'rewrwer', 'rewrewr', 87878, 0, NULL, '2025-12-31 10:12:30', '2025-12-31 10:43:03', NULL, 0, 1, 0, 1, 3, '[\"products/Tb9we3F4hJdEReS1NhFS5gttyITZLuW2hxQ0JPvR.jpg\", \"products/gQ7LNWfPUwtftI5Ss0f85YdnO0OSSAaVZfYrK5wj.jpg\", \"products/fvqray0pD4z9Q61Ii6Q8nG2EuToa9iUv6PVspGIV.jpg\", \"products/3QSO9eoFG7z22kbaZoXjhYE6EWniBQy9ggKBertM.jpg\", \"products/1GpkrIvy6VnsBM1uQ16b7bUP0oduQQHhSctNVKvj.jpg\", \"products/cwPx1nOYZZ0x1m67dRS6YOIkiI7UJ8dfzVBEiftV.jpg\"]'),
(9, 'Jaket Denim Type A', 'jaket-denim-type-a', 'Jaket Denim Type A', 170000, 0, NULL, '2025-12-31 15:35:00', '2025-12-31 15:35:00', NULL, 0, 1, 0, 1, 3, '[\"products/poapAcEm5l7MZODnAzpnbQ2Jklxn9vZ3I9Gduj4b.jpg\", \"products/2Zk2cARet3uyflYxE4iA4DW1de7U83OhvFjpO718.jpg\", \"products/cGcZ32SYj4eardiC6XbdinfzLLVQKXxfewgK8Qzo.jpg\"]'),
(10, 'Kaos Polos Custom', 'kaos-polos-custom', 'Kaos Polos Custom \r\nSize : all size', 30000, 0, NULL, '2026-01-01 10:56:31', '2026-01-01 10:56:31', NULL, 0, 1, 0, 1, 6, '[\"products/ZgnJrfvIZ8M1ahVMPz4U3UODq1KwyRPE3g2zd0Qs.jpg\", \"products/q4rwd0Tit2jYujyobgpr0zNdfgompfiVA1WNC44P.jpg\"]'),
(11, 'Jaket Hodie denim', 'jaket-hodie-denim', 'Jaket Hodie denim', 45000, 0, NULL, '2026-01-01 11:47:22', '2026-01-01 11:47:22', NULL, 0, 1, 0, 1, 6, '[\"products/0iPVMPBb1vMwIP3zlOmIIK3JWirGdP5bXSkYx3wo.jpg\", \"products/ZLAT5kKyBoYRaITnoi4TqqsFfUO7jDfvfmRi5U26.jpg\"]'),
(12, 'Jacket Lanvin Black', 'jacket-lanvin-black', 'The Lanvin Boxy Double Zip Jacket in Black is crafted from heavy premium Cotton Twill fabric (100% Cotton), with tremendous boxy fit cut and YKK Double Zipper will make this jacket looks outstanding and also comfort. The jacket had 2 pockets on the chest and 2 hidden pockets inside.\r\n\r\n\r\n\r\nPair with the Long Pants ‘Trousers’ for a co-ord outfit.\r\n\r\n\r\n\r\n• Black Double Zip Jacket\r\n\r\n• Contrast Stitching\r\n\r\n• Boxy Fit\r\n\r\n• YKK Double Zip Closure\r\n\r\n• 2 Pockets on Chest\r\n\r\n• 2 Hidden Pockets Inside', 403000, 0, NULL, '2026-01-09 16:09:06', '2026-01-09 17:10:49', '2026-01-09 17:10:49', 1, 0, 0, 1, 3, '[\"products/bp8V14QmZSvFATKxHKH8wNoVS2heQHreZc9xrUDu.png\", \"products/gEr9GiKrEjRjFvfv7T9xdqgsWbSknzfaU0rqh2IQ.png\", \"products/2baS58Xfi7O04gFXxVnDjw6m7xE3TczXWmgEqtuz.png\"]'),
(13, 'Jacket Lanvin Black 1', 'jacket-lanvin-black-1', 'The Lanvin Boxy Double Zip Jacket in Black is crafted from heavy premium Cotton Twill fabric (100% Cotton), with tremendous boxy fit cut and YKK Double Zipper will make this jacket looks outstanding and also comfort. The jacket had 2 pockets on the chest and 2 hidden pockets inside.', 370000, 0, NULL, '2026-01-09 16:12:18', '2026-01-09 17:11:16', '2026-01-09 17:11:16', 0, 1, 0, 1, 3, '[\"products/QHaLA7qM5e2y8X6n1X8GLOmt20Aln4M5pFm95rEC.png\"]'),
(16, 'Jaket Hitam Levis', 'jaket-hitam-levis', 'dsdssdsdsd', 2338333, 0, NULL, '2026-01-09 16:58:45', '2026-01-09 17:11:38', '2026-01-09 17:11:38', 0, 1, 1, 1, 3, '[\"products/9pajrdu6SMQAEOuSScHzmZ8emAklelKCgirfmGEr.png\", \"products/aQl2NeQZ8tRqoytDuPgNSoVbwFf6F4EEHUff4P8t.png\"]'),
(17, 'Boxy Double Zip Jacket \'Lanvin\' Black', 'boxy-double-zip-jacket-\'lanvin\'-black', 'The Lanvin Boxy Double Zip Jacket in Black is crafted from heavy premium Cotton Twill fabric (100% Cotton), with tremendous boxy fit cut and YKK Double Zipper will make this jacket looks outstanding and also comfort. The jacket had 2 pockets on the chest and 2 hidden pockets inside.\r\n\r\n\r\n\r\nPair with the Long Pants ‘Trousers’ for a co-ord outfit.\r\n\r\n\r\n\r\n• Black Double Zip Jacket\r\n\r\n• Contrast Stitching\r\n\r\n• Boxy Fit\r\n\r\n• YKK Double Zip Closure\r\n\r\n• 2 Pockets on Chest\r\n\r\n• 2 Hidden Pockets Inside', 347000, 0, NULL, '2026-01-09 17:13:28', '2026-01-09 17:41:11', '2026-01-09 17:41:11', 0, 1, 1, 1, 3, '[\"products/uVtJvPOSWR2Nz1RyZXIVWuLub7IfAKRoPd2JpDkz.png\", \"products/kufp2yZzM4AMOOQVQAi2HTMHa3p9XBNDD1P3dvYT.png\"]'),
(18, 'Jaket hitam Levis denim', 'jaket-hitam-levis-denim', 'sesdds', 496000, 0, NULL, '2026-01-09 17:31:19', '2026-01-09 17:41:44', '2026-01-09 17:41:44', 1, 1, 1, 1, 3, '[\"products/KuXxCGRCMjkxN1OVbq0TVOQhB9PnpHhWAbDXRx6x.png\", \"products/k2ZwcQjPWrARbwzOcss1Z3rA8JNIlpICxSQGFeV1.png\"]'),
(19, 'Jaket Hitam Levis warna hitam', 'jaket-hitam-levis-warna-hitam', 'raewawd', 350000, 0, NULL, '2026-01-09 17:44:17', '2026-01-09 17:45:10', NULL, 0, 0, 1, 1, 2, '[\"products/V6Tjx7Qf1oAf2pwtwa0NA4FpeCeNjkgLSsuRiiVW.png\", \"products/cb8Xyv2ZduEEkyauX5wBhxRJuo555xoUYt8mL15j.png\"]'),
(20, 'jaket warna hitam', 'jaket-warna-hitam', 'sdasdadas', 320000, 0, NULL, '2026-01-09 17:46:19', '2026-01-09 17:46:19', NULL, 0, 0, 0, 1, 3, '[\"products/Z0Ao2jdbVQGejmUTUu541y4MoJDMMXHJuiKrgME0.png\", \"products/nvGfkUjfSkpFZ604N8VqRwsGumpJRgf0i9XiyySo.png\"]'),
(21, 'Jaket Hodie Warna warni', 'jaket-hodie-warna-warni', 'saddsadasd', 230000, 0, NULL, '2026-01-09 17:48:03', '2026-09-21 16:43:44', NULL, 0, 0, 0, 1, 3, '[\"products/yPQHjFhHGFGvxaoZsgtUx6FY64vmAuE26OO8AxqW.png\", \"products/oG82qNi7dwa0gwQe6Knrlj0Tjh6ccmSS1WQgEtXR.png\"]'),
(22, 'Jaket Parka coklat', 'jaket-parka-coklat', 'eeeee', 230000, 0, NULL, '2026-09-21 16:45:35', '2026-09-21 16:56:27', NULL, 0, 0, 0, 1, 2, '[\"products/pPNPP7Xzn8ZDj78uacwgY0mtM6YVIL265TpjYKuG.png\"]'),
(23, 'Jaket Parka yyyyy', 'jaket-parka-yyyyy', 'ytrew', 25000, 0, NULL, '2026-09-24 01:57:24', '2026-09-24 01:57:59', NULL, 1, 0, 0, 1, 2, '[\"products/SXdI66IWLWN7tIYC3mGEVMpzb8at7jZzSLKOwxbt.png\"]');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('checkbox','select','number') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'checkbox',
  `is_required` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `name`, `type`, `is_required`, `created_at`, `updated_at`) VALUES
(9, 7, 'ersedsd', 'checkbox', 0, '2025-12-31 10:01:47', '2025-12-31 10:01:47'),
(11, 8, 'dsadsad', 'checkbox', 0, '2025-12-31 10:43:03', '2025-12-31 10:43:03'),
(13, 11, 'bordir', 'checkbox', 0, '2026-01-03 10:46:49', '2026-01-03 10:46:49'),
(14, 11, 'reet', 'select', 0, '2026-01-03 10:46:49', '2026-01-03 10:46:49'),
(15, 11, 'kain', 'number', 0, '2026-01-03 10:46:49', '2026-01-03 10:46:49'),
(40, 19, 'reet YKK', 'checkbox', 1, '2026-01-09 17:45:10', '2026-01-09 17:45:10'),
(41, 19, 'over size', 'checkbox', 1, '2026-01-09 17:45:10', '2026-01-09 17:45:10'),
(42, 19, 'kain rayon', 'checkbox', 1, '2026-01-09 17:45:10', '2026-01-09 17:45:10'),
(48, 21, 'reet besi', 'checkbox', 0, '2026-01-09 18:06:21', '2026-09-21 16:34:24'),
(49, 21, 'custom size', 'checkbox', 0, '2026-01-09 18:07:11', '2026-09-21 16:34:24'),
(50, 22, 'Rit YKK', 'checkbox', 0, '2026-09-21 16:45:35', '2026-09-21 16:45:35'),
(52, 22, 'kain', 'checkbox', 0, '2026-09-21 16:56:27', '2026-09-21 16:56:27'),
(53, 23, 'reet besi', 'checkbox', 0, '2026-09-24 01:57:24', '2026-09-24 01:57:24'),
(54, 23, 'yttt', 'checkbox', 1, '2026-09-24 01:57:59', '2026-09-24 01:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `product_option_values`
--

CREATE TABLE `product_option_values` (
  `id` bigint UNSIGNED NOT NULL,
  `product_option_id` bigint UNSIGNED NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_price` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_option_values`
--

INSERT INTO `product_option_values` (`id`, `product_option_id`, `label`, `extra_price`, `created_at`, `updated_at`) VALUES
(2, 11, '3434', 2000, '2025-12-31 10:43:03', '2025-12-31 10:43:03'),
(4, 13, '3x5cm', 50000, '2026-01-03 10:46:49', '2026-01-03 10:46:49'),
(5, 14, 'YKK', 3000, '2026-01-03 10:46:49', '2026-01-03 10:46:49'),
(6, 15, 'Rayon', 5000, '2026-01-03 10:46:49', '2026-01-03 10:46:49'),
(28, 42, 'Rayon', 5000, '2026-01-09 17:45:10', '2026-01-09 17:45:10'),
(32, 48, 'YKK', 10000, '2026-01-09 18:06:21', '2026-01-09 18:06:21'),
(33, 49, 'label', 2000, '2026-01-09 18:07:11', '2026-01-09 18:07:11'),
(34, 50, 'YKK', 5000, '2026-09-21 16:45:35', '2026-09-21 16:45:35'),
(36, 52, 'ewqwewq', 10000, '2026-09-21 16:56:27', '2026-09-21 16:56:27'),
(37, 53, 'rrr', 5000, '2026-09-24 01:57:24', '2026-09-24 01:57:24'),
(38, 54, 'tttt', 7000, '2026-09-24 01:57:59', '2026-09-24 01:57:59');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `article_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `review` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `store_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_instagram` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `store_tiktok` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`, `store_phone`, `store_instagram`, `store_tiktok`) VALUES
(1, 'store_name', 'WHS', '2025-09-22 15:34:57', '2025-09-22 15:35:50', NULL, NULL, NULL),
(2, 'store_footer_text', 'WHS Konveksi', '2025-09-22 15:34:57', '2025-09-22 15:34:57', NULL, NULL, NULL),
(3, 'store_address', 'Jl.Nitiprayan No.89B RT.03 DK.VII, Desa Ngestiharjo, Kec. Kasihan, Kab. Bantul, D. I. Yogyakarta', '2025-09-22 15:34:57', '2026-01-12 08:49:41', NULL, NULL, NULL),
(4, 'store_phone', '628970034456', '2025-09-22 15:34:57', '2026-09-22 02:19:09', NULL, NULL, NULL),
(5, 'store_instagram', NULL, '2025-09-22 15:34:57', '2025-09-22 15:34:57', NULL, NULL, NULL),
(6, 'store_tiktok', NULL, '2025-09-22 15:34:57', '2025-09-22 15:34:57', NULL, NULL, NULL),
(7, 'theme', 'light', '2025-09-22 15:34:57', '2025-09-22 15:34:57', NULL, NULL, NULL),
(8, 'store_logo', 'logo_1758555297.png', '2025-09-22 15:34:57', '2025-09-22 15:34:57', NULL, NULL, NULL),
(9, 'store_logo_alt', 'logo_alt_1758555297.png', '2025-09-22 15:34:57', '2025-09-22 15:34:57', NULL, NULL, NULL),
(10, 'bank_name', 'Mandiri', '2026-09-22 01:56:00', '2026-09-22 01:56:00', NULL, NULL, NULL),
(11, 'bank_account_number', '0754343', '2026-09-22 01:56:00', '2026-09-22 01:56:00', NULL, NULL, NULL),
(12, 'bank_account_holder', 'Yayan dwi kusuma', '2026-09-22 01:56:00', '2026-09-22 01:57:16', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `button_text`, `button_link`, `image`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Wahyu Konveksi', 'Wahyu Konveksi Indonesia', 'Click Now', '/produk', 'sliders/ahUpRjmJuV4eqosMmNVdsNiL3MVswN6kbXW5C4id.png', 0, 1, '2025-09-23 15:14:43', '2026-01-16 15:40:20'),
(3, 'Jacket Parka', 'Aneka Jaket Parka', 'Click More', 'Click More', 'sliders/KOuV6BRLKEduXS6pgIJVo4beRnlSxSapTULIkbxC.png', 1, 1, '2025-09-23 16:49:45', '2025-09-26 02:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` enum('admin','kasir','karyawan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'kasir',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `photo`, `phone`, `roles`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(7, 'Elias Sanford', 'ezequiel85@example.com', NULL, NULL, 'kasir', '2025-09-22 15:26:22', '$2y$12$z8DnnyGm2oSaiagKe6zMsOrj7gSsQj5e02syY.olyXi59jwFwniga', NULL, NULL, NULL, 'mvlOTh14E2', '2025-09-22 15:26:22', '2025-09-22 15:26:22'),
(8, 'Reyes Gutmann', 'guadalupe79@example.net', NULL, NULL, 'kasir', '2025-09-22 15:26:22', '$2y$12$z8DnnyGm2oSaiagKe6zMsOrj7gSsQj5e02syY.olyXi59jwFwniga', NULL, NULL, NULL, '2Zw41efgOJ', '2025-09-22 15:26:22', '2025-09-22 15:26:22'),
(9, 'Gaston Jacobs', 'janiya67@example.org', NULL, NULL, 'kasir', '2025-09-22 15:26:22', '$2y$12$z8DnnyGm2oSaiagKe6zMsOrj7gSsQj5e02syY.olyXi59jwFwniga', NULL, NULL, NULL, '7ZzjvD1cGU', '2025-09-22 15:26:22', '2025-09-22 15:26:22'),
(11, 'Wahyu', 'wahyu@gmail.com', NULL, '987987979777', 'admin', '2025-09-22 15:26:22', '$2y$12$w79kaYkxchmziTJCy/9y/OZgc8Ivw4A9DposqQIwXmIydMiuA6BNi', NULL, NULL, NULL, 'vjgPhL3gD1tXrT4n5Q0jT8CnaNXRRclNg4cSDiY7EHIG4p2crlt8Ayy0VENM', '2025-09-22 15:26:22', '2025-09-23 10:16:30'),
(12, 'YDK', 'yayan1234@gmail.com', NULL, '0754654654', 'karyawan', NULL, '$2y$12$DsBRggGaRunjFgKc4mezf.n/7G5JI8V3EASoJeZfdBdf9JdPEVBX6', NULL, NULL, NULL, NULL, '2026-01-15 17:22:20', '2026-01-15 17:22:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_us`
--
ALTER TABLE `about_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_slug_unique` (`slug`);

--
-- Indexes for table `article_images`
--
ALTER TABLE `article_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_images_article_id_foreign` (`article_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cart_items_customer_id_foreign` (`customer_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_article_id_foreign` (`article_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

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
  ADD KEY `galleries_category_id_foreign` (`category_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `navigation_menus_slug_index` (`slug`),
  ADD KEY `navigation_menus_parent_id_index` (`parent_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customer_id_foreign` (`customer_id`),
  ADD KEY `orders_status_id_foreign` (`status_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `order_item_options`
--
ALTER TABLE `order_item_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_options_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `order_item_processes`
--
ALTER TABLE `order_item_processes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_processes_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `order_item_process_logs`
--
ALTER TABLE `order_item_process_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_item_process_logs_order_item_id_foreign` (`order_item_id`),
  ADD KEY `order_item_process_logs_production_process_id_foreign` (`production_process_id`);

--
-- Indexes for table `order_statuses`
--
ALTER TABLE `order_statuses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_statuses_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `production_processes`
--
ALTER TABLE `production_processes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_options_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_option_values_product_option_id_foreign` (`product_option_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_article_id_foreign` (`article_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
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
-- AUTO_INCREMENT for table `about_us`
--
ALTER TABLE `about_us`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `article_images`
--
ALTER TABLE `article_images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `navigation_menus`
--
ALTER TABLE `navigation_menus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `order_item_options`
--
ALTER TABLE `order_item_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `order_item_processes`
--
ALTER TABLE `order_item_processes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_item_process_logs`
--
ALTER TABLE `order_item_process_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_statuses`
--
ALTER TABLE `order_statuses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_processes`
--
ALTER TABLE `production_processes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_option_values`
--
ALTER TABLE `product_option_values`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `article_images`
--
ALTER TABLE `article_images`
  ADD CONSTRAINT `article_images_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `galleries`
--
ALTER TABLE `galleries`
  ADD CONSTRAINT `galleries_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `order_statuses` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `order_item_options`
--
ALTER TABLE `order_item_options`
  ADD CONSTRAINT `order_item_options_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item_processes`
--
ALTER TABLE `order_item_processes`
  ADD CONSTRAINT `order_item_processes_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_item_process_logs`
--
ALTER TABLE `order_item_process_logs`
  ADD CONSTRAINT `order_item_process_logs_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_process_logs_production_process_id_foreign` FOREIGN KEY (`production_process_id`) REFERENCES `production_processes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_options`
--
ALTER TABLE `product_options`
  ADD CONSTRAINT `product_options_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD CONSTRAINT `product_option_values_product_option_id_foreign` FOREIGN KEY (`product_option_id`) REFERENCES `product_options` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
