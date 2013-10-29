<?php
require_once '../../inc/config.php';

$id_admin = $_GET['id_admin'];

$query = "DELETE FROM admin WHERE id_admin='$id_admin'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();
header('Location:index.php?halaman=1');
?>