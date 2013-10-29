<?php

require_once '../../inc/config.php';

$id_grade = $_POST['id_grade'];
$jurusan= $_POST['jurusan'];
$batas_verbal = $_POST['batas_verbal'];
$batas_numerik = $_POST['batas_numerik'];
$batas_logika = $_POST['batas_logika'];
$batas_gambar = $_POST['batas_gambar'];

$query = "UPDATE grade_lulus SET jurusan='$jurusan',batas_verbal='$batas_verbal'
    ,batas_numerik='$batas_numerik',batas_logika='$batas_logika',batas_gambar='$batas_gambar' WHERE id_grade='$id_grade'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:form_update.php?konfirmasi=1');
} else {
	header('Location:update.php');
}
?>