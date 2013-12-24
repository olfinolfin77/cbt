<?php
function setTitle($title) {
    define("Title", $title);
}
function getUrlForAjax() {
    $url = $_SERVER[PHP_SELF];
    $position = strpos($url, 'admin')+5;
    $url = substr($url, 0, $position);
    return $url;
}

function getUrlForImageUpload() {
    $url = $_SERVER[PHP_SELF];
    $position = strpos($url, 'admin');
    $url = substr($url, 0, $position);
    return $url;
}

function base_url()
{
	if (isset($_SERVER['HTTP_HOST']))
	{
		$url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
		$url .= '://'. $_SERVER['HTTP_HOST'];
		$url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
                $url = substr($url, 0, strlen($url)-6);
	}
	else
		$url = 'http://localhost/';

	return	$url;
}

function userDAO($proses, $json) {
    switch ($proses) {
        case 'tambah':
            return tambah_user($json);
            break;
        case 'ubah':
            return ubah_user($json);
            break;
        case 'get':
            return get_user($json);
            break;
        case 'hapus':
            return hapus_user($json);
            break;
        case 'change_password':
            return ubah_password($json);
            break;
        default:
            return json_encode(new Result('0','gagal'));
            break;
    }
}

function pesertaDAO($proses, $json) {
    switch ($proses) {
        case 'tambah':
            return tambah_peserta($json);
            break;
        case 'ubah':
            return ubah_peserta($json);
            break;
        case 'get':

            break;
        case 'hapus':
            return hapus_peserta($json);
            break;
        default:
            return json_encode(new Result('0','gagal'));
            break;
    }
}

function soalDAO($proses, $json) {
    switch ($proses) {
        case 'tambah':
            return tambah_soal($json);
            break;
        case 'ubah':
            return ubah_soal($json);
            break;
        case 'get':

            break;
        case 'get_jawaban':
            return get_jawaban_soal($json);
            break;
        case 'hapus':
            return hapus_soal($json);
            break;
        default:
            return json_encode(new Result('0','gagal'));
            break;
    }
}

function jurusanDAO($proses, $json) {
    switch ($proses) {
        case 'get':
            return get_jurusan($json);
            break;
        case 'get_grade':
            return get_grade_jurusan($json);
            break;
        case 'simpan_grade':
            return simpan_grade_jurusan($json);
            break;
        case 'tambah':
            return tambah_jurusan($json);
            break;
        case 'ubah':
            return ubah_jurusan($json);
            break;
        case 'hapus':
            return hapus_jurusan($json);
            break;
        default:
            return json_encode(new Result('0','gagal'));
            break;
    }
}

function kategoriDAO($proses, $json){
    switch ($proses) {
        case 'get':
            return get_kategori($json);
            break;
        case 'tambah':
            return tambah_kategori($json);
            break;
        case 'ubah':
            return ubah_kategori($json);
            break;
        case 'hapus':
            return hapus_kategori($json);
            break;
        default:
            return json_encode(new Result('0','gagal'));
            break;
    }
}

function tambah_user($json) {
    $obj = json_decode(stripslashes($json));
    $username = $obj->{'username'};
    $nama = $obj->{'nama'};
    $telepon = $obj->{'telepon'};
    $alamat = $obj->{'alamat'};
    $role = $obj->{'role'};

    if($username==null || $username=='' ||
            $nama==null || $nama=='' ||
//            $telepon==null ||
//            $alamat==null ||
            $role==null || $role==''){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $link = mysqli_connect(server,username,password,database);
    $query = "insert into admin(username,password,nama,telepon,alamat,role)
        values(?,?,?,?,?,?)";
    $default_password = md5("123456");

    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'ssssss',$username,$default_password,$nama,$telepon,$alamat,$role);
        mysqli_stmt_execute($stmt);
    } else {
        return json_encode(new Result('0','gagal'));
    }

    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}
