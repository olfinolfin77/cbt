<?php
include '../../admin/model/object.php';

$fileTemp = '../temp/temp_kategori_'.$_SESSION['no_peserta'];

if(isset($_SESSION['kategori'])){
    $status_kategoris = unserialize($_SESSION['kategori']);
    $jum = count($status_kategoris);
}
else
if(!file_exists($fileTemp)){
    $query = "select * from kategori";
    $result = pg_query($query);
    $status_kategoris = array(); $i = 0;
    
    $dom = new DOMDocument("1.0", "UTF-8");
    $kategoris = $dom->createElement('kategoris');
    
    while ($row = pg_fetch_array($result)) {
        $id_kategori = $row['id_kategori'];
        $nama_kategori = $row['nama_kategori'];
        $waktu = $row['waktu'];
        $jumlah_soal = $row['jumlah_soal'];
        $status_kategori = new StatusKategori($id_kategori, $nama_kategori, $waktu, $jumlah_soal);
        $status_kategoris[$i] = $status_kategori;
        $i++;
        
        $kategori = $dom->createElement('kategori');
        $kategori->setAttribute('id_kategori', $id_kategori);
        $kategori->setAttribute('nama_kategori', $nama_kategori);
        $kategori->setAttribute('waktu', $waktu);
        $kategori->setAttribute('jumlah_soal', $jumlah_soal);
        $kategori->setAttribute('sudah', false);
        $kategori->setAttribute('nilai', '0');
        $kategoris->appendChild($kategori);
    }
    
    $dom->appendChild($kategoris);
    $dom->save($fileTemp); //save file temp
    $current_kategori = $status_kategoris[0];
} else {
    $dom = new DOMDocument("1.0");
    $dom->load($fileTemp);
    $kategoris = $dom->getElementsByTagName('kategori');
    $status_kategoris = array(); $i = 0;
    foreach ($kategoris as $kat) {
        $status_kategori = new StatusKategori($kat->getAttribute('id_kategori'), $kat->getAttribute('nama_kategori'), $kat->getAttribute('waktu'), $kat->getAttribute('jumlah_soal'));
        $status_kategori->set_sudah($kat->getAttribute('sudah'));
        $status_kategori->set_nilai($kat->getAttribute('nilai'));
        $status_kategoris[$i] = $status_kategori;
        $i++;
    }
    $jum = count($status_kategoris);
    for($i=0;$i<$jum;$i++){
        if(!$status_kategoris[$i]->get_sudah()){
            $current_kategori = $status_kategoris[$i];
            break;
        }
    }
}

//if(!isset($_SESSION['kategori'])){
//    $query = "select * from kategori";
//    $result = mysql_query($query);
//    $status_kategoris = array(); $i = 0;
//    while ($row = mysql_fetch_array($result)) {
//        $id_kategori = $row['id_kategori'];
//        $nama_kategori = $row['nama_kategori'];
//        $waktu = $row['waktu'];
//        $jumlah_soal = $row['jumlah_soal'];
//        $status_kategori = new StatusKategori($id_kategori, $nama_kategori, $waktu, $jumlah_soal);
//        $status_kategoris[$i] = $status_kategori;
//        $i++;
//    }
//    $_SESSION['kategori'] = serialize($status_kategoris);
//    $current_kategori = $status_kategoris[0];
//}else {
//    $status_kategoris = unserialize($_SESSION['kategori']);
//    $jum = count($status_kategoris);
//    for($i=0;$i<$jum;$i++){
//        if(!$status_kategoris[$i]->get_sudah()){
//            $current_kategori = $status_kategoris[$i];
//            break;
//        }
//    }
//}
?>
