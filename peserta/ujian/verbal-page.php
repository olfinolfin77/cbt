<?php
include '../../inc/config.php';
session_start();
$sql_ujian = "select * from ujian j inner join kategori k on j.id_kategori=k.id_kategori where id_ujian = '1'";
$sql_ujian_exe = mysql_query($sql_ujian);
$data_ujian = mysql_fetch_assoc($sql_ujian_exe);
if(isset($_SESSION["waktu"])){
	$telah_berlalu = time() - $_SESSION["waktu"];
	}
else {
	$_SESSION["waktu"] = time();
	$telah_berlalu = 0;
	}	
?>

<html>
    <meta charset="utf-8">
    <title>Computer Based-Test</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <link href="../../bootstrap/css/style.css" rel="stylesheet" type="text/css">
    <style type="text/css">
        body {
            background-image: url('../../bootstrap/img/grey.png');
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap-stack.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/jquery.ui.all.css">
    <script src="../../bootstrap/js/jquery.js "></script>
    <script src="../../bootstrap/js/highcharts.js"></script>
    <script src="../../bootstrap/js/exporting.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="../../bootstrap/js/jquery.countdown.js"></script>
  </head>
        
    <body>
       <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">

            <a class="brand" href="#">CBT UNITOMO</a>
            
            <a class="">
            <div id="tempat_timer" style="margin:1px auto;">
<span id="timer">00 : 00 : 00</span>
</div>
                </a>
      
            <div class="nav-collapse collapse">
                <ul class="nav pull-right">
                    <li>
                        <a href="">                        
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

        
<div class="container well" style="width: 1200px; margin:10px auto;">
<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="#">Soal Verbal</a>

            <div class="nav-collapse">

                <ul class="nav pull-right">
                    <li>
                        <a href="#" style="font-size: 15px">
                            <script language="JavaScript" src="../../resources/js/countdown.js"></script>
                    
                        </a>

                    </li>
                    
                    <li class="">
                        <a href="${url_hasil}">
                            <button class="badge badge-error" >LANJUT SOAL NUMERIK</button>
                        </a>
                        
                    </li>
                </ul>


            </div>
            <!-- /.nav-collapse -->
        </div>
    </div>
    <!-- /navbar-inner -->
</div>
</div>
</div>
        <script src="../../bootstrap/js/bootstrap.js"></script>
        <script src="../../bootstrap/js/bootstrap-stack.js"></script>

    </body> 
    
    <script type="text/javascript">
function waktuHabis(){
	alert("selesai dikerjakan ......");	
    }		
function hampirHabis(periods){
	if($.countdown.periodsToSeconds(periods) == 60){
		$(this).css({color:"red"});
		}
	}
$(function(){
	// var waktu = 180; // 3 menit
	
        var sisa_waktu = "<?php echo ($data_ujian['waktu'] * 60) - $telah_berlalu ?>";
	var longWayOff = sisa_waktu;
	$("#timer").countdown({
		until: longWayOff,
		compact:true,
		onExpiry:waktuHabis,
		onTick: hampirHabis
		});	
	})
</script>
<style>
#tempat_timer{
	margin:0 auto;
	text-align:center;
	}
#timer{
	border-radius:3px;
	border:2px solid gray;
	padding:3px;
	font-size:2em;
	font-weight:bolder;
	}
</style>
</html>
