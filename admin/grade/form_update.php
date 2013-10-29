<?php
require_once '../../inc/config.php';

// $username = $_GET['username'];

$id_grade = isset($_GET['id_grade']) ? $_GET['id_grade'] : null;
//atau:
//$page = isset($_GET['page']) ? $_GET['page'] : false;
//atau bisa juga dengan:
//$page = isset($_GET['page']) ? $_GET['page'] : "";

$query = "SELECT * FROM grade_lulus WHERE id_grade='$id_grade'";
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
          <legend>Input Grade</legend>
          <a href="index.php?halaman=1" <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></a>
          <input type="hidden" name="id_grade" value="<?php echo $id_grade; ?>" />
          <div class="control-group">
          <label class="control-label" for="nama_hukuman">Jurusan :</label>
          <div class="controls">
                <select style="width:350px;" class="input-small" name="jurusan">
				<?php 
				// tampilkan untuk form ubah mahasiswa
				if($id > 0) { ?>
				<option value="<?php echo $data['jurusan']; ?>"><?php echo $data['jurusan']; ?></option>
				<?php } ?>
				<option value="Ekonomi">Ekonomi</option>
				<option value="Hukum">Hukum</option>
                                <option value="Sastra Inggris">Sastra Inggris</option>
                                <option value="Sastra Jepang">Sastra Jepang</option>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Teknik Sipil">Teknik Sipil</option>
			</select>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Batas Verbal :</label>
            <div class="controls">
            <input value="<?php echo $data['batas_verbal']; ?>"type="text" style="width:300px;" name="batas_verbal" class="span2 validate[required,custom[integer]] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Batas Numerik :</label>
            <div class="controls">
            <input value="<?php echo $data['batas_numerik']; ?>" type="text" style="width:300px;" name="batas_numerik" class="span2 validate[required,custom[integer]] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Batas Logika :</label>
            <div class="controls">
                <input value="<?php echo $data['batas_logika']; ?>"type="text" style="width:300px;" name="batas_logika" class="span2 validate[required,custom[integer]] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Batas Gambar :</label>
            <div class="controls">
                <input value="<?php echo $data['batas_gambar']; ?>"type="text" style="width:300px;" name="batas_gambar" class="span2 validate[required,custom[integer]] text-input">
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
