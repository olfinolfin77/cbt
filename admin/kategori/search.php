<?php
require_once '../../inc/config.php';

$nama = $_POST['nama'];

$query = "SELECT * FROM kategori WHERE nama LIKE '%$nama%'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:index.php?halaman=1');
}
?>