function ubah_user($json) {
    $obj = json_decode(stripslashes($json));
    $id_admin = $obj->{'id_admin'};
    $username = $obj->{'username'};
    $nama = $obj->{'nama'};
    $telepon = $obj->{'telepon'};
    $alamat = $obj->{'alamat'};
    $role = $obj->{'role'};

    if($id_admin==null || $id_admin=='' ||
            $username==null || $username=='' ||
            $nama==null || $nama=='' ||
//            $telepon==null ||
//            $alamat==null ||
            $role==null || $role==''){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $link = mysqli_connect(server,username,password,database);
    $query = "UPDATE admin SET username=?,nama=?,telepon=?
    ,alamat=?,role=? WHERE id_admin=?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'sssssi',$username,$nama,$telepon,$alamat,$role,$id_admin);
        mysqli_stmt_execute($stmt);
    } else {
        return json_encode(new Result('0','gagal'));
    }

    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}

function get_user($json) {
    $obj = json_decode(stripslashes($json));
    $where = $obj->{'where'}; //user='username'
    $limit = $obj->{'limit'};
    $query = "SELECT id_admin,username,nama,telepon,alamat,role FROM admin ORDER BY username";
    if($where!=null){
        $total_where = count($where);
        for($i=0;$i<$total_where;$i++){
            if($i==($total_where-1) && $i==0){
                $query .= ' WHERE '.$where[$i];
                break;
            }
            if($i==($total_where-1)){
                $query .= ' '.$where[$i];
                break;
            }
            if($i==0){
                $query .= " WHERE ";
            }
            $query .= $where[$i] . ' && ';
        }
    }
    if($limit!=null){
        $posisi = $limit->{'posisi'};
        $batas = $limit->{'batas'};
        $query .= " LIMIT $posisi,$batas";
    }
    $result = mysql_query($query);
    if($result){
        $users = array(); $i=0;
        while ($row = mysql_fetch_array($result)) {
            $id_admin = $row['id_admin'];
            $username = $row['username'];
            $nama = $row['nama'];
            $telepon = $row['telepon'];
            $alamat = $row['alamat'];
            $role = $row['role'];
            $user = new User($id_admin, $username, null, $nama, $telepon, $alamat, $role);
            $users[$i] = $user;
            $i++;
        }
        return json_encode($users);
    } else return json_encode(new Result('0','gagal query'));
    return $query;
}
function hapus_user($json) {
    $obj = json_decode(stripslashes($json));
    $id_admin = $obj->{'id_admin'};
    $query = "DELETE FROM admin WHERE id_admin='$id_admin'";
    $result = mysql_query($query);
    if($result){
        return json_encode(new Result('1','sukses'));
    } else return json_encode(new Result('0','gagal query'));
}
function ubah_password($json) {
    $obj = json_decode(stripslashes($json));
    $id_admin = $obj->{'id_admin'};
    $password_lama = $obj->{'password_lama'};
    $password_baru = $obj->{'password_baru'};
    $konfirmasi_password = $obj->{'konfirmasi_password'};
    if($id_admin==null || $password_lama==null || $password_baru==null || $konfirmasi_password==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $result = mysql_query("select password from admin where id_admin=$id_admin");
    if($result){
        while ($row = mysql_fetch_array($result)) {
            if(md5($password_lama) != $row['password']) return json_encode(new Result('0','Password Lama Salah'));
        }
    } else return json_encode(new Result('0','gagal query'));
    $query = "UPDATE admin SET password=? WHERE id_admin=?";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        $password_baru = md5($password_baru);
        mysqli_stmt_bind_param($stmt,'si',$password_baru,$id_admin);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal'));
    } else {
        return json_encode(new Result('0','gagal'));
    }

    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}

