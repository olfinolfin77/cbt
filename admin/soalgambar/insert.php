<?php
//status upload 
/* status 0: Sukses
 * status 1: file yang diupload kosong
 * status 2: file bukan file gambar
 * status 3: ukuran file terlalu besar
 * status 4: Gagal menyimpan ke database
 */
include ('../../inc/config.php');

$pertanyaan = $_POST['pertanyaan'];

//kode upload


//kode untuk mengganti spasi dan karakter pada nama file
// serta karakter non alphabet menjadi garis bawah

//code untuk mengkopi file ke fodler foto
for ($i = 0; $i < count ($_FILES['pertanyaan']['name']); $i++)
	{
        $id_kategori = $_POST['id_kategori'];
$jawaban = $_POST['jawaban'];
    $lokasi_pertanyaan = $_FILES['pertanyaan']['tmp_name'][$i];
$pertanyaan = $_FILES['pertanyaan']['name'][$i];
$tipe_pertanyaan = $_FILES['pertanyaan']['type'][$i];
$ukuran_pertanyaan = $_FILES['pertanyaan']['size'][$i];
$lokasi_pilihan_a = $_FILES['pilihan_a']['tmp_name'][$i];
$pilihan_a = $_FILES['pilihan_a']['name'][$i];
$tipe_pilihan_a = $_FILES['pilihan_a']['type'][$i];
$ukuran_pilihan_a = $_FILES['pilihan_a']['size'][$i];
$lokasi_pilihan_b = $_FILES['pilihan_b']['tmp_name'][$i];
$pilihan_b = $_FILES['pilihan_b']['name'][$i];
$tipe_pilihan_b = $_FILES['pilihan_b']['type'][$i];
$ukuran_pilihan_b = $_FILES['pilihan_b']['size'][$i];
$lokasi_pilihan_c = $_FILES['pilihan_c']['tmp_name'][$i];
$pilihan_c = $_FILES['pilihan_c']['name'][$i];
$tipe_pilihan_c = $_FILES['pilihan_c']['type'][$i];
$ukuran_pilihan_c = $_FILES['pilihan_c']['size'][$i];
$lokasi_pilihan_d = $_FILES['pilihan_d']['tmp_name'][$i];
$pilihan_d = $_FILES['pilihan_d']['name'][$i];
$tipe_pilihan_d = $_FILES['pilihan_d']['type'][$i];
$ukuran_pilihan_d = $_FILES['pilihan_d']['size'][$i];


$nama_baru = preg_replace("/\s+/", "_", $pertanyaan);
$direktori = "../../foto/$nama_baru";

$a_baru = preg_replace("/\s+/", "_", $pilihan_a);
$direktori_a = "../../foto/$a_baru";

$b_baru = preg_replace("/\s+/", "_", $pilihan_b);
$direktori_b = "../../foto/$b_baru";

$c_baru = preg_replace("/\s+/", "_", $pilihan_c);
$direktori_c = "../../foto/$c_baru";

$d_baru = preg_replace("/\s+/", "_", $pilihan_d);
$direktori_d = "../../foto/$d_baru";

$MAX_FILE_SIZE = 50000; //50kb

//cek apakah file kosong? 
if(strlen($pertanyaan)<1){
	header("Location:form_tambah.php?status=1");
	exit();
}
if(strlen($pilihan_a)<1){
	header("Location:form_tambah.php?status=1");
	exit();
}

if(strlen($pilihan_b)<1){
	header("Location:form_tambah.php?status=1");
	exit();
}

if(strlen($pilihan_c)<1){
	header("Location:form_tambah.php?status=1");
	exit();
}

if(strlen($pilihan_d)<1){
	header("Location:form_tambah.php?status=1");
	exit();
}

//cek apakah format file adalah format gambar
$formatgambar = array("image/jpg", "image/jpeg","image/gif", "image/png");
if(!in_array($tipe_pertanyaan, $formatgambar)) {
  header("Location:form_tambah.php?status=2");
	exit();
}
if(!in_array($tipe_pilihan_a, $formatgambar)) {
  header("Location:form_tambah.php?status=2");
	exit();
}

if(!in_array($tipe_pilihan_b, $formatgambar)) {
  header("Location:form_tambah.php?status=2");
	exit();
}

if(!in_array($tipe_pilihan_c, $formatgambar)) {
  header("Location:form_tambah.php?status=2");
	exit();
}

if(!in_array($tipe_pilihan_d, $formatgambar)) {
  header("Location:form_tambah.php?status=2");
	exit();
}

//cek apakah ukuran file diatas 50kb 
if($ukuran_pertanyaan > $MAX_FILE_SIZE) {
	header("Location:form_tambah.php?status=3");
	exit();
}

if($ukuran_pilihan_a > $MAX_FILE_SIZE) {
	header("Location:form_tambah.php?status=3");
	exit();
}

if($ukuran_pilihan_b > $MAX_FILE_SIZE) {
	header("Location:form_tambah.php?status=3");
	exit();
}

if($ukuran_pilihan_c > $MAX_FILE_SIZE) {
	header("Location:form_tambah.php?status=3");
	exit();
}

if($ukuran_pilihan_d > $MAX_FILE_SIZE) {
	header("Location:form_tambah.php?status=3");
	exit();
}
move_uploaded_file($lokasi_pertanyaan, $direktori);
move_uploaded_file($lokasi_pilihan_a, $direktori_a);
move_uploaded_file($lokasi_pilihan_b, $direktori_b);
move_uploaded_file($lokasi_pilihan_c, $direktori_c);
move_uploaded_file($lokasi_pilihan_d, $direktori_d);
$sql = "INSERT INTO soal(id_kategori,pertanyaan,pilihan_a,pilihan_b,pilihan_c,pilihan_d,jawaban)
		VALUES('$id_kategori','$nama_baru','$a_baru','$b_baru','$c_baru','$d_baru','$jawaban')";

//masukan nama file kedalam tabel foto di database mysql 
$result = mysql_query($sql) or die(mysql_error());
        }
//check if query successful
if($result==true) {
	header('location:form_tambah.php?status=0');
} else {
	header('location:form_tambah.php?status=4');
}
mysql_close();
?>
