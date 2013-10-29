<?php
require_once '../../inc/config.php';

$username = $_POST['username'];

$query = "SELECT * FROM admin WHERE username LIKE '%$username%'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:index.php?halaman=1');
}
?>