//JURUSAN
function get_jurusan($json) {
    $obj = json_decode(stripslashes($json));
    $where = $obj->{'where'}; //user='username'
    $limit = $obj->{'limit'};
    $query = "SELECT * from jurusan order by nama_jurusan";
    if($where!=null){
        $total_where = count($where);
        for($i=0;$i<$total_where;$i++){
            if($i==($total_where-1) && $i==0){
                $query .= ' WHERE '.$where[$i];
                break;
            }
            if($i==($total_where-1)){
                $query .= ' '.$where[$i];
                break;
            }
            if($i==0){
                $query .= " WHERE ";
            }
            $query .= $where[$i] . ' && ';
        }
    }
    if($limit!=null){
        $posisi = $limit->{'posisi'};
        $batas = $limit->{'batas'};
        $query .= " LIMIT $posisi,$batas";
    }
    $result = mysql_query($query);
    if($result){
        $jurusans = array(); $i=0;
        while ($row = mysql_fetch_array($result)) {
            $id_jurusan = $row['id_jurusan'];
            $nama_jurusan = $row['nama_jurusan'];
            $daya_tampung = $row['daya_tampung'];
//            $jurusan = new Jurusan($id_jurusan, $nama_jurusan);
            $jurusan = Jurusan::jurusan($id_jurusan, $nama_jurusan, $daya_tampung);
            $jurusans[$i] = $jurusan;
            $i++;
        }
        return json_encode($jurusans);
    } else return json_encode(new Result('0','gagal query'));
    return $query;
}
function get_grade_jurusan($json) {
    $obj = json_decode(stripslashes($json));
    $where = $obj->{'where'}; //user='username'
    $limit = $obj->{'limit'};
    $query = "SELECT data.id_jurusan,data.nama_jurusan,
(CASE
WHEN data.id_grade IS NULL THEN 'null'
ELSE data.id_grade
END
) AS id_grade,
(
CASE
WHEN data.batas_grade IS NULL THEN 0
ELSE data.batas_grade
END
) AS batas_grade
 from
(
SELECT
j.id_jurusan,j.nama_jurusan,g.id_grade,g.batas_grade
from
jurusan j left join grade g on j.id_jurusan=g.id_jurusan
) as data";
    if($where!=null){
        $total_where = count($where);
        for($i=0;$i<$total_where;$i++){
            if($i==($total_where-1) && $i==0){
                $query .= ' WHERE '.$where[$i];
                break;
            }
            if($i==($total_where-1)){
                $query .= ' '.$where[$i];
                break;
            }
            if($i==0){
                $query .= " WHERE ";
            }
            $query .= $where[$i] . ' && ';
        }
    }
    if($limit!=null){
        $posisi = $limit->{'posisi'};
        $batas = $limit->{'batas'};
        $query .= " LIMIT $posisi,$batas";
    }
    $result = mysql_query($query);
    if($result){
        $jurusans = array(); $i=0;
        while ($row = mysql_fetch_array($result)) {
            $id_jurusan = $row['id_jurusan'];
            $nama_jurusan = $row['nama_jurusan'];
            $id_grade = $row['id_grade'];
            $batas_grade = $row['batas_grade'];
            $jurusan = new GradeJurusan($id_jurusan, $nama_jurusan, $id_grade, $batas_grade);
            $jurusans[$i] = $jurusan;
            $i++;
        }
        return json_encode($jurusans);
    } else return json_encode(new Result('0','gagal query'));
    return $query;
}
function simpan_grade_jurusan($json) {
    $obj = json_decode(stripslashes($json));
    $id_jurusan = $obj->{'id_jurusan'};
    $id_grade = $obj->{'id_grade'};
    $batas_grade = $obj->{'batas_grade'};
    $isInsert = false;
    if($id_jurusan==null || $id_grade==null || $batas_grade==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $link = mysqli_connect(server,username,password,database);
    if($id_grade=='null'){
        $query = "INSERT into grade (id_jurusan,batas_grade) values(?,?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt,'ii',$id_jurusan,$batas_grade);
        } else return json_encode(new Result('0','gagal prepare'));
        $isInsert = true;
    } else {
        $query = "UPDATE grade SET batas_grade=? WHERE id_grade=?";
        if ($stmt = mysqli_prepare($link, $query)) {
            mysqli_stmt_bind_param($stmt,'ii',$batas_grade,$id_grade);
        } else return json_encode(new Result('0','gagal prepare'));
    }
    if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
    if($isInsert){
        $last_id = mysqli_stmt_insert_id($stmt);
        $result = new Result('1','sukses'.$last_id);
    } else $result = new Result('1','sukses');
    mysqli_stmt_close($stmt);
    return json_encode($result);
}
function tambah_jurusan($json) {
    $obj = json_decode(stripslashes($json));
    $nama_jurusan = $obj->{'nama_jurusan'};
    $daya_tampung = $obj->{'daya_tampung'};
    if($nama_jurusan==null || $daya_tampung==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $query = "INSERT into jurusan(nama_jurusan,daya_tampung) values(?,?)";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'si',$nama_jurusan,$daya_tampung);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal'));
    } else {
        return json_encode(new Result('0','gagal'));
    }
    $last_id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'.$last_id));
}
function hapus_jurusan($json) {
    $obj = json_decode(stripslashes($json));
    $id_jurusan = $obj->{'id_jurusan'};
    $query = "DELETE FROM jurusan WHERE id_jurusan='$id_jurusan'";
    $result = mysql_query($query);
    if($result){
        return json_encode(new Result('1','sukses'));
    } else return json_encode(new Result('0','gagal query'));
}
function ubah_jurusan($json) {
    $obj = json_decode(stripslashes($json));
    $id_jurusan = $obj->{'id_jurusan'};
    $nama_jurusan = $obj->{'nama_jurusan'};
    $daya_tampung = $obj->{'daya_tampung'};
    if($id_jurusan==null || $nama_jurusan==null || $daya_tampung==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $query = "UPDATE jurusan SET nama_jurusan=? , daya_tampung=? WHERE id_jurusan=?";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'sii',$nama_jurusan,$daya_tampung,$id_jurusan);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal'));
    } else {
        return json_encode(new Result('0','gagal'));
    }

    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}

