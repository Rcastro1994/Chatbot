<?php

session_start();

if(isset($_GET['botID'])){
	$_SESSION['botID'] = $_GET['botID'];
	
	include('db.php');
	$table = "botlist";
			  $botCount = 0;
			$botID = $_SESSION['botID'];
		 $SQL = "SELECT * from $table WHERE ID=$botID ORDER BY ID DESC LIMIT 1";
		 if ($result = mysqli_query($connection, $SQL)) {
            while ($row = mysqli_fetch_array($result)) {
				$_SESSION['botName'] = $row['BOTNAME'];
				$_SESSION['botAvatar'] = $row['BOTAVATAR'];
				$_SESSION['closeMatch'] = $row['CLOSEMATCH'];
				$_SESSION['exactMatch'] = $row['EXACTMATCH'];
				$_SESSION['greeting'] = $row['GREETING'];
			}
		 }
	
	header("Location: chatBot.php"); //Redirect the user
	exit();
}else{
	header("Location: index.php"); //Redirect the user
}

?>