<?php 
session_start();
$_SESSION['aemail'] ="";
$_SESSION['apassword'] ="";
echo "<script>location.assign('/aroma/login.php')</script>";
?>