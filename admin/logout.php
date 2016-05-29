<?php
session_start();
session_destroy();
$_SESSION[] = array();
setcookie('kgka44sdfKJ',' ',time()-3600,'/');
header('Location:../index.php');

?>