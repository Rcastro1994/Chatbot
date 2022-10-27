<?php
session_start();

if(!isset($_SESSION['latestID'])){
	$_SESSION['latestID'] = 1;
}

if(!isset($_SESSION['name'])){
	exit();
}

$newConvo = 0;
//Which bot are we talking to?
include('db.php');

if(!isset($_SESSION['conversationID'])){
    $_SESSION['conversationID'] = session_id();	

}
if(!isset($_SESSION['botID'])){
    $_SESSION['botID'] = 1;
}

$conversationID = $_SESSION['conversationID'];
$botID = $_SESSION['botID'];

$table = "botlogs";

$chatData = "";

$SQL = "SELECT * from $table WHERE CONVERSATIONID = '$conversationID' AND BOTID = $botID ORDER BY ID DESC LIMIT 10";

//$playSound = '<script>playAudio2();</script>';
$playSound = '';

if ($result = mysqli_query($connection, $SQL)) {
		while ($row = mysqli_fetch_array($result)) {
			$chatData = $row['DIALOG'].$chatData;
			$newID = $row['ID'];
		}
}

if($newID > $_SESSION['latestID']){
	$chatData = $chatData.$playSound;
	$_SESSION['latestID'] = $newID;
}

echo $chatData;
//echo $SQL;
//echo session_id();

?>