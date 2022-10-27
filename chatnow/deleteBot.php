<?php

session_start();

//Are you logged in?
include('authCheck.php');

if($_GET['delete'] == "true" && isset($_GET['botID'])){

	//Update the DB:
	include('db.php');
	$saveID = $_GET['botID'];
	$table = "botlist";
	mysqli_query($connection,"UPDATE $table SET BOTSTATUS = '0' WHERE ID='$saveID'");
	echo '<script>alert(\'Chat Bot Deleted!\'); window.location.replace("index.php");</script>';
}
echo '<script>window.location.replace("index.php");</script>';
?>