//KATEGORI
function get_kategori($json) {
    $obj = json_decode(stripslashes($json));
    $where = $obj->{'where'}; //user='username'
    $limit = $obj->{'limit'};
    $query = "SELECT * from kategori order by nama_kategori";
    if($where!=null){
        $total_where = count($where);
        for($i=0;$i<$total_where;$i++){
            if($i==($total_where-1) && $i==0){
                $query .= ' WHERE '.$where[$i];
                break;
            }
            if($i==($total_where-1)){
                $query .= ' '.$where[$i];
                break;
            }
            if($i==0){
                $query .= " WHERE ";
            }
            $query .= $where[$i] . ' && ';
        }
    }
    if($limit!=null){
        $posisi = $limit->{'posisi'};
        $batas = $limit->{'batas'};
        $query .= " LIMIT $posisi,$batas";
    }
    $result = mysql_query($query);
    if($result){
        $kategoris = array(); $i=0;
        while ($row = mysql_fetch_array($result)) {
            $id_kategori = $row['id_kategori'];
            $nama_kategori = $row['nama_kategori'];
            $waktu = $row['waktu'];
            $jumlah_soal = $row['jumlah_soal'];
            $kategori = new Kategori($id_kategori,$nama_kategori,$waktu,$jumlah_soal);
            $kategoris[$i] = $kategori;
            $i++;
        }
        return json_encode($kategoris);
    } else return json_encode(new Result('0','gagal query'));
    return $query;
}
function tambah_kategori($json) {
    $obj = json_decode(stripslashes($json));
    $nama_kategori = $obj->{'nama_kategori'};
    $waktu = $obj->{'waktu'};
    $jumlah_soal = $obj->{'jumlah_soal'};
    if($nama_kategori==null || $waktu==null || $jumlah_soal==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $query = "INSERT into kategori(nama_kategori,waktu,jumlah_soal) values(?,?,?)";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'sii',$nama_kategori,$waktu,$jumlah_soal);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
    } else {
        return json_encode(new Result('0','gagal'));
    }
    $last_id = mysqli_stmt_insert_id($stmt);
    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'.$last_id));
}
function hapus_kategori($json) {
    $obj = json_decode(stripslashes($json));
    $id_kategori = $obj->{'id_kategori'};
    $query = "DELETE FROM kategori WHERE id_kategori=$id_kategori";
    $result = mysql_query($query);
    if($result){
        return json_encode(new Result('1','sukses'));
    } else return json_encode(new Result('0','gagal query'));
}
function ubah_kategori($json) {
    $obj = json_decode(stripslashes($json));
    $id_kategori = $obj->{'id_kategori'};
    $nama_kategori = $obj->{'nama_kategori'};
    $waktu = $obj->{'waktu'};
    $jumlah_soal = $obj->{'jumlah_soal'};
    if($id_kategori==null || $nama_kategori==null || $waktu==null || $jumlah_soal==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $query = "UPDATE kategori SET nama_kategori=?,waktu=?,jumlah_soal=? WHERE id_kategori=?";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'siii',$nama_kategori,$waktu,$jumlah_soal,$id_kategori);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
    } else {
        return json_encode(new Result('0','gagal'));
    }

    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}

