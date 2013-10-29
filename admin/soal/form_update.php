<?php
require_once '../../inc/config.php';
require_once ('./function.php');
// $username = $_GET['username'];

$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : null;
$id_soal = isset($_GET['id_soal']) ? $_GET['id_soal'] : null;
//atau:
//$page = isset($_GET['page']) ? $_GET['page'] : false;
//atau bisa juga dengan:
//$page = isset($_GET['page']) ? $_GET['page'] : "";

$query = "SELECT * FROM soal s inner join kategori k on s.id_kategori=k.id_kategori WHERE id_soal='$id_soal'";
$result = mysql_query($query) or die(mysql_error());
$data = mysql_fetch_array($result) or die(mysql_error());


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
				background: url('../../bootstrap/img/grey.png') repeat;
			}
			.atas {
				padding-top: 9px;
			}
			label.error {
				color: red;
			}
		</style>
                <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet">
                <link href="../../bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
                <link href="../../bootstrap/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
                <script type="text/javascript" src="../../bootstrap/js/jquery-1.8.3.min.js"></script>
                <script type="text/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>
                <script type="text/javascript" src="../../bootstrap/js/jquery.validationEngine-en.js"></script>
                <script type="text/javascript" src="../../bootstrap/js/jquery.validationEngine.js"></script>
		<!-- <link href="../assets/img/favicon.png" rel="shortcut icon" /> -->

		
    <script type="text/javascript">
        jQuery(document).ready(function () {
// binds form submission and fields to the validation engine
            jQuery("#formupdate").validationEngine();
        });
    </script>
  </head>

  <body>
      <div class="well" style="width: 1200px; margin:10px auto;"> 
      <div class="container">
           
          <form action="update.php" method="post" id="formupdate" name="formupdate">
            <a href="index.php?halaman=1" <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></a>
            <legend>Ubah Data Soal</legend>
            <input type="hidden" name="id_soal" value="<?php echo $id_soal; ?>" />
            <div class="control-group">
            <label class="control-label" for="nama">Kategori :</label>
            <div class="controls"><select name='id_kategori' id='id_kategori'>
                            <?php
                        combo_kategori($data ['id_kategori']);?>
					?>
	</select>
				
			</div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Pertanyaan :</label>
            <div class="controls">
                <input value="<?php echo $data['pertanyaan']; ?>" type="text" style="width:300px;" name="pertanyaan" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Jawaban A :</label>
            <div class="controls">
                <input value="<?php echo $data['pilihan_a']; ?>" type="text" style="width:300px;" name="pilihan_a" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Jawaban B :</label>
            <div class="controls">
                <input value="<?php echo $data['pilihan_b']; ?>" type="text" style="width:300px;" name="pilihan_b" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Jawaban C :</label>
            <div class="controls">
                <input value="<?php echo $data['pilihan_c']; ?>" type="text" style="width:300px;" name="pilihan_c" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Jawaban D:</label>
            <div class="controls">
            <input value="<?php echo $data['pilihan_d']; ?>" type="text" style="width:300px;" name="pilihan_d" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Jawaban :</label>
            <div class="controls">
                <input value="<?php echo $data['jawaban']; ?>" type="text" style="width:300px;" name="jawaban" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
			<button type="submit" class="btn btn-primary">
				<i class="icon icon-plus"></i> Simpan Data
			</button>
			<button type="reset" class="btn btn-warning">
				<i class="icon icon-refresh"></i> Batal
			</button>
		</div>
            
	</form>
</div>
</div>
  </body>
</html>
