<?php
class Result {
    var $status = '';
    var $fullMessage = '';

    function __construct($status, $fullMessage) {
        $this->status = $status;
        $this->fullMessage = $fullMessage;
    }

    public function getStatus(){
        return $this->status;
    }

    public function setStatus($status){
        $this->status = $status;
    }

    public function getFullMessage(){
        return $this->fullMessage;
    }

    public function setFullMessage($fullMessage){
        $this->fullMessage = $fullMessage;
    }
}

class User {
    var $id_admin;
    var $username;
    var $password;
    var $nama;
    var $telepon;
    var $alamat;
    var $role;

//    function __construct() {
//
//    }

    function __construct($id_admin,$username,$password,$nama,$telepon,$alamat,$role) {
        $this->id_admin = $id_admin;
        $this->username = $username;
        $this->password = $password;
        $this->nama = $nama;
        $this->telepon = $telepon;
        $this->alamat = $alamat;
        $this->role = $role;
    }

    public function get_id_admin(){
        return $this->id_admin;
    }

    public function set_id_admin($id_admin){
        $this->id_admin = $id_admin;
    }

    public function get_username(){
        return $this->username;
    }

    public function set_username($username){
        $this->username = $username;
    }

    public function get_password(){
        return $this->password;
    }

    public function set_password($password){
        $this->password = $password;
    }

    public function get_nama(){
        return $this->nama;
    }

    public function set_nama($nama){
        $this->nama = $nama;
    }

    public function get_telepon(){
        return $this->telepon;
    }

    public function set_telepon($telepon){
        $this->telepon = $telepon;
    }

    public function get_alamat(){
        return $this->alamat;
    }

    public function set_alamat($alamat){
        $this->alamat = $alamat;
    }

    public function get_role(){
        return $this->role;
    }

    public function set_role($role){
        $this->role = $role;
    }
}

class Jurusan {
    var $id_jurusan;
    var $nama_jurusan;
    var $daya_tampung;

    function __construct($id_jurusan, $nama_jurusan) {
        $this->id_jurusan = $id_jurusan;
        $this->nama_jurusan = $nama_jurusan;
        $this->daya_tampung = 0;
    }
    
    public static function jurusan($id_jurusan, $nama_jurusan, $daya_tampung){
        $jurusan = new Jurusan($id_jurusan, $nama_jurusan);
        $jurusan->set_daya_tampung($daya_tampung);
        return $jurusan;
    }

    public function get_id_jurusan() {
        return $this->id_jurusan;
    }
    
    public function set_id_jurusan($id_jurusan) {
        $this->id_jurusan = $id_jurusan;
    }
    
    public function get_nama_jurusan() {
        return $this->nama_jurusan;
    }
    
    public function set_nama_jurusan($nama_jurusan) {
        $this->nama_jurusan = $nama_jurusan;
    }
    
    public function get_daya_tampung(){
        return $this->daya_tampung;
    }
    
    public function set_daya_tampung($daya_tampung){
        $this->daya_tampung = $daya_tampung;
    }
}

class GradeJurusan extends Jurusan{
    var $id_grade;
    var $batas_grade;

    function __construct($id_jurusan,$nama_jurusan,$id_grade,$batas_grade) {
        $this->id_jurusan = $id_jurusan;
        $this->nama_jurusan = $nama_jurusan;
        $this->id_grade = $id_grade;
        $this->batas_grade = $batas_grade;
    }

    public function get_id_grade() {
        return $this->id_grade;
    }

    public function set_id_grade($id_grade) {
        $this->id_grade = $id_grade;
    }

    public function get_batas_grade() {
        return $this->batas_grade;
    }

    public function set_batas_grade($batas_grade) {
        $this->batas_grade = $batas_grade;
    }
}

class Kategori {
    var $id_kategori;
    var $nama_kategori;
    var $waktu;
    var $jumlah_soal;

    function __construct($id_kategori,$nama_kategori,$waktu,$jumlah_soal) {
        $this->id_kategori = $id_kategori;
        $this->nama_kategori = $nama_kategori;
        $this->waktu = $waktu;
        $this->jumlah_soal = $jumlah_soal;
    }

    public function get_id_kategori() {
        return $this->id_kategori;
    }

    public function set_id_kategori($id_kategori) {
        $this->id_kategori = $id_kategori;
    }

    public function get_nama_kategori() {
        return $this->nama_kategori;
    }

    public function set_nama_kategori($nama_kategori) {
        $this->nama_kategori = $nama_kategori;
    }

    public function get_waktu() {
        return $this->waktu;
    }

    public function set_waktu($waktu) {
        $this->waktu = $waktu;
    }

    public function get_jumlah_soal() {
        return $this->jumlah_soal;
    }

    public function set_jumlah_soal($jumlah_soal) {
        $this->jumlah_soal = $jumlah_soal;
    }
}

class StatusKategori extends Kategori{
    var $sudah = false;
    var $nilai = 0;

    function __construct($id_kategori,$nama_kategori,$waktu,$jumlah_soal) {
        $this->id_kategori = $id_kategori;
        $this->nama_kategori = $nama_kategori;
        $this->waktu = $waktu;
        $this->jumlah_soal = $jumlah_soal;
        $this->sudah = false;
    }

    public function get_sudah() {
        return $this->sudah;
    }

    public function set_sudah($sudah) {
        $this->sudah = $sudah;
    }

    public function get_nilai() {
        return $this->nilai;
    }

    public function set_nilai($nilai) {
        $this->nilai = $nilai;
    }
}

class Jawaban {
    var $id_jawaban;
    var $id_soal;
    var $jawaban;
    var $benar;

    function __construct($id_jawaban,$id_soal,$jawaban,$benar) {
        $this->id_jawaban = $id_jawaban;
        $this->id_soal = $id_soal;
        $this->jawaban = $jawaban;
        $this->benar = $benar;
    }

    public function get_id_jawaban() {
        return $this->id_jawaban;
    }

    public function set_id_jawaban($id_jawaban) {
        $this->id_jawaban = $id_jawaban;
    }

    public function get_id_soal() {
        return $this->id_soal;
    }

    public function set_id_soal($id_soal) {
        $this->id_soal = $id_soal;
    }

    public function get_jawaban() {
        return $this->jawaban;
    }

    public function set_jawaban($jawaban) {
        $this->jawaban = $jawaban;
    }

    public function get_benar() {
        return $this->benar;
    }

    public function set_benar($benar) {
        $this->benar = $benar;
    }
}

class Soal {
    var $id_soal;
    var $id_kategori;
    var $isi_soal;
    var $jawabans;

    function __construct($id_soal,$id_kategori,$isi_soal,$jawabans) {
        $this->id_soal = $id_soal;
        $this->id_kategori = $id_kategori;
        $this->isi_soal = $isi_soal;
        $this->jawabans = $jawabans;
    }

    public function get_id_soal() {
        return $this->id_soal;
    }

    public function set_id_soal($id_soal) {
        $this->id_soal = $id_soal;
    }

    public function get_id_kategori() {
        return $this->id_kategori;
    }

    public function set_id_kategori($id_kategori) {
        $this->id_kategori = $id_kategori;
    }

    public function get_isi_soal() {
        return $this->isi_soal;
    }

    public function set_isi_soal($isi_soal) {
        $this->isi_soal = $isi_soal;
    }

    public function get_jawabans() {
        return $this->jawabans;
    }

    public function set_jawabans($jawabans) {
        $this->jawabans = $jawabans;
    }
}
?>
