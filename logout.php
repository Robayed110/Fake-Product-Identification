<?php
session_start();
unset($_SESSION['IS_LOGIN']);
header('location: login.php');
echo '<script>window.location.replace("login.php");</script>';
die();
?>