//PESERTA
function tambah_peserta($json) {
    $obj = json_decode(stripslashes($json));
    $no_peserta = $obj->{'no_peserta'};
    $nama = $obj->{'nama'};
    $alamat = $obj->{'alamat'};
    $telepon = $obj->{'telepon'};
    $keterangan = $obj->{'keterangan'};
    $pilihan_jurusan = $obj->{'pilihan_jurusan'};
    if($no_peserta==null || $nama==null || $pilihan_jurusan==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $nilai = '-1'; //-1 = Belum Ujian
    $query = "INSERT into peserta(no_peserta,nama,alamat,telepon,nilai,keterangan) values(?,?,?,?,?,?)";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'ssssis',$no_peserta,$nama,$alamat,$telepon,$nilai,$keterangan);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0', mysqli_stmt_error($stmt)));
    } else {
        return json_encode(new Result('0','gagal'));
    }
//    $query = "INSERT into pilihan_jurusan(no_peserta,id_jurusan,lulus) values(?,?,?)";
    $query = "INSERT into pilihan_jurusan(no_peserta,id_jurusan) values(?,?)";
    $total_jurusan = count($pilihan_jurusan); $lulus = '0';
    if ($stmt = mysqli_prepare($link, $query)) {
        for($i=0;$i<$total_jurusan;$i++){
//            mysqli_stmt_bind_param($stmt,'sii',$no_peserta,$pilihan_jurusan[$i],$lulus);
            mysqli_stmt_bind_param($stmt,'si',$no_peserta,$pilihan_jurusan[$i]);
            if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0', mysqli_stmt_error($stmt)));
        }
    } else return json_encode(new Result('0','gagal'));
    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}
function ubah_peserta($json) {
    $obj = json_decode(stripslashes($json));
    $no_peserta_old = $obj->{'no_peserta_old'};
    $no_peserta = $obj->{'no_peserta'};
    $nama = $obj->{'nama'};
    $alamat = $obj->{'alamat'};
    $telepon = $obj->{'telepon'};
    $keterangan = $obj->{'keterangan'};
    $pilihan_jurusan = $obj->{'pilihan_jurusan'};
    if($no_peserta_old==null || $no_peserta==null || $nama==null || $pilihan_jurusan==null){
        return json_encode(new Result('0','Json tidak lengkap'));
    }
    $query = "UPDATE peserta SET no_peserta=?,nama=?,alamat=?,telepon=?,keterangan=? WHERE no_peserta=?";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'ssssss',$no_peserta,$nama,$alamat,$telepon,$keterangan,$no_peserta_old);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
    } else return json_encode(new Result('0','gagal'));
    $query = "DELETE from pilihan_jurusan WHERE no_peserta=?";
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'s',$no_peserta_old);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0', mysqli_stmt_error($stmt)));
    } else return json_encode(new Result('0','gagal'));

//    $query = "INSERT into pilihan_jurusan(no_peserta,id_jurusan,lulus) values(?,?,?)";
    $query = "INSERT into pilihan_jurusan(no_peserta,id_jurusan) values(?,?)";
    $total_jurusan = count($pilihan_jurusan); $lulus = '0';
    if ($stmt = mysqli_prepare($link, $query)) {
        for($i=0;$i<$total_jurusan;$i++){
//            mysqli_stmt_bind_param($stmt,'sii',$no_peserta,$pilihan_jurusan[$i],$lulus);
            mysqli_stmt_bind_param($stmt,'si',$no_peserta,$pilihan_jurusan[$i]);
            if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0', mysqli_stmt_error($stmt)));
        }
    } else return json_encode(new Result('0','gagal'));

    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}
function hapus_peserta($json) {
    $obj = json_decode(stripslashes($json));
    $no_peserta = $obj->{'no_peserta'};
    $query = "DELETE FROM peserta WHERE no_peserta=$no_peserta";
    $result = mysql_query($query);
    if($result){
        return json_encode(new Result('1','sukses'));
    } else return json_encode(new Result('0','gagal query'));
}

