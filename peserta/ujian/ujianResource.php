<?php
session_start();
include '../../inc/config.php';
include '../../admin/model/object.php';

//$status_kategoris = unserialize($_SESSION['kategori']);
//$soals = unserialize($_SESSION['soal']);

$fileTempKat = '../temp/temp_kategori_'.$_SESSION['no_peserta'];
$fileTemp = '../temp/temp_soal_'.$_SESSION['no_peserta'];
$fileTempCurrentSoal = '../temp/temp_current_soal_'.$_SESSION['no_peserta'];

if(isset ($_POST['json'])){
    $json = $_POST['json'];
    $obj = json_decode(stripslashes($json));
    $no_peserta = $obj->{'no_peserta'};
    $id_kategori = $obj->{'id_kategori'};
    $curr_id_soal = $obj->{'id_soal'};
    $ujian = $obj->{'ujian'};
    if($no_peserta==null || $id_kategori==null || $ujian==null){
        echo json_encode(new Result('0',"Parameter tidak lengkap"));
        exit();
    }
    
    //load file temporary to get soals
    $dom = new DOMDocument("1.0");
    $dom->load($fileTemp);
    $xpath = new DOMXPath($dom);
    $result = $xpath->query("//soal[@id_kategori = \"$id_kategori\"]");
    $soals = array(); $i = 0;
    foreach ($result as $so) {
        $jawabans = array(); $idx_jwb = 0;
        $dom_jawabans = $so->getElementsByTagName('jawaban');
        foreach ($dom_jawabans as $jawab) {
            $jawaban = new Jawaban($jawab->getAttribute('id_jawaban'), $jawab->getAttribute('id_soal'), $jawab->getAttribute('jawaban'), $jawab->getAttribute('benar'));
            $jawabans[$idx_jwb] = $jawaban;
            $idx_jwb++;
        }
        $soal = new Soal($so->getAttribute('id_soal'), $so->getAttribute('id_kategori'), $so->getAttribute('isi_soal'), $jawabans);
        $soals[$i] = $soal;
        $i++;
    }
    //end load file temporary to get soals
    
    if($curr_id_soal < count($soals)-1){
        $dom = new DOMDocument("1.0");
        $dom->load($fileTempCurrentSoal);
        $dom_soal = $dom->getElementsByTagName('soal');
        $jwb_benar = $dom_soal->item(0)->getAttribute('jwb_benar');
        
        $id_jawaban = $ujian[0]->{'id_jawaban'};
        foreach ($soals as $soal) {
            if($soal->id_soal == $curr_id_soal){
                $jawabans = $soal->jawabans;
                foreach ($jawabans as $jawaban) {
                    $jawaban->id_jawaban = (strpos($jawaban->id_jawaban, '.') === 0)?substr($jawaban->id_jawaban, 1):$jawaban->id_jawaban;
                    if($jawaban->id_jawaban == $id_jawaban){
                        if($jawaban->benar || $jawaban->benar==1){
                            $jwb_benar += 1;
                            $dom_soal->item(0)->setAttribute('jwb_benar', $jwb_benar);
                        }
                    }
                }
            }
        }
        $dom_soal->item(0)->setAttribute('current_id', $curr_id_soal+1);
        $dom->save($fileTempCurrentSoal);
        echo json_encode(new Result('1',"Sukses"));
//        echo json_encode(new Result('0',"Parameter tidak lengkap".$jwb_benar));
        exit();
    }
    
    $dom = new DOMDocument("1.0");
    $dom->load($fileTempCurrentSoal);
    $dom_soal = $dom->getElementsByTagName('soal');
    $jawaban_benar = $dom_soal->item(0)->getAttribute('jwb_benar');
    
//    $jumlah_soal = count($ujian);
    $jumlah_soal = count($soals);
//    $jawaban_benar = 0;
    for($i=0;$i<$jumlah_soal;$i++){
        $id_soal = $ujian[$i]->{'id_soal'};
        $id_jawaban = $ujian[$i]->{'id_jawaban'};
        $id_jawaban = (strpos($id_jawaban, '.') === 0)?substr($id_jawaban, 1):$id_jawaban;
        foreach ($soals as $soal) {
            if($soal->id_soal == $id_soal){
                $jawabans = $soal->jawabans;
                foreach ($jawabans as $jawaban) {
                    $jawaban->id_jawaban = (strpos($jawaban->id_jawaban, '.') === 0)?substr($jawaban->id_jawaban, 1):$jawaban->id_jawaban;
                    if($jawaban->id_jawaban == $id_jawaban){
                        if($jawaban->benar || $jawaban->benar==1){
                            $jawaban_benar++;
                        }
                        break;
                    }
                }
                break;
            }
        }
    }
    //simpan nilai ke dalam temporary
    $nilai = (100/$jumlah_soal) * $jawaban_benar;
    $sudah_semua = true;
    $dom = new DOMDocument("1.0");
    $dom->load($fileTempKat);
    $xpath = new DOMXPath($dom);
    $result = $xpath->query("//kategori[@id_kategori = \"$id_kategori\"]")->item(0);
    $result->setAttribute('nilai', $nilai);
    $result->setAttribute('sudah', true);
    $dom->save($fileTempKat);
    $_SESSION['reset_id_soal'] = true; // untuk penanda supaya mereset current_id_soal
    
    //cek jika semua kategori sudah dikerjakan
    $kategoris = $dom->getElementsByTagName('kategori');
    $yangsudah = $xpath->query("//kategori[@sudah = 1]");
    if($kategoris->length != $yangsudah->length){
        $sudah_semua = false;
    }
    
    //jika sudah dikerjakan semua
    if($sudah_semua){
        $jumlah_nilai = 0;
        foreach ($kategoris as $kategori) {
            $jumlah_nilai += $kategori->getAttribute('nilai');
        }
        $nilai_akhir = $jumlah_nilai/$kategoris->length;
        $query = "update peserta set nilai=$nilai_akhir where no_peserta='$no_peserta'";
        $result = pg_query($query);
        if(!$result){
            echo json_encode(new Result('0',"Gagal query 1")); exit();
        }
        //load status kategori dari file temporary untuk disimpan ke session
        $dom = new DOMDocument("1.0");
        $dom->load($fileTempKat);
        $kategoris = $dom->getElementsByTagName('kategori');
        $status_kategoris = array(); $i = 0;
        $query = "insert into nilai_per_kategori values ";
        foreach ($kategoris as $kat) {
            $status_kategori = new StatusKategori($kat->getAttribute('id_kategori'), $kat->getAttribute('nama_kategori'), $kat->getAttribute('waktu'), $kat->getAttribute('jumlah_soal'));
            $status_kategori->set_sudah($kat->getAttribute('sudah'));
            $status_kategori->set_nilai($kat->getAttribute('nilai'));
            $query .= "('$no_peserta',{$kat->getAttribute('id_kategori')},{$kat->getAttribute('nilai')}),";
            $status_kategoris[$i] = $status_kategori;
            $i++;
        }
        $query = substr($query, 0, strlen($query)-1);
        $result = pg_query($query);
        if(!$result){
            echo json_encode(new Result('0',"Gagal query 2")); exit();
        }
        $_SESSION['kategori'] = serialize($status_kategoris);
        
        //hapus file temporary
        unlink($fileTempKat);
        unlink($fileTemp);
        unlink($fileTempCurrentSoal);
    }
    
//    $nilai = (100/$jumlah_soal) * $jawaban_benar;
//    $jum_kat = count($status_kategoris);
//    $sudah_semua = true;
//    for($i=0;$i<$jum_kat;$i++) {
//        if($status_kategoris[$i]->id_kategori == $id_kategori){
//            $status_kategoris[$i]->set_nilai($nilai);
//            $status_kategoris[$i]->set_sudah(true);
//            break;
//        }
//    }
//    for($i=0;$i<$jum_kat;$i++) {
//        if(!$status_kategoris[$i]->get_sudah()){
//            $sudah_semua = false;
//            break;
//        }
//    }
//    if($sudah_semua){
//        $jumlah_nilai = 0;
//        for($i=0;$i<$jum_kat;$i++) {
//            $jumlah_nilai += $status_kategoris[$i]->get_nilai();
//        }
//        $nilai_akhir = $jumlah_nilai/$jum_kat;
//        $query = "update peserta set nilai=$nilai_akhir where no_peserta='$no_peserta'";
//        $result = mysql_query($query);
//        if(!$result){
//            echo json_encode(new Result('0',"Gagal query 1")); exit();
//        }
//    }
//    $_SESSION['kategori'] = serialize($status_kategoris);
//    unset ($_SESSION['soal']);
    unset ($_SESSION['mulai']);
    echo json_encode(new Result('1',"Sukses"));
} else {
    echo json_encode(new Result('0',"Parameter tidak lengkap"));
}
?>
