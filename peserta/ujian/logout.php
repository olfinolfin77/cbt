<?php
session_start();
session_unregister('no_peserta');
session_unregister('nama');
session_unset();
session_destroy();
header('location:../login-peserta.php');
?>
