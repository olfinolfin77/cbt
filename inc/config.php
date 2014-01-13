<?php
define('server', 'localhost');
define('username', 'postgres');
define('password', 'dwidasa');
define('database', 'cbt');
define('charset', 'utf8');
define('connection_str', 'host='.server.' port=5432 dbname='.database.' user='.username.' password='.password);

$connection_str = 'host='.server.' port=5432 dbname='.database.' user='.username.' password='.password;
$pg_sql = pg_connect($connection_str);
//$mysql = mysql_connect(server,username,password) or die(mysql_error());
//mysql_set_charset(charset, $mysql);
//mysql_select_db(database) or die(mysql_error());

function koneksi_buka() {
	mysql_select_db(database,mysql_connect(server,username,password));
}

// fungsi untuk menutup koneksi ke database mysql
function koneksi_tutup() {
	mysql_close(mysql_connect(server,username,password));
}
?>