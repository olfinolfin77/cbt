<?php
include ('../../inc/config.php');
require_once ('./function.php');
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
            jQuery("#forminsert").validationEngine();
        });
    </script>

  </head>

  <body>
      <div class="well" style="width: 1200px; margin:10px auto;"> 
      <div class="container">
           
	<form action="insert.php" method="post" id="forminsert" name="forminsert">
            <a href="index.php?halaman=1" <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></a>
            <legend>Input Waktu</legend>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Kategori :</label>
            <div class="controls"><select name='id_kategori'id='id_kategori'>
					<?php		
                        combo_kategori($data -> id_kategori);?>
					?>
				</select>
				
			</div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Waktu :</label>
            <div class="controls">
            <input type="text" style="width:300px;" name="waktu" class="span2 validate[required,custom[integer]] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Keterangan :</label>
            <div class="controls">
                <textarea style="width:350px; height:100px;" name="keterangan" class="span2 validate[required] text-input"></textarea>
            </div>
            </div>
            
		<?php
		if (isset($_GET['halaman'])) {
			echo "<div id='form_alert' style='color:#DD1144' class='alert alert-success'>";
			echo "<a class='close' data-dismiss='alert' href='#'>x</a>Data berhasil disimpan!";
			echo "</div>";
		}
		?>

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
