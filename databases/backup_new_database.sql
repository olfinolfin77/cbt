-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 24. Desember 2013 jam 21:22
-- Versi Server: 5.0.45
-- Versi PHP: 5.2.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `cbt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` bigint(20) NOT NULL auto_increment,
  `username` varchar(100) default NULL,
  `password` varchar(100) default NULL,
  `nama` varchar(100) default NULL,
  `telepon` varchar(100) default NULL,
  `alamat` varchar(250) default NULL,
  `role` varchar(100) default NULL,
  PRIMARY KEY  (`id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama`, `telepon`, `alamat`, `role`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '082330159608', 'Surabaya Nginden 6c no 14', 'Admin IT'),
(10, 'Willy', 'e10adc3949ba59abbe56e057f20f883e', 'Yosua Willy Handika', '1234', 'Sedati', 'Admin IT'),
(12, 'Billy', 'e10adc3949ba59abbe56e057f20f883e', 'Anastasius', '', '', 'Operator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grade`
--

CREATE TABLE `grade` (
  `id_grade` int(11) NOT NULL auto_increment,
  `id_jurusan` int(11) default NULL,
  `batas_grade` int(11) NOT NULL,
  PRIMARY KEY  (`id_grade`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data untuk tabel `grade`
--

INSERT INTO `grade` (`id_grade`, `id_jurusan`, `batas_grade`) VALUES
(3, 1, 68),
(4, 2, 80);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jawaban`
--

CREATE TABLE `jawaban` (
  `id_jawaban` int(11) NOT NULL auto_increment,
  `id_soal` int(11) default NULL,
  `jawaban` text NOT NULL,
  `benar` tinyint(1) default NULL,
  PRIMARY KEY  (`id_jawaban`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data untuk tabel `jawaban`
--

INSERT INTO `jawaban` (`id_jawaban`, `id_soal`, `jawaban`, `benar`) VALUES
(1, 1, 'Komputer', 1),
(2, 1, 'Laptop', 0),
(3, 1, 'Flashdisk', 0),
(4, 1, 'RAM', 0),
(5, 2, 'Android', 0),
(6, 2, 'Windows Phone', 1),
(7, 2, 'Blackberry', 0),
(8, 2, 'IPhone', 0),
(9, 3, 'Java', 1),
(10, 3, 'C#', 0),
(11, 3, 'PHP', 0),
(12, 3, 'C++', 0),
(13, 4, '4', 0),
(14, 4, '5', 0),
(15, 4, '6', 0),
(16, 4, '2', 1),
(17, 5, '14', 0),
(18, 5, '15', 0),
(19, 5, '16', 1),
(20, 5, '17', 0),
(21, 6, '7', 0),
(22, 6, '4', 1),
(23, 6, '5', 0),
(24, 6, '6', 0),
(25, 7, '3', 0),
(26, 7, '4', 0),
(27, 7, '8', 1),
(28, 7, '5', 0),
(29, 8, '120', 1),
(30, 8, '121', 0),
(31, 8, '122', 0),
(32, 8, '125', 0),
(33, 9, '3', 0),
(34, 9, '5', 0),
(35, 9, '8', 1),
(36, 9, '10', 0),
(37, 10, '64', 1),
(38, 10, '65', 0),
(39, 10, '66', 0),
(40, 10, '67', 0),
(41, 11, '124', 0),
(42, 11, '125', 1),
(43, 11, '126', 0),
(44, 11, '127', 0),
(45, 12, '27', 1),
(46, 12, '28', 0),
(47, 12, '29', 0),
(48, 12, '30', 0),
(49, 13, '4', 0),
(50, 13, '3', 0),
(51, 13, '1', 1),
(52, 13, '2', 0),
(53, 14, '6', 1),
(54, 14, '7', 0),
(55, 14, '8', 0),
(56, 14, '9', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL auto_increment,
  `nama_jurusan` varchar(30) NOT NULL,
  `daya_tampung` int(11) NOT NULL,
  PRIMARY KEY  (`id_jurusan`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`, `daya_tampung`) VALUES
(1, 'Teknik Informatika', 6),
(2, 'Teknik Sipil', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL auto_increment,
  `nama_kategori` varchar(30) NOT NULL,
  `waktu` int(11) NOT NULL,
  `jumlah_soal` int(11) NOT NULL,
  PRIMARY KEY  (`id_kategori`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`, `waktu`, `jumlah_soal`) VALUES
(1, 'Gambar', 10, 10),
(2, 'Numerik', 10, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peserta`
--

CREATE TABLE `peserta` (
  `no_peserta` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` text,
  `telepon` varchar(20) default NULL,
  `nilai` int(11) default NULL,
  `keterangan` text,
  PRIMARY KEY  (`no_peserta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peserta`
--

INSERT INTO `peserta` (`no_peserta`, `nama`, `alamat`, `telepon`, `nilai`, `keterangan`) VALUES
('2009420001', 'Thory', 'Lamongan', '012398823', 70, ''),
('2009420002', 'Yosua Willy Handika', 'Sedati', '085746537164', 67, ''),
('2009420003', 'Lukman', 'Kenjeran', '0832631263', 62, ''),
('2009420004', 'Agung', 'Lamongan', '082317378123', 78, ''),
('2009420054', 'Anastasius Billy', 'Sedati', '085723812387', 45, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihan_jurusan`
--

CREATE TABLE `pilihan_jurusan` (
  `no_peserta` varchar(10) default NULL,
  `id_jurusan` int(11) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pilihan_jurusan`
--

INSERT INTO `pilihan_jurusan` (`no_peserta`, `id_jurusan`) VALUES
('2009420002', 1),
('2009420002', 2),
('2009420054', 1),
('2009420001', 1),
('2009420003', 1),
('2009420004', 1),
('2009420004', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL auto_increment,
  `id_kategori` int(11) default NULL,
  `isi_soal` text NOT NULL,
  PRIMARY KEY  (`id_soal`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data untuk tabel `soal`
--

INSERT INTO `soal` (`id_soal`, `id_kategori`, `isi_soal`) VALUES
(1, 1, '<img src="/ujian online/cbt/fileImage/ubuntu.jpeg">Apa nama Gambar di bawah ini?'),
(2, 1, 'Gambar apakah ini?'),
(3, 1, 'Apa bahasa pemrograman yg berlogo seperti dibawah ini?'),
(4, 2, '1+1=?'),
(5, 2, '4x4=?'),
(6, 2, '20:5=?'),
(7, 2, '(3+3) + (4/2) = ?'),
(8, 2, '!5 = ?'),
(9, 2, '2x2x2 = ?'),
(10, 2, '4x4x4 = ?'),
(11, 2, '5x5x5 = ?'),
(12, 2, '3x3x3 = ?'),
(13, 2, '1x1x1 = ?'),
(14, 2, '1x2x3 = ?');
