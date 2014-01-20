<?php

$fileTempCurrentSoal = '../temp/temp_current_soal_'.$_SESSION['no_peserta'];

if($current_kategori!==null)
if(!file_exists($fileTempCurrentSoal)){
    $dom = new DOMDocument("1.0", "UTF-8");
    $soal = $dom->createElement('soal');
    $soal->setAttribute('current_id', 0);
    $soal->setAttribute('jwb_benar', 0);
    $dom->appendChild($soal);
    $dom->save($fileTempCurrentSoal);
    $current_id_soal = 0;
} else {
    $dom = new DOMDocument("1.0");
    $dom->load($fileTempCurrentSoal);
    $soal = $dom->getElementsByTagName('soal');
    $current_id_soal = $soal->item(0)->getAttribute('current_id');
    
    if(isset($_SESSION['reset_id_soal'])){
        if($_SESSION['reset_id_soal']){
//            echo 'load_current';
            $soal->item(0)->setAttribute('current_id', 0);
            $soal->item(0)->setAttribute('jwb_benar', 0);
            $dom->save($fileTempCurrentSoal);
            unset($_SESSION['reset_id_soal']);
            $current_id_soal = 0;
        }
    }
}
?>
