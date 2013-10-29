<?php
session_start();
if(!isset ($_SESSION['username'])){
    echo 'Anda belum login';
    exit();
}
include '../inc/Constant.php';
require '../../inc/config.php';
include '../model/object.php';
include '../inc/build_function.php';

$type = $_POST['type'];
$proses = $_POST['proses'];
$json = $_POST['json'];

if($type==null || $type=='' || $proses==null || $proses=='' || $json==null || $json==''){
    echo json_encode(new Result('0','Parameter tidak lengkap'));
    exit();
}

switch ($type) {
    case 'user':
        $result = userDAO($proses, $json);
        break;
    case 'peserta':
        $result = pesertaDAO($proses, $json);
        break;
    case 'soal':
        $result = soalDAO($proses, $json);
        break;
    case 'jurusan':
        $result = jurusanDAO($proses, $json);
        break;
    case 'kategori':
        $result = kategoriDAO($proses, $json);
        break;
    default:
        $result = json_encode(new Result('0',"Parameter $type not found"));
        break;
}
//$result = tambah_user($json);
echo $result;
//echo stripslashes($json);
//$obj = json_decode(stripslashes($json));
//echo $obj->{'username'};
//echo $type.' '.$proses.' g'.$json;
?>
