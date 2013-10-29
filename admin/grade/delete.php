<?php
require_once '../../inc/config.php';

$id_grade = $_GET['id_grade'];

$query = "DELETE FROM grade_lulus WHERE id_grade='$id_grade'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

header('Location:index.php?halaman=1?konfirmasi');


?>