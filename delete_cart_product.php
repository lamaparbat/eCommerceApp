<?php
include 'connection.php';
session_start(); 
$id = $_POST["id"];
unset($_SESSION["cart"][$id]);
unset($_SESSION["quantity"][$id]);
?>