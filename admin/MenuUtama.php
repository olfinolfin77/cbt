<?php
session_start();
include './inc/Constant.php';
include 'inc/build_function.php';
require '../inc/config.php';

$master = $_GET['master'];
setTitle("Computer Based-Test");
//cek apakah user sudah login
if(!isset($_SESSION['username'])){
    header('location:'.BASE_URL);
    die("Anda belum login");//jika belum login jangan lanjut..
}

//cek level user
//if($_SESSION['role']!="Admin IT"){
//    header('Location:index.php?konfirmasi=1');
//echo mysql_error();//jika bukan admin jangan lanjut
//}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'inc/tampilan/head_menu_utama.php'; ?>

  <body>
     <?php include 'inc/tampilan/header.php'; ?>
      <?php
     switch ($master) {
         case 'user':
             include 'user/index.php';
             break;
         case 'peserta':
             include 'peserta/index.php';
             break;
         case 'soal':
             include 'soal/index.php';
             break;
         default:
             break;
     }
      ?>
      
      <?php include './inc/tampilan/footer.php';?>
  </body>
</html>
