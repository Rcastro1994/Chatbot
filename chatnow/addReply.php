<?php

$table = 'botknowledge';
$botID = $saveID;
$replyCount = 0;

$userSays = $_POST['userSays'];
$reply1 = $_POST['botReply1'];
$reply2 = $_POST['botReply2'];
$reply3 = $_POST['botReply3'];
$reply4 = $_POST['botReply4'];
$reply5 = $_POST['botReply5'];

include('db.php');

//Cleanup
$botQuestion = $connection->real_escape_string($userSays);
$botResponse = $connection->real_escape_string($reply1);

mysqli_query($connection,"INSERT INTO $table(BOTID, QUESTION,BOTRESPONSE) VALUES('$botID','$botQuestion','$botResponse');");
$replyCount++;

//Are we doing extra replies:
if(isset($_POST['botReply2']) && $reply2 != ""){
	$botResponse = $connection->real_escape_string($reply2);
	mysqli_query($connection,"INSERT INTO $table(BOTID, QUESTION,BOTRESPONSE) VALUES('$botID','$botQuestion','$botResponse');");
	$replyCount++;
}

if(isset($_POST['botReply3']) && $reply3 != ""){
	$botResponse = $connection->real_escape_string($reply3);
	mysqli_query($connection,"INSERT INTO $table(BOTID, QUESTION,BOTRESPONSE) VALUES('$botID','$botQuestion','$botResponse');");
	$replyCount++;
}

if(isset($_POST['botReply4']) && $reply4 != ""){
	$botResponse = $connection->real_escape_string($reply4);
	mysqli_query($connection,"INSERT INTO $table(BOTID, QUESTION,BOTRESPONSE) VALUES('$botID','$botQuestion','$botResponse');");
	$replyCount++;
}

if(isset($_POST['botReply5'])  && $reply5 != ""){
	$botResponse = $connection->real_escape_string($reply5);
	mysqli_query($connection,"INSERT INTO $table(BOTID, QUESTION,BOTRESPONSE) VALUES('$botID','$botQuestion','$botResponse');");
	$replyCount++;
}

if($replyCount > 1){
	$replyPlural = "s";
}

$updateConfirm = "Added 1 new statement with ".$replyCount." possible response".$replyPlural;
$closeTab = "";
if($_GET['retrain'] == "yes"){
	$updateConfirm = "Retrained based on a conversation with ".$replyCount." possible response".$replyPlural.". I will close this tab to return to your conversation logs.";
	$closeTab = " window.close();";
}

echo '<script>alert(\''.$updateConfirm.'\');'.$closeTab.'</script>';

?>