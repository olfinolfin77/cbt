<?php
require_once '../../inc/config.php';
//MENANGKAP VARIABLE FIELD DITABLE YANG DIKIRIM DENGAN METHODE POST
$username = $_POST['username'];
$password = $_POST ['password'];
$nama = $_POST['nama'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];
$role = $_POST['role'];
$pass = md5($password);

$query_validasi = "SELECT * FROM admin WHERE username='".$username."'";
$result_validasi = mysql_query($query_validasi);

$query_validasi_final = mysql_fetch_array($result_validasi);
echo $query_validasi_final['username'];

if ($query_validasi_final['username']!="") {
echo "<script>alert('Data sudah ada!');
		location.href='form_tambah.php';
		</script>";
		
} else if ($query_validasi_final['username']=="") {

$query = "INSERT INTO admin
(username,password,nama,telepon,alamat,role) VALUES('".$username."','".$pass."','".$nama."','".$telepon."','".$alamat."','".$role."')";
$result = mysql_query($query);
header('Location:form_tambah.php?konfirmasi=1');
}
?>