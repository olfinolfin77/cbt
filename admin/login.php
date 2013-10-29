<?php 
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include "../inc/config.php";
include './inc/Constant.php';
$username=$_POST['username'];
$password=  md5($_POST['password']);
$role = $_POST['role'];

if($username==null || $password==null || $role==null || $username=='' || $password=='' || $role==''){
    header('location:'.BASE_URL);
    exit();
}

$query=mysql_query("select * from admin where username='$username' and password='$password' and role= '$role' ");
//$query=mysql_query("select * from admin where username='$username' and password='$password' and role= 'Admin IT' ");
//$query2=mysql_query("select * from admin where username='$username' and password='$password' and role= 'Operator' ");
$cek=mysql_num_rows($query);
//$cek2=  mysql_num_rows($query2);
if($cek){
//    while ($row = mysql_fetch_array($query)) {
//        $_SESSION['id_admin']=$row['id_admin'];
//    }
    $_SESSION['username']=$username;
    $_SESSION['role']=$role;
    header('location:MenuUtama.php');
}
//elseif ($cek2) {
//    $_SESSION['username']=$username;
//    $_SESSION['role']=$role;
//    header('location:menuoperator.php');
//}
else{
    header('location:index.php?konfirmasi=1');
}
?>  