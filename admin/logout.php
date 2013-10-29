<?php
session_start();
session_destroy();
include './inc/Constant.php';
header('Location:'.BASE_URL);
?> 