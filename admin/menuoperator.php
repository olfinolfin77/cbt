<?php
session_start();

//cek apakah user sudah login
if(!isset($_SESSION['username'])){
    die("Anda belum login");//jika belum login jangan lanjut..
}

//cek level user
if($_SESSION['role']!="Operator"){
    header('Location:index.php?konfirmasi=1');
echo mysql_error();//jika bukan admin jangan lanjut
}
?>
