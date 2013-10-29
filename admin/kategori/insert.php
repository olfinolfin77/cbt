<?php
require_once '../../inc/config.php';
//MENANGKAP VARIABLE FIELD DITABLE YANG DIKIRIM DENGAN METHODE POST
$id_kategori = $_POST['id_kategori'];
$nama = $_POST['nama'];
$query_validasi = "SELECT * FROM kategori WHERE id_kategori='".$id_kategori."'";
$result_validasi = mysql_query($query_validasi);

$query_validasi_final = mysql_fetch_array($result_validasi);
echo $query_validasi_final['id_kategori'];

if ($query_validasi_final['id_kategori']!="") {
echo "<script>alert('Data sudah ada!');
		location.href='tambah.php';
		</script>";
		
} else if ($query_validasi_final['id_kategori']=="") {

$query = "INSERT INTO kategori
(nama) VALUES('".$nama."')";
$result = mysql_query($query);
header('Location:index.php?halaman=1');
}
?>