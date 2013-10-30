<?php
$fileTemp = '../temp/temp_soal_'.$_SESSION['no_peserta'];

if($current_kategori!==null)
if(!file_exists($fileTemp)){
    $query = "select s.*,j.id_jawaban,j.jawaban,j.benar 
from soal s,jawaban j where s.id_soal=j.id_soal and s.id_kategori=$current_kategori->id_kategori";
    $result = mysql_query($query);
    $soals = array (); $current_id_soal = null;
    $jawabans = array(); $obj_jawaban; $idx_soal = 0; $idx_jwb = 0;
    $jum_row = mysql_num_rows($result); $hit_row = 0;
    while ($row = mysql_fetch_array($result)) {
        $id_soal = $row['id_soal'];
        if($current_id_soal!=$id_soal){
            $id_kategori = $row['id_kategori'];
            $isi_soal = $row['isi_soal'];
            $id_jawaban = $row['id_jawaban'];
            $jawaban = $row['jawaban'];
            $benar = $row['benar'];
            $soal = new Soal($id_soal, $id_kategori, $isi_soal, $jawabans);
            $soals[$idx_soal] = $soal;
            if($current_id_soal!=null){
                $soals[$idx_soal-1]->set_jawabans($jawabans);
            }
            $jawabans = array(); $idx_jwb = 0;
            $obj_jawaban = new Jawaban($id_jawaban, $id_soal, $jawaban, $benar);
            $jawabans[$idx_jwb] = $obj_jawaban;
            $current_id_soal = $id_soal;
            $idx_soal++;
        } else {
            $id_jawaban = $row['id_jawaban'];
            $jawaban = $row['jawaban'];
            $benar = $row['benar'];
            $obj_jawaban = new Jawaban($id_jawaban, $id_soal, $jawaban, $benar);
            $jawabans[$idx_jwb] = $obj_jawaban;
            if($hit_row==$jum_row-1){
                $soals[$idx_soal-1]->set_jawabans($jawabans);
            }
        }
        $idx_jwb++; $hit_row++;
    }
    $acak_idx_soal = $MyLCG->get_lcg(count($soals));
    $newSoals = array(); $jum_soal = count($soals);
    for($i=0;$i<$jum_soal;$i++){
        if($i == $current_kategori->get_jumlah_soal()) break;
        if(!in_array($soals[$acak_idx_soal[$i]], $newSoals)) $newSoals[$i] = $soals[$acak_idx_soal[$i]];
        else {
            for($j=0;$j<$jum_soal;$j++){
                if(!in_array($soals[$j], $newSoals)){
                    $newSoals[$i] = $soals[$j];
                    break;
                }
            }
        }
    }
    
    $dom = new DOMDocument("1.0", "UTF-8");
    $soals = $dom->createElement('soals');
    foreach ($newSoals as $so) {
        $soal = $dom->createElement('soal');
        $soal->setAttribute('id_soal', $so->get_id_soal());
        $soal->setAttribute('id_kategori', $so->get_id_kategori());
        $soal->setAttribute('isi_soal', $so->get_isi_soal());
        $jawabans = $so->get_jawabans();
        foreach ($jawabans as $jawab) {
            $jawaban = $dom->createElement('jawaban');
            $jawaban->setAttribute('id_jawaban', $jawab->get_id_jawaban());
            $jawaban->setAttribute('id_soal', $jawab->get_id_soal());
            $jawaban->setAttribute('jawaban', $jawab->get_jawaban());
            $jawaban->setAttribute('benar', $jawab->get_benar());
            $soal->appendChild($jawaban);
        }
        $soals->appendChild($soal);
    }
    $dom->appendChild($soals);
    $dom->save($fileTemp);
} else {
    $dom = new DOMDocument("1.0");
    $dom->load($fileTemp);
    
    $xpath = new DOMXPath($dom);
    $result = $xpath->query("//soal[@id_kategori = \"$current_kategori->id_kategori\"]");
    //jika tidak ada soal dengan kategori yang sedang berlangsung
    if($result->length == 0){
        //load ke database lagi
        $query = "select s.*,j.id_jawaban,j.jawaban,j.benar 
from soal s,jawaban j where s.id_soal=j.id_soal and s.id_kategori=$current_kategori->id_kategori";
    $result = mysql_query($query);
    $soals = array (); $current_id_soal = null;
    $jawabans = array(); $obj_jawaban; $idx_soal = 0; $idx_jwb = 0;
    $jum_row = mysql_num_rows($result); $hit_row = 0;
    while ($row = mysql_fetch_array($result)) {
        $id_soal = $row['id_soal'];
        if($current_id_soal!=$id_soal){
            $id_kategori = $row['id_kategori'];
            $isi_soal = $row['isi_soal'];
            $id_jawaban = $row['id_jawaban'];
            $jawaban = $row['jawaban'];
            $benar = $row['benar'];
            $soal = new Soal($id_soal, $id_kategori, $isi_soal, $jawabans);
            $soals[$idx_soal] = $soal;
            if($current_id_soal!=null){
                $soals[$idx_soal-1]->set_jawabans($jawabans);
            }
            $jawabans = array(); $idx_jwb = 0;
            $obj_jawaban = new Jawaban($id_jawaban, $id_soal, $jawaban, $benar);
            $jawabans[$idx_jwb] = $obj_jawaban;
            $current_id_soal = $id_soal;
            $idx_soal++;
        } else {
            $id_jawaban = $row['id_jawaban'];
            $jawaban = $row['jawaban'];
            $benar = $row['benar'];
            $obj_jawaban = new Jawaban($id_jawaban, $id_soal, $jawaban, $benar);
            $jawabans[$idx_jwb] = $obj_jawaban;
            if($hit_row==$jum_row-1){
                $soals[$idx_soal-1]->set_jawabans($jawabans);
            }
        }
        $idx_jwb++; $hit_row++;
    }
    $acak_idx_soal = $MyLCG->get_lcg(count($soals));
    $newSoals = array(); $jum_soal = count($soals);
    for($i=0;$i<$jum_soal;$i++){
        if($i == $current_kategori->get_jumlah_soal()) break;
        if(!in_array($soals[$acak_idx_soal[$i]], $newSoals)) $newSoals[$i] = $soals[$acak_idx_soal[$i]];
        else {
            for($j=0;$j<$jum_soal;$j++){
                if(!in_array($soals[$j], $newSoals)){
                    $newSoals[$i] = $soals[$j];
                    break;
                }
            }
        }
    }
    
        //save ke temporary lagi
        $soals = $dom->getElementsByTagName('soals')->item(0);
    foreach ($newSoals as $so) {
        $soal = $dom->createElement('soal');
        $soal->setAttribute('id_soal', $so->get_id_soal());
        $soal->setAttribute('id_kategori', $so->get_id_kategori());
        $soal->setAttribute('isi_soal', $so->get_isi_soal());
        $jawabans = $so->get_jawabans();
        foreach ($jawabans as $jawab) {
            $jawaban = $dom->createElement('jawaban');
            $jawaban->setAttribute('id_jawaban', $jawab->get_id_jawaban());
            $jawaban->setAttribute('id_soal', $jawab->get_id_soal());
            $jawaban->setAttribute('jawaban', $jawab->get_jawaban());
            $jawaban->setAttribute('benar', $jawab->get_benar());
            $soal->appendChild($jawaban);
        }
        $soals->appendChild($soal);
    }
    $dom->appendChild($soals);
    $dom->save($fileTemp);
    
    } else {
    
//    $soals = $dom->getElementsByTagName('soal');
//    $soals &= $result;
    $newSoals = array(); $i = 0;
    foreach ($result as $so) {
        $jawabans = array(); $idx_jwb = 0;
        $dom_jawabans = $so->getElementsByTagName('jawaban');
        foreach ($dom_jawabans as $jawab) {
            $jawaban = new Jawaban($jawab->getAttribute('id_jawaban'), $jawab->getAttribute('id_soal'), $jawab->getAttribute('jawaban'), $jawab->getAttribute('benar'));
            $jawabans[$idx_jwb] = $jawaban;
            $idx_jwb++;
        }
        $soal = new Soal($so->getAttribute('id_soal'), $so->getAttribute('id_kategori'), $so->getAttribute('isi_soal'), $jawabans);
        $newSoals[$i] = $soal;
        $i++;
    }
    
    }
    
}

