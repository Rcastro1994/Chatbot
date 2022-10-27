<?php

session_start();

if($_GET['delete'] == "true" && isset($_GET['botID']) && isset($_GET['lineID'])){

	//Update the DB:
	include('db.php');
	$botID = $_GET['botID'];
	$lineID = $_GET['lineID'];
	$table = "botknowledge";
	mysqli_query($connection,"DELETE FROM $table WHERE BOTID = '$botID' AND ID='$lineID'");
	echo '<script>alert(\'Knowledge Deleted!\'); window.location.replace("botTrainer.php?botID='.$botID.'");</script>';
	exit();
}
if($_GET['redirect'] != 0){
	echo '<script>window.location.replace("index.php");</script>';
}
?>