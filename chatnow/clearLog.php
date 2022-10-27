<?php

session_start();

if($_GET['delete'] == "true" && isset($_GET['botID'])){

	//Update the DB:
	include('db.php');
	$botID = $_GET['botID'];
	$table = "botconversations";
	
	mysqli_query($connection,"UPDATE $table SET 
		REVIEWED='1'
		WHERE BOTID='$botID'");
	
	//echo '<script>alert(\'Logs Deleted!\'); window.location.replace("botTrainer.php?botID='.$botID.'");</script>';
	exit();
}
?>