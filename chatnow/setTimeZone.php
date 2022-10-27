<?php

session_start();

if(isset($_GET['timezone'])){
	$_SESSION['USERTIME'] = $_GET['timezone'];
}else{
	$_SESSION['USERTIME'] = "America/New_York";
}
?>