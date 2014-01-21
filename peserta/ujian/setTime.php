<?php
session_start();
include '../../admin/model/object.php';

$fileTime = '../temp/temp_time_'.$_SESSION['no_peserta'];

if(isset ($_POST['json'])){
    $json = $_POST['json'];
    $obj = json_decode(stripslashes($json));
    $periods = $obj->{'periods'};
    
//    if($current_kategori!==null)
    if(!isset($_SESSION['kategori']))
    if(!file_exists($fileTime)){

        $dom = new DOMDocument("1.0", "UTF-8");
        $time = $dom->createElement('time');
        $time->setAttribute('periods', $periods);
        $dom->appendChild($time);
        $dom->save($fileTime);
        
        echo json_encode(new Result('1',"Sukses"));
    } else {
        $dom = new DOMDocument("1.0");
        $dom->load($fileTime);
        $times = $dom->getElementsByTagName('time');
        $times->item(0)->setAttribute('periods', $periods);
        $dom->save($fileTime);
        
        echo json_encode(new Result('1',"Sukses"));
    }
    else echo json_encode(new Result('0',"current_kategori null"));
    
} else {
    echo json_encode(new Result('0',"Parameter tidak lengkap"));
}

?>
