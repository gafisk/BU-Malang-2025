-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 10, 2025 at 07:27 PM
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
-- Database: `db_bumalang`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota_divisi`
--

CREATE TABLE `anggota_divisi` (
  `id_anggota_divisi` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `nama_anggota` varchar(255) NOT NULL,
  `univ_anggota` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` enum('Ketua','Wake1','Wake2','Sekretaris','Bendahara','Koordinator','Anggota') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `isi_berita` longtext NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `berita`
--

INSERT INTO `berita` (`id_berita`, `waktu`, `judul_berita`, `isi_berita`, `gambar`) VALUES
(5, '2025-02-07 22:25:35', 'Gold Medal Aulia', '\"Selamat dan Terima Kasih, Aulia!\r\nSebagai Sang Juara Riset, dedikasi dan ketekunanmu telah menjadi nyawa bagi setiap inovasi tim. Layaknya peneliti ulung, kau tak hanya mencari jawaban, tapi merajut solusi dari setiap tantangan.\r\n\r\nKau adalah pemantik ide-ide brilian yang mengubah data menjadi strategi,\r\nPenyambung lorong antara teori dan aksi,\r\nSerta kapten yang selalu memastikan kapal riset kami berlayar di jalur tepat.\r\n\r\nTerima kasih untuk:\r\n🔬 Ratusan jam analisa data yang tak kenal lelah\r\n📊 Presisi dalam setiap interpretasi temuan\r\n💡 Kreativitas merancang metodologi unik\r\n🤝 Kerja samamu yang menyatukan tim layaknya puzzle sempurna\r\n\r\nKau buktikan bahwa riset bukan sekadar angka di spreadsheet,\r\nTapi senjata strategis untuk kemajuan tim!\r\n\r\nTeruslah menjadi mercusuar pengetahuan kami, Aulia!\r\nTim Riset tak akan sama tanpamu.\"', '1738941935.jpg'),
(9, '2025-02-08 06:52:10', 'untuk mengelola berita coyy', 'testingdds', '1738972131.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `id_divisi` int(11) NOT NULL,
  `nama_divisi` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`id_divisi`, `nama_divisi`) VALUES
(1, 'BPHI'),
(2, 'Riset & Keilmuan'),
(3, 'Internal & Advokasi'),
(4, 'Minat & Bakat'),
(5, 'Hubungan Luar'),
(6, 'Komunikasi, Media & Desain'),
(7, 'Kewirausahaan'),
(8, 'Kesekretariatan');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id_event` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `jenis` enum('Daring','Luring') NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `tanggal_event` datetime NOT NULL,
  `pemateri` varchar(255) NOT NULL,
  `lokasi` longtext NOT NULL,
  `link_pendaftaran` longtext NOT NULL,
  `link_meet` longtext NOT NULL,
  `isi_berita` longtext NOT NULL,
  `narahubung` varchar(255) NOT NULL,
  `status` enum('Upcoming','Completed','Canceled') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id_event`, `waktu`, `jenis`, `nama_event`, `tanggal_event`, `pemateri`, `lokasi`, `link_pendaftaran`, `link_meet`, `isi_berita`, `narahubung`, `status`) VALUES
