<?php
require_once '../../inc/config.php';

$id_kategori = $_GET['id_kategori'];

$query = "DELETE FROM kategori WHERE id_kategori='$id_kategori'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

header('Location:index.php?halaman=1');


?>