//SOAL
function tambah_soal($json) {
    $obj = json_decode(stripslashes($json));
    $id_kategori = $obj->{'id_kategori'};
    $isi_soal = $obj->{'isi_soal'};
    $jawaban = $obj->{'jawaban'};
    if($id_kategori==null || $isi_soal==null || $jawaban==null){
        return json_encode(new Result('0','Json tidak lengkap1'));
    }
    $query = "INSERT into soal(id_kategori,isi_soal) values(?,?)";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'is',$id_kategori,$isi_soal);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
    } else return json_encode(new Result('0','gagal prepare'));
    $last_id = mysqli_stmt_insert_id($stmt);
    $total_jawaban = count($jawaban);
    $query = "INSERT into jawaban(id_soal,jawaban,benar) values(?,?,?)";
    if ($stmt = mysqli_prepare($link, $query)) {
        for($i=0;$i<$total_jawaban;$i++){
            mysqli_stmt_bind_param($stmt,'isi',$last_id,$jawaban[$i]->{'jawab'},$jawaban[$i]->{'benar'});
            if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
        }
    } else return json_encode(new Result('0','gagal prepare'));
    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}
function ubah_soal($json) {
    $obj = json_decode(stripslashes($json));
    $id_soal = $obj->{'id_soal'};
    $id_kategori = $obj->{'id_kategori'};
    $isi_soal = $obj->{'isi_soal'};
    $jawaban = $obj->{'jawaban'};
    if($id_soal==null || $id_kategori==null || $isi_soal==null || $jawaban==null){
        return json_encode(new Result('0','Json tidak lengkap1'));
    }
    $query = "UPDATE soal SET id_kategori=?,isi_soal=? WHERE id_soal=?";
    $link = mysqli_connect(server,username,password,database);
    if ($stmt = mysqli_prepare($link, $query)) {
        mysqli_stmt_bind_param($stmt,'isi',$id_kategori,$isi_soal,$id_soal);
        if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
    } else return json_encode(new Result('0','gagal prepare'));
    $total_jawaban = count($jawaban);
    $query = "UPDATE jawaban SET id_soal=?,jawaban=?,benar=? WHERE id_soal=? AND id_jawaban=?";
    if ($stmt = mysqli_prepare($link, $query)) {
        for($i=0;$i<$total_jawaban;$i++){
            mysqli_stmt_bind_param($stmt,'isiii',$id_soal,$jawaban[$i]->{'jawab'},$jawaban[$i]->{'benar'},$id_soal,$jawaban[$i]->{'id_jawaban'});
            if(!mysqli_stmt_execute($stmt)) return json_encode(new Result('0','gagal execute'));
        }
    } else return json_encode(new Result('0','gagal prepare'));
    mysqli_stmt_close($stmt);
    return json_encode(new Result('1','sukses'));
}
function hapus_soal($json) {
    $obj = json_decode(stripslashes($json));
    $id_soal = $obj->{'id_soal'};
    $sukses = false;
    $query = "DELETE FROM soal WHERE id_soal=$id_soal";
    $query2 = "DELETE FROM jawaban WHERE id_soal=$id_soal";
    $result = mysql_query($query);
    $result2 = mysql_query($query2);
    if($result && $result2){
        return json_encode(new Result('1','sukses'));
    } else return json_encode(new Result('0','gagal query'));
}
function get_jawaban_soal($json) {
    $obj = json_decode(stripslashes($json));
    $where = $obj->{'where'}; //user='username'
    $limit = $obj->{'limit'};
    $query = "SELECT * from jawaban";
    if($where!=null){
        $total_where = count($where);
        for($i=0;$i<$total_where;$i++){
            if($i==($total_where-1) && $i==0){
                $query .= ' WHERE '.$where[$i];
                break;
            }
            if($i==($total_where-1)){
                $query .= ' '.$where[$i];
                break;
            }
            if($i==0){
                $query .= " WHERE ";
            }
            $query .= $where[$i] . ' && ';
        }
    }
    $query .= ' order by id_jawaban';
    if($limit!=null){
        $posisi = $limit->{'posisi'};
        $batas = $limit->{'batas'};
        $query .= " LIMIT $posisi,$batas";
    }
    $result = mysql_query($query);
    if($result){
        $jawabans = array(); $i=0;
        while ($row = mysql_fetch_array($result)) {
            $id_jawaban = $row['id_jawaban'];
            $id_soal = $row['id_soal'];
            $jawab = $row['jawaban'];
            $benar = $row['benar'];
            $jawaban = new Jawaban($id_jawaban, $id_soal, $jawab, $benar);
            $jawabans[$i] = $jawaban;
            $i++;
        }
        return json_encode($jawabans);
    } else return json_encode(new Result('0','gagal query'));
    return $query;
}
?>