//if($current_kategori!==null)
//if(!isset($_SESSION['soal'])){
//    $query = "select s.*,j.id_jawaban,j.jawaban,j.benar 
//from soal s,jawaban j where s.id_soal=j.id_soal and s.id_kategori=$current_kategori->id_kategori";
//    $result = mysql_query($query);
//    $soals = array (); $current_id_soal = null;
//    $jawabans = array(); $obj_jawaban; $idx_soal = 0; $idx_jwb = 0;
//    $jum_row = mysql_num_rows($result); $hit_row = 0;
//    while ($row = mysql_fetch_array($result)) {
//        $id_soal = $row['id_soal'];
//        if($current_id_soal!=$id_soal){
//            $id_kategori = $row['id_kategori'];
//            $isi_soal = $row['isi_soal'];
//            $id_jawaban = $row['id_jawaban'];
//            $jawaban = $row['jawaban'];
//            $benar = $row['benar'];
//            $soal = new Soal($id_soal, $id_kategori, $isi_soal, $jawabans);
//            $soals[$idx_soal] = $soal;
//            if($current_id_soal!=null){
//                $soals[$idx_soal-1]->set_jawabans($jawabans);
//            }
//            $jawabans = array(); $idx_jwb = 0;
//            $obj_jawaban = new Jawaban($id_jawaban, $id_soal, $jawaban, $benar);
//            $jawabans[$idx_jwb] = $obj_jawaban;
//            $current_id_soal = $id_soal;
//            $idx_soal++;
//        } else {
//            $id_jawaban = $row['id_jawaban'];
//            $jawaban = $row['jawaban'];
//            $benar = $row['benar'];
//            $obj_jawaban = new Jawaban($id_jawaban, $id_soal, $jawaban, $benar);
//            $jawabans[$idx_jwb] = $obj_jawaban;
//            if($hit_row==$jum_row-1){
//                $soals[$idx_soal-1]->set_jawabans($jawabans);
//            }
//        }
//        $idx_jwb++; $hit_row++;
//    }
//    $acak_idx_soal = $MyLCG->get_lcg(count($soals));
//    $newSoals = array(); $jum_soal = count($soals);
//    for($i=0;$i<$jum_soal;$i++){
//        if($i == $current_kategori->get_jumlah_soal()) break;
//        if(!in_array($soals[$acak_idx_soal[$i]], $newSoals)) $newSoals[$i] = $soals[$acak_idx_soal[$i]];
//        else {
//            for($j=0;$j<$jum_soal;$j++){
//                if(!in_array($soals[$j], $newSoals)){
//                    $newSoals[$i] = $soals[$j];
//                    break;
//                }
//            }
//        }
//    }
//    $_SESSION['soal'] = serialize($newSoals);
//} else {
//    $newSoals = unserialize($_SESSION['soal']);
//}
?>
