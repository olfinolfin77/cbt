<?php
include '../../admin/model/object.php';
if(!isset($_SESSION['kategori'])){
    $query = "select * from kategori";
    $result = mysql_query($query);
    $status_kategoris = array(); $i = 0;
    while ($row = mysql_fetch_array($result)) {
        $id_kategori = $row['id_kategori'];
        $nama_kategori = $row['nama_kategori'];
        $waktu = $row['waktu'];
        $jumlah_soal = $row['jumlah_soal'];
        $status_kategori = new StatusKategori($id_kategori, $nama_kategori, $waktu, $jumlah_soal);
        $status_kategoris[$i] = $status_kategori;
        $i++;
    }
    $_SESSION['kategori'] = serialize($status_kategoris);
    $current_kategori = $status_kategoris[0];
}else {
    $status_kategoris = unserialize($_SESSION['kategori']);
    $jum = count($status_kategoris);
    for($i=0;$i<$jum;$i++){
        if(!$status_kategoris[$i]->get_sudah()){
            $current_kategori = $status_kategoris[$i];
            break;
        }
    }
}
?>
