<a href="ubah.php">ubah</a><?php

require_once '../../inc/config.php';

$id_kategori = $_POST['id_kategori'];
$nama = $_POST['nama'];

$query = "UPDATE kategori SET nama='$nama'
		WHERE id_kategori='$id_kategori'";
$result = mysql_query($query) or die(mysql_error());

mysql_close();

if ($result > 0) {
	header('Location:index.php?halaman=1');
} else {
	header('Location:update.php');
}
?>