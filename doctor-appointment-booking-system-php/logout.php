<?php 
session_start();
$_SESSION["userid"] = '';
session_destroy;
header("Location:index.php");
?>






