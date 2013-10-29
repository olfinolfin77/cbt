<?php
require_once '../../inc/config.php';
//MENANGKAP VARIABLE FIELD DITABLE YANG DIKIRIM DENGAN METHODE POST
$id_grade = $_POST['id_grade'];
$jurusan = $_POST['jurusan'];
$batas_verbal = $_POST['batas_verbal'];
$batas_numerik = $_POST['batas_numerik'];
$batas_logika = $_POST['batas_logika'];
$batas_gambar = $_POST['batas_gambar'];

$query_validasi = "SELECT * FROM grade_lulus WHERE id_grade='".$id_grade."'";
$result_validasi = mysql_query($query_validasi);

$query_validasi_final = mysql_fetch_array($result_validasi);
echo $query_validasi_final['id_grade'];

if ($query_validasi_final['id_grade']!="") {
echo "<script>alert('Data sudah ada!');
		location.href='tambah.php';
		</script>";

} else if ($query_validasi_final['id_grade']=="") {

$query = "INSERT INTO grade_lulus
(jurusan,batas_verbal,batas_numerik,batas_logika,batas_gambar) VALUES('".$jurusan."','".$batas_verbal."',
'".$batas_numerik."','".$batas_logika."','".$batas_gambar."')";
$result = mysql_query($query);
header('Location:form_tambah.php?konfirmasi=1');
}
?>