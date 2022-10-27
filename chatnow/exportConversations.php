<?php 
session_start();
//Are you logged in?
include('authCheck.php');

// Load the database configuration file 
include('db.php'); 

//Get from parameter:
$botID = $_GET['botID'];

if(!isset($_GET['botID'])){
	header("Location: index.php"); //Redirect the user
	exit();
}
 
// Fetch records from database 
$table = "botconversations";
$SQL = "SELECT * from $table WHERE BOTID = $botID AND REVIEWED='0' ORDER BY ID ASC, CONVERSATIONID DESC";

$delimiter = ","; 
$filename = "bot-Conversations_" . date('Y-m-d') . ".csv"; 

// Create a file pointer 
$f = fopen('php://memory', 'w'); 

// Set column headers 
$fields = array('UserSays', 'BotReply', 'Confidence', 'UserName', 'TimeDate','ConversationID'); 
fputcsv($f, $fields, $delimiter);

if ($result = mysqli_query($connection, $SQL)) {
		while ($row = mysqli_fetch_array($result)) {			 
				$timeStamp = date('Y-m-d H:i', $row['TIMESTAMP']);
			
				$lineData = array($row['USERQUERY'], $row['BOTRESPONSE'], $row['BOTCONFIDENCE'], $row['USERNAME'], $timeStamp, $row['CONVERSATIONID']); 
				fputcsv($f, $lineData, $delimiter); 
	}
}

// Move back to beginning of file 
			fseek($f, 0); 

			// Set headers to download file rather than displayed 
			header('Content-Type: text/csv'); 
			header('Content-Disposition: attachment; filename="' . $filename . '";'); 

			//output all remaining data on a file pointer 
			fpassthru($f); 

exit; 
 
?>