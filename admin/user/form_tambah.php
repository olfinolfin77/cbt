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
            jQuery("#formtambah").validationEngine();
        });
    </script>		
		
    
  </head>

  <body>
      <div class="well" style="width: 1200px; margin:10px auto;"> 
      <div class="container">
           
          <form action="insert.php" method="post" id="formtambah" name="formtambah">
            <a href="index.php?halaman=1" <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button></a>
              <legend>Input User</legend>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">User Name :</label>
            <div class="controls">  
            <input id ="username" type="text" style="width:300px;" name="username" class="validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Password :</label>
            <div class="controls">
                <input type="password" style="width:300px;" name="password" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Nama :</label>
            <div class="controls">
            <input  type="text" style="width:300px;" name="nama" class="span2 validate[required] text-input">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Telepon :</label>
            <div class="controls">
            <input type="text" style="width:300px;" name="telepon" class="span2 validate[required,custom[integer]] text-input" >
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Alamat :</label>
            <div class="controls">
                <textarea style="width:350px; height:100px;" name="alamat" class="span2 validate[required] text-input"></textarea>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="nama_hukuman">Role :</label>
            <div class="controls">
                <select style="width:350px;" class="input-small" name="role">
				<option value="Admin IT">Admin IT</option>
				<option value="Operator">Operator</option>
			</select>
            </div>
            </div>
		<?php
		if (isset($_GET['konfirmasi'])) {
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
