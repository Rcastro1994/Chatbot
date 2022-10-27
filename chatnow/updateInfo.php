<?php
session_start();
date_default_timezone_set('America/New_York');

//Are you logged in?
include('authCheck.php');

if(isset($_POST['userEmail']) && isset($_POST['userPassword']) && isset($_POST['userDisplay'])){
	//Update the DB
	include('db.php');
	$table = "botmakers";
	
	$userEmail = $_POST['userEmail'];
	$userPass = $_POST['userPassword'];
		$theSalt = "chatty";
		$userPass = md5($theSalt.$userPass);
	$userDisplay = stripslashes(htmlspecialchars($_POST['userDisplay']));
	
	//Sanitize:
	$userEmail = $connection->real_escape_string($userEmail);
	$userPass = $connection->real_escape_string($userPass);
	$userDisplay = $connection->real_escape_string($userDisplay);
	$userID = $_SESSION['userID'];
	
	//Update now:
	mysqli_query($connection,"UPDATE $table SET 
		USERNAME='$userEmail',
		PASSWORD='$userPass',
		DISPLAYNAME='$userDisplay'
		WHERE ID='$userID'");
	
	//Update the session
	$_SESSION['displayName'] = $userDisplay;
	$_SESSION['userName'] = $userEmail;
	
}
?>

<script>
alert('Your account has been updated!');
window.location = "index.php";
</script>