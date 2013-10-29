<?php
session_start();
include '../../inc/config.php';
include '../../admin/model/object.php';

$status_kategoris = unserialize($_SESSION['kategori']);
$soals = unserialize($_SESSION['soal']);

if(isset ($_POST['json'])){
    $json = $_POST['json'];
    $obj = json_decode(stripslashes($json));
    $no_peserta = $obj->{'no_peserta'};
    $id_kategori = $obj->{'id_kategori'};
    $ujian = $obj->{'ujian'};
    if($no_peserta==null || $id_kategori==null || $ujian==null){
        echo json_encode(new Result('0',"Parameter tidak lengkap"));
        exit();
    }
    $jumlah_soal = count($ujian);
    $jawaban_benar = 0;
    for($i=0;$i<$jumlah_soal;$i++){
        $id_soal = $ujian[$i]->{'id_soal'};
        $id_jawaban = $ujian[$i]->{'id_jawaban'};
        foreach ($soals as $soal) {
//            echo $status_kategoris[0]->get_id_kategori().',';
            if($soal->id_soal == $id_soal){
                $jawabans = $soal->jawabans;
                foreach ($jawabans as $jawaban) {
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
    $nilai = (100/$jumlah_soal) * $jawaban_benar;
    $jum_kat = count($status_kategoris);
    $sudah_semua = true;
    for($i=0;$i<$jum_kat;$i++) {
        if($status_kategoris[$i]->id_kategori == $id_kategori){
            $status_kategoris[$i]->set_nilai($nilai);
            $status_kategoris[$i]->set_sudah(true);
            break;
        }
    }
    for($i=0;$i<$jum_kat;$i++) {
        if(!$status_kategoris[$i]->get_sudah()){
            $sudah_semua = false;
            break;
        }
    }
    if($sudah_semua){
        $jumlah_nilai = 0;
        for($i=0;$i<$jum_kat;$i++) {
            $jumlah_nilai += $status_kategoris[$i]->get_nilai();
        }
        $nilai_akhir = $jumlah_nilai/$jum_kat;
        $query = "update peserta set nilai=$nilai_akhir where no_peserta='$no_peserta'";
        $result = mysql_query($query);
        if(!$result){
            echo json_encode(new Result('0',"Gagal query 1")); exit();
        }
//        $query = "select pj.*,g.id_grade,g.batas_grade from pilihan_jurusan pj,grade g
//where pj.id_jurusan=g.id_jurusan and no_peserta='$no_peserta'";
//        $result = mysql_query($query);
//        if($result === FALSE){
//            echo json_encode(new Result('0',mysql_error())); exit();
//        }
//        while ($row = mysql_fetch_array($result)) {
//            $no_pes = $row['no_peserta'];
//            $id_jurusan = $row['id_jurusan'];
//            $batas_grade = $row['batas_grade'];
//            if($nilai_akhir>=$batas_grade){
//                $query = "update pilihan_jurusan set lulus=1 where no_peserta='$no_pes' and id_jurusan=$id_jurusan;";
//                $resul = mysql_query($query);
//                if(!$resul){
//                    echo json_encode(new Result('0',"Gagal query 2")); exit();
//                }
//            }
//        }
    }
    $_SESSION['kategori'] = serialize($status_kategoris);
    unset ($_SESSION['soal']);
    unset ($_SESSION['mulai']);
//    echo 'Nilai '.$nilai;
    echo json_encode(new Result('1',"Sukses"));
} else {
    echo json_encode(new Result('0',"Parameter tidak lengkap"));
}
?>
