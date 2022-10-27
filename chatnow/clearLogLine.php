<?php

session_start();

if($_GET['delete'] == "true" && isset($_GET['botID']) && isset($_GET['logLine'])){

	//Update the DB:
	include('db.php');
	$botID = $_GET['botID'];
	$logLine = $_GET['logLine'];
	$table = "botconversations";
	
	mysqli_query($connection,"UPDATE $table SET 
		REVIEWED='1'
		WHERE BOTID='$botID' AND ID='$logLine'");
	
	//echo '<script>alert(\'Logs Deleted!\'); window.location.replace("botTrainer.php?botID='.$botID.'");</script>';
	exit();
}
?>