<?php
if(!isset($_SESSION['userName'])){
	header('Location: login.php');
	exit;
}
?>