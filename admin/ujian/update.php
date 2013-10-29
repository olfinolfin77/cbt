<?php

require_once '../../inc/config.php';

$id_ujian = $_POST['id_ujian'];
$id_kategori = $_POST['id_kategori'];
$waktu = $_POST['waktu'];
$keterangan = $_POST['keterangan'];

$query = "UPDATE ujian SET id_kategori='$id_kategori',waktu='$waktu',
    keterangan='$keterangan' WHERE id_ujian='$id_ujian'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:index.php?halaman=1');
} else {
	header('Location:update.php');
}
?>