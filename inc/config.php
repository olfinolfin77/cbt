<?php
define('server', 'localhost');
define('username', 'root');
define('password', '');
define('database', 'cbt');
define('charset', 'utf8');

$mysql = mysql_connect(server,username,password) or die(mysql_error());
mysql_set_charset(charset, $mysql);
mysql_select_db(database) or die(mysql_error());

function koneksi_buka() {
	mysql_select_db(database,mysql_connect(server,username,password));
}

// fungsi untuk menutup koneksi ke database mysql
function koneksi_tutup() {
	mysql_close(mysql_connect(server,username,password));
}
?>