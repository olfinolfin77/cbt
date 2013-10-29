<?php
require_once '../../inc/config.php';
//MENANGKAP VARIABLE FIELD DITABLE YANG DIKIRIM DENGAN METHODE POST
//$id_ujian = $_POST['id_ujian'];
$id_kategori = $_POST['id_kategori'];
$waktu = $_POST['waktu'];
$keterangan = $_POST['keterangan'];

$query_validasi = "SELECT * FROM ujian WHERE id_kategori='".$id_kategori."'";
$result_validasi = mysql_query($query_validasi);

$query_validasi_final = mysql_fetch_array($result_validasi);
echo $query_validasi_final['id_kategori'];

if ($query_validasi_final['id_kategori']!="") {
echo "<script>alert('Setting Ujian Kategori Sudah Ada !');
		location.href='form_tambah.php';
		</script>";
		
} else if ($query_validasi_final['id_kategori']=="") {

$query = "INSERT INTO ujian
(id_kategori,waktu,keterangan) 
VALUES('".$id_kategori."','".$waktu."',
    '".$keterangan."')";
$result = mysql_query($query);
header('Location:index.php?halaman=1');
}
?>