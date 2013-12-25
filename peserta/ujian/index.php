<?php
session_start();
if(!isset($_SESSION['no_peserta'])){
    header('location:../login-peserta.php');
}
include '../../inc/config.php';
include 'load_kategori.php';
include 'my_lcg.php';
include 'load_soal.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
<!--        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">-->
        <meta charset="utf-8">
        <title>Ujian <?php echo $current_kategori->nama_kategori;?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../bootstrap/img/komputer.ico"/>

        <link href="../../bootstrap/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
        <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../../bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
        <link href="../../bootstrap/css/smoothness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
        <link href="../../bootstrap/css/mystyle.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            body {
                background-image: url('../../bootstrap/img/grey.png');
            }
        </style>
        <script type="text/javascript" src="../../bootstrap/js/jquery.js"></script>
        <script type="text/javascript" src="../../bootstrap/js/jquery.json-2.4.js"></script>
        <script type="text/javascript" src="../../bootstrap/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="../../bootstrap/js/jquery-ui-1.10.3.custom.js"></script>
        <script type="text/javascript" src="../../bootstrap/js/jquery.validationEngine-en.js"></script>
        <script type="text/javascript" src="../../bootstrap/js/jquery.validationEngine.js"></script>
        <!--<script type="text/javascript" src="../../bootstrap/js/jquery.countdown.js"></script>-->
        <script type="text/javascript" src="../../bootstrap/js/jquery.countdown1.6.3.js"></script>
    </head>
    <body>
