<?php
$username = $_GET['username'];
unset($_SESSION["pdau_id"]);
header("Location:../index?username=".''.$username);
?>