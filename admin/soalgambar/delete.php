<?php
require_once '../../inc/config.php';

$id_soal = $_GET['id_soal'];

$query = "DELETE FROM soal WHERE id_soal='$id_soal'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();
header('Location:index.php?halaman=1');
?>