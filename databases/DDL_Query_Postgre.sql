CREATE TABLE admin (
  id_admin serial NOT NULL primary key,
  username varchar(100) default NULL,
  password varchar(100) default NULL,
  nama varchar(100) default NULL,
  telepon varchar(100) default NULL,
  alamat varchar(250) default NULL,
  role varchar(100) default NULL
)

INSERT INTO admin (id_admin, username, password, nama, telepon, alamat, role) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '082330159608', 'Surabaya Nginden 6c no 14', 'Admin IT'),
(10, 'Willy', 'e10adc3949ba59abbe56e057f20f883e', 'Yosua Willy Handika', '1234', 'Sedati', 'Admin IT'),
(12, 'Billy', 'e10adc3949ba59abbe56e057f20f883e', 'Anastasius', '', '', 'Operator');

CREATE TABLE grade (
  id_grade serial NOT NULL primary key,
  id_jurusan int default NULL,
  batas_grade int NOT NULL
)

INSERT INTO grade (id_grade, id_jurusan, batas_grade) VALUES
(3, 1, 68),
(4, 2, 80);

CREATE TABLE jawaban (
  id_jawaban serial NOT NULL primary key,
  id_soal int default NULL,
  jawaban text NOT NULL,
  benar boolean
)

INSERT INTO jawaban (id_jawaban, id_soal, jawaban, benar) VALUES
(1, 1, 'Komputer', true),
(2, 1, 'Laptop', false),
(3, 1, 'Flashdisk', false),
(4, 1, 'RAM', false),
(5, 2, 'Android', false),
(6, 2, 'Windows Phone', true),
(7, 2, 'Blackberry', false),
(8, 2, 'IPhone', false),
(9, 3, 'Java', true),
(10, 3, 'C#', false),
(11, 3, 'PHP', false),
(12, 3, 'C++', false),
(13, 4, '4', false),
(14, 4, '5', false),
(15, 4, '6', false),
(16, 4, '2', true),
(17, 5, '14', false),
(18, 5, '15', false),
(19, 5, '16', true),
(20, 5, '17', false),
(21, 6, '7', false),
(22, 6, '4', true),
(23, 6, '5', false),
(24, 6, '6', false),
(25, 7, '3', false),
(26, 7, '4', false),
(27, 7, '8', true),
(28, 7, '5', false),
(29, 8, '120', true),
(30, 8, '121', false),
(31, 8, '122', false),
(32, 8, '125', false),
(33, 9, '3', false),
(34, 9, '5', false),
(35, 9, '8', true),
(36, 9, '10', false),
(37, 10, '64', true),
(38, 10, '65', false),
(39, 10, '66', false),
(40, 10, '67', false),
(41, 11, '124', false),
(42, 11, '125', true),
(43, 11, '126', false),
(44, 11, '127', false),
(45, 12, '27', true),
(46, 12, '28', false),
(47, 12, '29', false),
(48, 12, '30', false),
(49, 13, '4', false),
(50, 13, '3', false),
(51, 13, '1', true),
(52, 13, '2', false),
(53, 14, '6', true),
(54, 14, '7', false),
(55, 14, '8', false),
(56, 14, '9', false);

CREATE TABLE jurusan (
  id_jurusan serial NOT NULL primary key,
  nama_jurusan varchar(30) NOT NULL,
  daya_tampung int NOT NULL
)

INSERT INTO jurusan (id_jurusan, nama_jurusan, daya_tampung) VALUES
(1, 'Teknik Informatika', 6),
(2, 'Teknik Sipil', 10);

CREATE TABLE kategori (
  id_kategori serial NOT NULL primary key,
  nama_kategori varchar(30) NOT NULL,
  waktu int NOT NULL,
  jumlah_soal int NOT NULL
)

INSERT INTO kategori (id_kategori, nama_kategori, waktu, jumlah_soal) VALUES
(1, 'Gambar', 10, 10),
(2, 'Numerik', 10, 10);

CREATE TABLE nilai_per_kategori (
  no_peserta varchar(10) default NULL,
  id_kategori int default NULL,
  nilai int default NULL
)

INSERT INTO nilai_per_kategori (no_peserta, id_kategori, nilai) VALUES
('2009420005', 1, 100),
('2009420005', 2, 50),
('2009420002', 1, 0),
('2009420002', 2, 50),
('2009420001', 1, 100),
('2009420001', 2, 80),
('2009420054', 1, 100),
('2009420054', 2, 70);

CREATE TABLE peserta (
  no_peserta varchar(10) NOT NULL primary key,
  nama varchar(50) NOT NULL,
  alamat text,
  telepon varchar(20) default NULL,
  nilai int default NULL,
  keterangan text
)

INSERT INTO peserta (no_peserta, nama, alamat, telepon, nilai, keterangan) VALUES
('2009420001', 'Thory', 'Lamongan', '012398823', 90, ''),
('2009420002', 'Yosua Willy Handika', 'Sedati', '085746537164', 25, ''),
('2009420003', 'Lukman', 'Kenjeran', '0832631263', 62, ''),
('2009420004', 'Agung', 'Lamongan', '082317378123', 78, ''),
('2009420005', 'Lukman2', 'Surabaya', '02312387231', 75, ''),
('2009420054', 'Anastasius Billy', 'Sedati', '085723812387', 85, '');

CREATE TABLE pilihan_jurusan (
  no_peserta varchar(10) default NULL,
  id_jurusan int default NULL
)

INSERT INTO pilihan_jurusan (no_peserta, id_jurusan) VALUES
('2009420002', 1),
('2009420002', 2),
('2009420054', 1),
('2009420001', 1),
('2009420003', 1),
('2009420004', 1),
('2009420004', 2),
('2009420005', 1),
('2009420005', 2);

CREATE TABLE soal (
  id_soal serial NOT NULL primary key,
  id_kategori int default NULL,
  isi_soal text NOT NULL
)

INSERT INTO soal (id_soal, id_kategori, isi_soal) VALUES
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