<?php
include 'header.php';
?>
<script type="text/javascript">
    function submit_ujian(){
        var dat = [];
        $(".isi_soal").each(function(i, obj){
            var id = $(obj).attr("id");
            var id_soal = id.substr(4, id.length);
            var id_jawaban = "";
            $("#jwb_soal"+id_soal).find('input:checked').each(function(i, input){
                if($(input).is(':checked')){
                    var id = $(input).attr("id");
                    id_jawaban = id.substr(3, id.length);
                    return false;
                }
            })
            dat.push({
                id_soal:id_soal,
                id_jawaban:id_jawaban
            })
        })
        var data = {
            no_peserta:$("#temp_no_peserta").val(),
            id_kategori:$("#temp_id_kategori").val(),
            ujian:dat
        }
        $.ajax({
            url: 'ujianResource.php',
            data: {
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            statusCode: {
                404: function() {
                    alert("page not found");
                }
            },
            success: function(data, status, xhr){
//                alert(data)
                var result = $.parseJSON(data);
                if(result==null){
                    alert("Problem dengan server");
                }else
                    if(result.status=='1') location.reload();
                    else {
                        alert("Problem dengan server");
                    }
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
        return false;
    }
    function jwbClick(obj){
        var id = $(obj).attr('id');
        var ori_id = id.substr(0, id.length-1);
        var num = id.substr(id.length-1, 1);
        switch (num) {
            case '1':
                $("#"+ori_id+'2').find('input').prop('checked',false);
                $("#"+ori_id+'3').find('input').prop('checked',false);
                $("#"+ori_id+'4').find('input').prop('checked',false);
                break;
            case '2':
                $("#"+ori_id+'1').find('input').prop('checked',false);
                $("#"+ori_id+'3').find('input').prop('checked',false);
                $("#"+ori_id+'4').find('input').prop('checked',false);
                break;
            case '3':
                $("#"+ori_id+'1').find('input').prop('checked',false);
                $("#"+ori_id+'2').find('input').prop('checked',false);
                $("#"+ori_id+'4').find('input').prop('checked',false);
                break;
            case '4':
                $("#"+ori_id+'1').find('input').prop('checked',false);
                $("#"+ori_id+'2').find('input').prop('checked',false);
                $("#"+ori_id+'3').find('input').prop('checked',false);
                break;
            default:
                break;
        }
//        $no_peserta = $("#temp_no_peserta").val();
//        $id_kategori = $("#temp_id_kategori").val();
        $id_soal = id.substr(0, id.indexOf('jwb'));
        $id_jawaban = $(obj).find('input').prop('id').substr(3);
        var data = {
            no_peserta:$("#temp_no_peserta").val(),
            id_kategori:$("#temp_id_kategori").val(),
            id_soal:$id_soal,
            id_jawaban:$id_jawaban
        }
        $.ajax({
            url: 'submitJawaban.php',
            data: {
                json:jQuery.toJSON(data)
            },
            cache: false,
            type: 'POST',
            statusCode: {
                404: function() {
                    alert("page not found");
                }
            },
            success: function(data, status, xhr){
//                alert(data)
                var result = $.parseJSON(data);
                if(result==null){
                    alert("Problem dengan server");
                }else
                    if(result.status=='1') {
//                        location.reload();
                    } else {
                        alert("Problem dengan server");
                    }
            },
            error: function(xhr, status, errorMsg){
                alert(errorMsg);
            }
        });
//        alert($no_peserta+" "+$id_kategori+" "+$id_soal+" "+$id_jawaban);
        $(obj).find('input').prop('checked',true);
    }
</script>
        <div class="well" style="width: 1200px; margin:10px auto;">
            <?php
            if($current_kategori==null){

            ?>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand" href="#" onclick="return false;">Hasil Ujian</a>
                    </div>
                </div><!-- /navbar-inner -->
            </div>
            <span>Nomor Peserta : <?php echo $_SESSION['no_peserta'];?></span><br/>
            <span>Nama Peserta : <?php echo $_SESSION['nama'];?></span><br/>
            <?php
            $jumlah_nilai = 0;
            for($i=0;$i<$jum;$i++){
                $jumlah_nilai += $status_kategoris[$i]->get_nilai();
            ?>
            <span>Kategori <?php echo $status_kategoris[$i]->get_nama_kategori().' : '.$status_kategoris[$i]->get_nilai();?></span>
            <br/>
            <?php } ?>
            <span>Nilai Akhir : <?php echo $jumlah_nilai/$jum;?></span><br/><br/>
            <span>Untuk Melihat Hasil kelulusan bisa menghubungi admin dengan menyertakan nomer pendaftaran.</span>
            <?php
//            $query = "select pj.no_peserta,pj.id_jurusan,
//(CASE WHEN nilai<g.batas_grade
//THEN 0 ELSE 1 END) as lulus,j.nama_jurusan
//from peserta p,pilihan_jurusan pj,jurusan j,grade g
//where p.no_peserta=pj.no_peserta and pj.id_jurusan=j.id_jurusan and j.id_jurusan=g.id_jurusan
//and p.no_peserta='{$_SESSION['no_peserta']}'";
//            $result = mysql_query($query);
//            while ($row = mysql_fetch_array($result)) {
//                $lulus =  $row['lulus'];
//                $nama_jurusan = $row['nama_jurusan'];
//                if($lulus){
//                    echo '<span>Anda diterima di jurusan '.$nama_jurusan.'</span><br/>';
//                } else {
//                    echo '<span>Anda tidak diterima di jurusan '.$nama_jurusan.'</span><br/>';
//                }
//            }
            ?>
            <?php } else {
            if(isset ($_SESSION['mulai'])){
                $telah_berlalu = time() - $_SESSION['mulai'];
            } else {
                $_SESSION['mulai'] = time();
                $telah_berlalu = 0;
            }
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function () {
                    var longWayOff = "<?php echo ($current_kategori->get_waktu() * 60) - $telah_berlalu ?>";
	            if(parseInt(longWayOff) <= 0 ){
                        submit_ujian();
	            } else {
	                $("#timework").countdown({
                            until: longWayOff,
                            compact:true,
                            onExpiry:submit_ujian,
                            onTick: hampirHabis
                        });
                    }
                });
                function hampirHabis(periods){
	            if($.countdown.periodsToSeconds(periods) == 60){
		        $(this).css({color:"red"});
		    }
	        }
            </script>
            <div class="navbar">
                <div class="navbar-inner">
                    <div class="container">
                        <a class="brand" href="#" onclick="return false;">Ujian Kategori <?php echo $current_kategori->nama_kategori;?></a>
                    </div>
                </div><!-- /navbar-inner -->
            </div>
            <input type="hidden" id="temp_id_kategori" value="<?php echo $current_kategori->id_kategori;?>"/>
            <input type="hidden" id="temp_no_peserta" value="<?php echo $_SESSION['no_peserta'];?>"/>
            <div class="my_wrapper">
            <div class="left_page">
            <ol type="1" class="soal">
                <?php
                $jml_soals = count($newSoals);
                $jml_kiri = $jml_soals/2;
                if($jml_soals%2!=0){
                    $jml_kiri = intval($jml_kiri)+1;
                }
                for($i=0;$i<$jml_kiri;$i++){
                    $soal = $newSoals[$i];
//                foreach($newSoals as $soal){
                ?>
                <li>
                    <div id="soal<?php echo $soal->id_soal;?>" class="isi_soal"><?php echo $soal->isi_soal; ?></div>
                    <ul id="<?php echo 'jwb_soal'.$soal->id_soal;?>" class="jawaban" >
                        <?php
                        $jawabans = $soal->jawabans; $id_jwb = 1;
                        foreach ($jawabans as $jawaban) {
                        ?>
                        <li id="<?php echo $jawaban->get_id_soal().'jwb'.$id_jwb;?>" onclick="jwbClick(this);">
                            <input id="<?php echo 'jwb'.$jawaban->id_jawaban;?>" type="checkbox" value="Algo" <?php echo (strpos($jawaban->id_jawaban, '.') === 0)?'checked':''; ?>/><span><?php echo $jawaban->jawaban;?></span>
                        </li>
<!--                        <li id="chk2" onclick="jwbClick(this);"><input type="checkbox" value="Algo2"/><span>Algo2</span></li>
                        <li id="chk3" onclick="jwbClick(this);"><input type="checkbox" value="Algo3"/><span>Algo3</span></li>
                        <li id="chk4" onclick="jwbClick(this);"><input type="checkbox" value="Algo4"/><span>Algo4</span></li>-->
                        <?php $id_jwb++; } ?>
                    </ul>
                </li>
                <?php } ?>
            </ol>
            </div>
            <div class="right_page">
                <ol type="1" class="soal" start="<?=$jml_kiri+1?>">
                    <?php for($i=$jml_kiri;$i<$jml_soals;$i++){
                        $soal = $newSoals[$i];
                    ?>
                    <li>
                    <div id="soal<?php echo $soal->id_soal;?>" class="isi_soal"><?php echo $soal->isi_soal; ?></div>
                    <ul id="<?php echo 'jwb_soal'.$soal->id_soal;?>" class="jawaban" >
                        <?php
                        $jawabans = $soal->jawabans; $id_jwb = 1;
                        foreach ($jawabans as $jawaban) {
                        ?>
                        <li id="<?php echo $jawaban->get_id_soal().'jwb'.$id_jwb;?>" onclick="jwbClick(this);">
                            <input id="<?php echo 'jwb'.$jawaban->id_jawaban;?>" type="checkbox" value="Algo" <?php echo (strpos($jawaban->id_jawaban, '.') === 0)?'checked':''; ?>/><span><?php echo $jawaban->jawaban;?></span>
                        </li>
                        <?php $id_jwb++; } ?>
                    </ul>
                    </li>
                    <?php } ?>
                </ol>
            </div>
            </div>
            <div style="clear: both;"></div>
            <div class="btn-group pull-right" style="bottom: 20px; right: -8px;">
                <button class="btn btn-primary" onclick="return submit_ujian();">
                    <i class="icon-user icon-white"></i> Next
                </button>
            </div>
            <?php } ?>
        </div>
<?php
include '../../admin/inc/tampilan/footer.php';
?>
    </body>
</html>
