<?php
session_start();

//Are you logged in?
include('authCheck.php');

$table = 'botknowledge';
$botID = $saveID;

if(isset($_POST['savebotID'])){
	$botID = $_POST['savebotID'];
	$updateID = $_POST['editID'];
}

//Use $deleteID

$userSays = $_POST['userSays2'];
$reply1 = $_POST['botReply1'];

include('db.php');

//Cleanup
$botQuestion = $connection->real_escape_string($userSays);
$botResponse = $connection->real_escape_string($reply1);

mysqli_query($connection,"UPDATE $table SET 
		QUESTION='$botQuestion',
		BOTRESPONSE='$botResponse'
		WHERE ID = '$updateID' AND BOTID='$botID'");
		$_SESSION['lastQuestion'] = $botQuestion;
		if(!isset($_POST['savebotID'])){
			echo '<script>alert(\'Knowledge updated!\'); window.location.replace("botTrainer.php?botID='.$botID.'");</script>';
		}else{
			echo '<script>alert(\'Knowledge updated!\');</script>';
		}

?>