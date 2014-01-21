<?php

$fileTime = '../temp/temp_time_'.$_SESSION['no_peserta'];

if($current_kategori!==null)
if(!file_exists($fileTime)){
    $dom = new DOMDocument("1.0", "UTF-8");
    $time = $dom->createElement('time');
    $time->setAttribute('periods', $current_kategori->get_waktu() * 60);
    $dom->appendChild($time);
    $dom->save($fileTime);
    
    $periods = $current_kategori->get_waktu() * 60;
} else {
    $dom = new DOMDocument("1.0");
    $dom->load($fileTime);
    $times = $dom->getElementsByTagName('time');
    
    $periods = $times->item(0)->getAttribute('periods');
}
?>
