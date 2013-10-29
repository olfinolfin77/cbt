<?php
require_once '../../inc/config.php';

$id_ujian = $_GET['id_ujian'];

$query = "DELETE FROM ujian WHERE id_ujian='$id_ujian'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

header('Location:index.php?halaman=1');


?>