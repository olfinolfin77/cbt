-- phpMyAdmin SQL Dump
-- version 2.11.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Waktu pembuatan: 01. September 2013 jam 15:48
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
(11, 'Ujicoba', 'e10adc3949ba59abbe56e057f20f883e', 'coba', '', '', 'Admin IT'),
(12, 'Billy', 'e10adc3949ba59abbe56e057f20f883e', 'Anastasius', '', '', 'Admin IT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grade`
--

CREATE TABLE `grade` (
  `id_grade` int(11) NOT NULL auto_increment,
  `id_jurusan` int(11) default NULL,
  `batas_grade` int(11) NOT NULL,
  PRIMARY KEY  (`id_grade`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `grade`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `jawaban`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL auto_increment,
  `nama_jurusan` varchar(30) NOT NULL,
  PRIMARY KEY  (`id_jurusan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `jurusan`
--


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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `kategori`
--


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


-- --------------------------------------------------------

--
-- Struktur dari tabel `pilihan_jurusan`
--

CREATE TABLE `pilihan_jurusan` (
  `no_peserta` varchar(10) default NULL,
  `id_jurusan` int(11) default NULL,
  `lulus` tinyint(1) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pilihan_jurusan`
--


-- --------------------------------------------------------

--
-- Struktur dari tabel `soal`
--

CREATE TABLE `soal` (
  `id_soal` int(11) NOT NULL auto_increment,
  `id_kategori` int(11) default NULL,
  `isi_soal` text NOT NULL,
  PRIMARY KEY  (`id_soal`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data untuk tabel `soal`
--

