<?php

require_once '../../inc/config.php';

$username = $_POST['username'];
$password= $_POST['password'];
$nama = $_POST['nama'];
$telepon = $_POST['telepon'];
$alamat = $_POST['alamat'];
$role = $_POST['role'];
$id_admin = $_POST['id_admin'];
$pass = md5($password);

$query = "UPDATE admin SET username='$username',password='$pass',nama='$nama',telepon='$telepon'
    ,alamat='$alamat',role='$role' WHERE id_admin='$id_admin'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:from_update.php?konfirmasi=1');
} else {
	header('Location:update.php');
}
?>