<?php

require_once '../../inc/config.php';

$id_soal = $_POST['id_soal'];
$id_kategori = $_POST['id_kategori'];
$pertanyaan = $_POST ['pertanyaan'];
$pilihan_a = $_POST['pilihan_a'];
$pilihan_b = $_POST['pilihan_b'];
$pilihan_c = $_POST['pilihan_c'];
$pilihan_d = $_POST['pilihan_d'];
$jawaban = $_POST['jawaban'];

$query = "UPDATE soal SET id_kategori='$id_kategori',pertanyaan='$pertanyaan',pilihan_a='$pilihan_a'
    ,pilihan_b='$pilihan_b',pilihan_c='$pilihan_c',pilihan_d='$pilihan_d',jawaban='$jawaban' WHERE id_soal='$id_soal'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:index.php?halaman=1');
} else {
	header('Location:update.php');
}
?>