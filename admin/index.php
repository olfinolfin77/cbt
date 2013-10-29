<?php
session_start();
if($_SESSION['username']!=null || $_SESSION['username']!=''){
    header('location:MenuUtama.php');
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Computer-Based Test</title>
    <link href="../bootstrap/css/validationEngine.jquery.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap/css/style.css" rel="stylesheet" type="text/css">
    <!--<link href="../bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css">-->
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
            jQuery("#formLogin").validationEngine();
        });
    </script>
    
    </head>
<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">

            <a class="brand" href="#">Computer-Based Test</a>

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
        <div class="span4 offset4">
            <form action="login.php" method="post" id="formLogin" >
                <fieldset>
                    <div class="well">
                        <h3>LOGIN ADMIN</h3>
                        <hr style="border-color: #ccc;">
                        <div class="control-group ">
                            <div class="controls">
                                <input id="username" name="username" type="text" class="span2 validate[required] text-input"  type="text" placeholder="username"/>                           
                            </div>
                        </div>

                        <div class="control-group ">
                            <div class="controls">
                                <input id="password" name="password" type="password" class="span2 validate[required] text-input"  type="password" placeholder="password"/>
                            </div>
                        </div>
                        <div class="control-group ">
                            <div class="controls">
                        <select style="width:170px;" class="input-small" name="role">
				<option value="Admin IT">Admin IT</option>
				<option value="Operator">Operator</option>
			</select>
                            </div>
                        </div>
                        
                        <div class="form-actions" style="border: 0; background-color: #f5f5f5; margin: 30px 0 0 0; padding: 0;">
                            <button type="submit" class="btn btn-danger"><i class="icon-ok-sign icon-white"></i> Login</button>
                        </div>

                    </div>
                </fieldset>
            </form>    
        </div>
    </div>
</div>
    
		<?php
		if (isset($_GET['konfirmasi'])) {
                        echo "<div class='alert alert-error'>";
                        echo "<strong>Login Tidak Berhasil!</strong><br/>";
                        echo "Periksa kembali username dan password anda.";
                        echo "</div>";
                        }
		?>
    <div class="navbar navbar-fixed-bottom">
        <div class="navbar-inner">
            <p class="navbar-text">
                Copyright &copy; 2013. All Right Reserved.
                IT Corporation.
            </p>
        </div>
    </div>
</body>
</html>
