<?php
require_once '../../inc/config.php';

$jurusan = $_POST['jurusan'];

$query = "SELECT * FROM grade_lulus WHERE jurusan LIKE '%$jurusan%'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:index.php?halaman=1');
}
?>