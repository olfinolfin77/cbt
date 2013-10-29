<?php
require_once '../../inc/config.php';
//MENANGKAP VARIABLE FIELD DITABLE YANG DIKIRIM DENGAN METHODE POST
$id_kategori = $_POST['id_kategori'];
$pertanyaan = $_POST ['pertanyaan'];
$pilihan_a = $_POST['pilihan_a'];
$pilihan_b = $_POST['pilihan_b'];
$pilihan_c = $_POST['pilihan_c'];
$pilihan_d = $_POST['pilihan_d'];
$jawaban = $_POST['jawaban'];

$query_validasi = "SELECT * FROM soal WHERE id_soal='".$id_soal."'";
$result_validasi = mysql_query($query_validasi);

$query_validasi_final = mysql_fetch_array($result_validasi);
echo $query_validasi_final['id_soal'];

if ($query_validasi_final['id_soal']!="") {
echo "<script>alert('Data sudah ada!');
		location.href='tambah.php';
		</script>";
		
} else if ($query_validasi_final['id_soal']=="") {

$query = "INSERT INTO soal
(id_kategori,pertanyaan,pilihan_a,pilihan_b,pilihan_c,pilihan_d,jawaban) VALUES('".$id_kategori."','".$pertanyaan."','".$pilihan_a."','".$pilihan_b."','".$pilihan_c."','".$pilihan_d."','".$jawaban."')";
$result = mysql_query($query);
header('Location:index.php?halaman=1');
}
?>