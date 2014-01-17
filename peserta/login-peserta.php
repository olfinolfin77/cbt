<?php
session_start();
require '../inc/config.php';
if($_SESSION['no_peserta']!=null || $_SESSION['no_peserta']!=''){
    header('location:ujian');
}
if(isset ($_POST['noPendaftaran'])){

$no_peserta = $_POST['noPendaftaran'];
$query = "select no_peserta,nama,nilai from peserta where no_peserta='$no_peserta'";
$result = pg_query($query);
$boleh_login = true;
if(pg_num_rows($result)){
    while ($row = pg_fetch_array($result)) {
        if($row['nilai'] != '-1'){
            $boleh_login = false;
            $error = "Nomor Peserta <b>$no_peserta</b> telah ujian";
            break;
        }
        $_SESSION['no_peserta'] = $row['no_peserta'];
        $_SESSION['nama'] = $row['nama'];
    }
    if($boleh_login) header('location:ujian');
} else {
    $error = "Nomor Peserta <b>$no_peserta</b> belum terdaftar";
}

}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Computer Based Test</title>
    <link rel="shortcut icon" href="../bootstrap/img/komputer.ico"/>
    <link href="../bootstrap/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap/css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../bootstrap/js/jquery.js"></script>
    <script type="text/javascript" src="../bootstrap/js/jquery.validationEngine-en.js"></script>
    <script type="text/javascript" src="../bootstrap/js/jquery.validationEngine.js"></script>
    <style type="text/css">
        body {
            background-image: url('../bootstrap/img/grey.png');
        }
    </style>
    
    <script type="text/javascript">
        jQuery(document).ready(function () {
// binds form submission and fields to the validation engine
            jQuery("#formLoginPeserta").validationEngine();
        });
    </script>
</head>
<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">

            <a class="brand" href="#">Computer Based Test</a>

            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="">
                        <a href="#"></a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 100px">

    <div class="row">

        <div align="center">
            <h2>Selamat Datang </h2>
            <h3> Panduan Computer Based Tes Potensi Akademik (TPA)</h3>
            <p style="font-size: 14px">
            Soal terdiri dari 4 bidang yaitu : Verbal , Numerik, Logikal, dan Gambar. <br/>
            Tiap-tiap bidang dibatasi oleh waktu. <br/>
            Bila waktu ditiap bidang habis maka akan secara otomatis melanjutkan ke bidang selanjutnya.<br/>
            Gunakan waktu yang tersedia seefektif mungkin. <br/>
            </p>
        </div>
        <div class="span4 offset4">
            <form id="formLoginPeserta" action="" method="POST">
                <div style="margin:0;padding:0;display:inline">
                </div>
                <fieldset>
                    <div class="well" style=" margin-left: -34px; margin-top: 34px;">

                        <a href="#" class="btn btn-large btn-primary">
                            PANEL PESERTA</a>

                        <hr style="border-color: #ccc;">


                        <div class="control-group ">
                            <div class="controls">
                                <input id="noPendaftaran" name="noPendaftaran" type="text"
                                       class="span2 validate[required] text-input" type="text"
                                       placeholder="No Pendaftaran"/>
                            </div>
                        </div>


                        <div class="form-actions"
                             style="border: 0; background-color: #f5f5f5; margin: 30px 0 0 0; padding: 0;">
                            <button type="submit" class="btn btn-danger"><i class="icon-ok-sign icon-white"></i> Mulai
                            </button>
                            <?php if($error) { ?>
                            <div id="divpesanerror" >
                                <center><?php echo $error; ?></center>
                            </div>
                            <?php } ?>
                        </div>

                    </div>
                </fieldset>
            </form>
        </div>

    </div>
    
</div>
</body>
</html>