(3, '2025-02-09 20:53:45', 'Daring', 'Kumpul Ngopi dimana saja', '2025-02-09 19:51:00', 'Galih Restu Baihaqi', 'CW jalan Jakartas', '-', '-', 'Nanti kita akan bahas nabi nabi boy', '081939301705', 'Upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `footer`
--

CREATE TABLE `footer` (
  `id_footer` int(11) NOT NULL,
  `alamat_bu` varchar(255) NOT NULL,
  `nomor_bu` varchar(255) NOT NULL,
  `email_bu` varchar(255) NOT NULL,
  `youtube_bu` varchar(255) NOT NULL,
  `ig_bu` varchar(255) NOT NULL,
  `linkedin_bu` varchar(255) NOT NULL,
  `pengembang_bu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `footer`
--

INSERT INTO `footer` (`id_footer`, `alamat_bu`, `nomor_bu`, `email_bu`, `youtube_bu`, `ig_bu`, `linkedin_bu`, `pengembang_bu`) VALUES
(1, 'CW Jalan Jakartas', '082139283268', 'malang.bu2@gmail.com', 'https://www.youtube.com/@ForumAwardeeBUMalangRaya', 'https://www.instagram.com/bu.malang/', 'https://www.linkedin.com/company/beasiswa-unggulan-malang/', '6281939301705');

-- --------------------------------------------------------

--
-- Table structure for table `kampus_awardee`
--

CREATE TABLE `kampus_awardee` (
  `id_kampus_awardee` int(11) NOT NULL,
  `nama_kampus` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kampus_awardee`
--

INSERT INTO `kampus_awardee` (`id_kampus_awardee`, `nama_kampus`, `gambar`) VALUES
(1, 'Universitas Brawijaya', '1739171371.png'),
(2, 'Universitas Negeri Malang', '1739171898.png'),
(4, 'Universitas Muhammadiyah Malang', '1739172094.png'),
(5, 'Universitas Islam Malang', '1739172187.png'),
(6, 'Universitas PGRI Kanjuruhan Malang', '1739172198.png'),
(7, 'Universitas Merdeka Malang', '1739172279.png'),
(9, 'Universitas Terbuka Malang', '1739172407.png'),
(10, 'Politeknik Negeri Malang', '1739172457.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `lap_keuangan`
--

CREATE TABLE `lap_keuangan` (
  `id_lap_keuangan` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `kabinet` varchar(255) NOT NULL,
  `tahun` char(20) NOT NULL,
  `link` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lap_keuangan`
--

INSERT INTO `lap_keuangan` (`id_lap_keuangan`, `waktu`, `kabinet`, `tahun`, `link`) VALUES
(1, '2025-02-10 12:10:33', 'Praba Swara', '2025', 'https://drive.google.com/file/d/1iUTH5KfHEep1hDfIo96NWzj3L00dDWl3/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `lap_pertanggungjawaban`
--

CREATE TABLE `lap_pertanggungjawaban` (
  `id_lap_pertanggungjawaban` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `kabinet` varchar(255) NOT NULL,
  `tahun` char(20) NOT NULL,
  `link` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lap_pertanggungjawaban`
--

INSERT INTO `lap_pertanggungjawaban` (`id_lap_pertanggungjawaban`, `waktu`, `kabinet`, `tahun`, `link`) VALUES
(2, '2025-02-11 00:59:27', 'Praba Swara', '2025', 'https://drive.google.com/file/d/1iUTH5KfHEep1hDfIo96NWzj3L00dDWl3/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `pelaporan`
--

CREATE TABLE `pelaporan` (
  `id_pelaporan` int(11) NOT NULL,
  `link_alumni` longtext NOT NULL,
  `link_prestasi` longtext NOT NULL,
  `link_adart` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelaporan`
--

INSERT INTO `pelaporan` (`id_pelaporan`, `link_alumni`, `link_prestasi`, `link_adart`) VALUES
(1, 'https://drive.google.com/file/d/1iUTH5KfHEep1hDfIo96NWzj3L00dDWl3/view?usp=sharing', 'https://drive.google.com/file/d/1iUTH5KfHEep1hDfIo96NWzj3L00dDWl3/view?usp=sharing', 'https://drive.google.com/file/d/1iUTH5KfHEep1hDfIo96NWzj3L00dDWl3/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `pel_awardee`
--

CREATE TABLE `pel_awardee` (
  `id_pel_awardee` int(11) NOT NULL,
  `waktu` date NOT NULL,
  `tahun_awardee` char(20) NOT NULL,
  `batas_pelaporan` datetime NOT NULL,
  `link` longtext NOT NULL,
  `narahubung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pel_awardee`
--

INSERT INTO `pel_awardee` (`id_pel_awardee`, `waktu`, `tahun_awardee`, `batas_pelaporan`, `link`, `narahubung`) VALUES
(1, '2025-02-10', '2024', '2025-02-12 18:58:00', 'https://kursorjournal.org/index.php/kursor/article/view/351', '08193930170521');

-- --------------------------------------------------------

--
-- Table structure for table `prestasi`
--

CREATE TABLE `prestasi` (
  `id_prestasi` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `nama_prestasi` varchar(255) NOT NULL,
  `tingkat_prestasi` varchar(255) NOT NULL,
  `nama_peraih` varchar(255) NOT NULL,
  `asal_univ` varchar(255) NOT NULL,
  `tahun_awardee` char(10) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prestasi`
--

INSERT INTO `prestasi` (`id_prestasi`, `waktu`, `nama_prestasi`, `tingkat_prestasi`, `nama_peraih`, `asal_univ`, `tahun_awardee`, `gambar`) VALUES
(2, '2025-02-10 19:50:00', 'Gold Medal ASEIC', 'Internasional', 'Aulias', 'Universitas Negeri Malang', '2024', '1739077151.jpg'),
(3, '2025-02-10 19:56:26', 'Juara 1 Tartil Al-Quran', 'Internasional', 'Galih Restu Baihaqi', 'Universitas Brawijaya', '2023', '1739192186.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `proker`
--

CREATE TABLE `proker` (
  `id_proker` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `kabinet` varchar(255) NOT NULL,
  `tahun` char(20) NOT NULL,
  `link` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proker`
--

INSERT INTO `proker` (`id_proker`, `waktu`, `kabinet`, `tahun`, `link`) VALUES
(4, '2025-02-11 00:23:26', 'Praba Swara', '2025', 'https://drive.google.com/file/d/1iUTH5KfHEep1hDfIo96NWzj3L00dDWl3/view?usp=sharing');

-- --------------------------------------------------------

--
-- Table structure for table `publikasi`
--

CREATE TABLE `publikasi` (
  `id_publikasi` int(11) NOT NULL,
  `waktu` datetime NOT NULL,
  `judul_publikasi` varchar(255) NOT NULL,
  `kategori_publikasi` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `asal_univ` varchar(255) NOT NULL,
  `tahun_awardee` varchar(255) NOT NULL,
  `link` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publikasi`
--

INSERT INTO `publikasi` (`id_publikasi`, `waktu`, `judul_publikasi`, `kategori_publikasi`, `penulis`, `asal_univ`, `tahun_awardee`, `link`) VALUES
(1, '2025-02-09 18:07:36', 'LONG SHORT-TERM MEMORY FOR PREDICTION OF WAVE HEIGHT AND WIND SPEED USING PROPHET FOR OUTLIERS', 'Ilmu Komputers', 'Galih Restu Baihaqi', 'Universitas Brawijaya', '2023', 'https://kursorjournal.org/index.php/kursor/article/view/351');

-- --------------------------------------------------------

--
-- Table structure for table `stats_awardee`
--

CREATE TABLE `stats_awardee` (
  `id_stats` int(11) NOT NULL,
  `keterangan` char(20) NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stats_awardee`
--

INSERT INTO `stats_awardee` (`id_stats`, `keterangan`, `jumlah`) VALUES
(1, 'Sarjana', 234),
(2, 'Magister', 142),
(3, 'Doktor', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota_divisi`
--
ALTER TABLE `anggota_divisi`
  ADD PRIMARY KEY (`id_anggota_divisi`),
  ADD KEY `id_divisi` (`id_divisi`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id_event`);

--
-- Indexes for table `footer`
--
ALTER TABLE `footer`
  ADD PRIMARY KEY (`id_footer`);

--
-- Indexes for table `kampus_awardee`
--
ALTER TABLE `kampus_awardee`
  ADD PRIMARY KEY (`id_kampus_awardee`);

--
-- Indexes for table `lap_keuangan`
--
ALTER TABLE `lap_keuangan`
  ADD PRIMARY KEY (`id_lap_keuangan`);

--
-- Indexes for table `lap_pertanggungjawaban`
--
ALTER TABLE `lap_pertanggungjawaban`
  ADD PRIMARY KEY (`id_lap_pertanggungjawaban`);

--
-- Indexes for table `pelaporan`
--
ALTER TABLE `pelaporan`
  ADD PRIMARY KEY (`id_pelaporan`);

--
-- Indexes for table `pel_awardee`
--
ALTER TABLE `pel_awardee`
  ADD PRIMARY KEY (`id_pel_awardee`);

--
-- Indexes for table `prestasi`
--
ALTER TABLE `prestasi`
  ADD PRIMARY KEY (`id_prestasi`);

--
-- Indexes for table `proker`
--
ALTER TABLE `proker`
  ADD PRIMARY KEY (`id_proker`);

--
-- Indexes for table `publikasi`
--
ALTER TABLE `publikasi`
  ADD PRIMARY KEY (`id_publikasi`);

--
-- Indexes for table `stats_awardee`
--
ALTER TABLE `stats_awardee`
  ADD PRIMARY KEY (`id_stats`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota_divisi`
--
ALTER TABLE `anggota_divisi`
  MODIFY `id_anggota_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `divisi`
--
ALTER TABLE `divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `footer`
--
ALTER TABLE `footer`
  MODIFY `id_footer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kampus_awardee`
--
ALTER TABLE `kampus_awardee`
  MODIFY `id_kampus_awardee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `lap_keuangan`
--
ALTER TABLE `lap_keuangan`
  MODIFY `id_lap_keuangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lap_pertanggungjawaban`
--
ALTER TABLE `lap_pertanggungjawaban`
  MODIFY `id_lap_pertanggungjawaban` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelaporan`
--
ALTER TABLE `pelaporan`
  MODIFY `id_pelaporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pel_awardee`
--
ALTER TABLE `pel_awardee`
  MODIFY `id_pel_awardee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `prestasi`
--
ALTER TABLE `prestasi`
  MODIFY `id_prestasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `proker`
--
ALTER TABLE `proker`
  MODIFY `id_proker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `publikasi`
--
ALTER TABLE `publikasi`
  MODIFY `id_publikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stats_awardee`
--
ALTER TABLE `stats_awardee`
  MODIFY `id_stats` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota_divisi`
--
ALTER TABLE `anggota_divisi`
  ADD CONSTRAINT `anggota_divisi_ibfk_1` FOREIGN KEY (`id_divisi`) REFERENCES `divisi` (`id_divisi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
