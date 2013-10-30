<?php
session_start();
include '../../admin/model/object.php';

$fileTemp = '../temp/temp_soal_'.$_SESSION['no_peserta'];

if(isset ($_POST['json'])){
    $json = $_POST['json'];
    $obj = json_decode(stripslashes($json));
    $no_peserta = $obj->{'no_peserta'};
    $id_kategori = $obj->{'id_kategori'};
    $id_soal = $obj->{'id_soal'};
    $id_jawaban = $obj->{'id_jawaban'};
    if($no_peserta==null || $id_kategori==null || $id_soal==null || $id_jawaban==null){
        echo json_encode(new Result('0',"Parameter tidak lengkap"));
        exit();
    }
    
    $dom = new DOMDocument("1.0");
    $dom->load($fileTemp);
    $xpath = new DOMXPath($dom);
    $soal = $xpath->query("//soal[@id_soal=\"$id_soal\" and @id_kategori = \"$id_kategori\"]")->item(0);
    $jawabans = $soal->getElementsByTagName('jawaban');
    foreach ($jawabans as $jawab) {
        $id_jawab = $jawab->getAttribute('id_jawaban');
        if(strpos($id_jawab, '.') === 0){
            $jawab->setAttribute('id_jawaban', substr($id_jawab, 1));
        }
        if(strpos($id_jawab, $id_jawaban) !== false){
            $jawab->setAttribute('id_jawaban', '.'.$id_jawaban);
        }
    }
    $dom->save($fileTemp);
    echo json_encode(new Result('1',"Sukses"));;
}
?>
