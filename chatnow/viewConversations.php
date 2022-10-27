<?php
session_start();
date_default_timezone_set('America/New_York');

//Are you logged in?
include('authCheck.php');

if(!isset($_GET['botID'])){
	header("Location: index.php"); //Redirect the user
	exit();
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP ChatBot Conversation Viewer</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="css/chatCustom.css" rel="stylesheet">
	  
  </head>
  <body>
	<?php include('includes/topNav.php'); ?>

<div class="container-sm content">
<?php
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
				$_SESSION['botCreator'] = $row['CREATOR'];
			}
		 }

	echo '<center><h1>Recent Conversations for<br> '.$_SESSION['botName'].':<br>
	<a class="btn btn-primary" href="botTrainer.php?botID='.$botID.'" role="button">Back to Training</a><br>
	<a class="btn btn-lg btn-warning" href="exportConversations.php?botID='.$botID.'" role="button">Export Bot Conversation Log as CSV</a> | <button type="button" class="btn btn-lg btn-danger" onclick="clearConfirm('.$botID.');">Clear Logs</button><br>
	<img class="avatar" src="'.$_SESSION['botAvatar'].'"></h1></center><hr>';
	
	echo '<table class="table table-bordered table-hover" style="background-color:#fff;">
		  <thead>
			<tr>
			  <th scope="col">Visitor Name</th>
			  <th scope="col">Visitor Says</th>
			  <th scope="col">Bot Response</th>
			  <th scope="col">Match</th>
			  <th scope="col">Timestamp</th>
			  <th scope="col">Retrain?</th>
			</tr>
		  </thead><tbody>';
	
	//Load the knowledge and display it:
	// Fetch records from database 
	$table = "botconversations";
	$rowCount = 0;
	$SQL = "SELECT * from $table WHERE BOTID = $botID AND REVIEWED='0' ORDER BY ID ASC, CONVERSATIONID DESC";
	if ($result = mysqli_query($connection, $SQL)) {
		while ($row = mysqli_fetch_array($result)) {			 
		  $rowCount++;
			$dialogTime = date('Y-m-d - H:i', $row['TIMESTAMP']);;
			echo '<tr id="row'.$rowCount.'">
			<td>'.$row['USERNAME'].'</td>
		  <td>'.$row['USERQUERY'].'</td>
		  <td>'.$row['BOTRESPONSE'].'</td>
		  <td align="center">'.$row['BOTCONFIDENCE'].'</td>
		  <td>'.$dialogTime.'</td>
		  <td><a onclick="this.parentElement.parentElement.style.display=\'none\'; clearLogLine('.$row['ID'].');" class="btn btn-primary" href="botTrainer.php?botID='.$botID.'&retrain=yes&trainData='.$row['USERQUERY'].'" target="_blank" role="button" style="margin-bottom:5px;">Train</a><br><a onclick="this.parentElement.parentElement.style.display=\'none\'; clearLogLine('.$row['ID'].');" class="btn btn-danger" role="button">Dismiss</a></td>
		  </tr>';
	}
}
	echo '</tbody></table><br>';
	
}

?>
	
</div> 

    <hr>
	
	  
<?php include('includes/footer.php'); ?>
	  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
	  
	 <script>			
	   function copyData(sendURL) {
	   //alert(sendURL);
	   var x = document.getElementById("copySay");
	   x.style.display = "block";
       document.getElementById('copySay').value = sendURL;
	   document.getElementById('copySay').select();
	   document.execCommand("copy");
	   x.style.display = "none";
	   //alert('Copied! You can paste to email, text, or wherever you like!');
	   clearVar = setTimeout(clearCopy, 5000);
    }
	function clearCopy(){
		document.getElementById('copySay').value = '';
	}
		 
	function clearConfirm(deleteID){
		var clearID = deleteID;
		var clearConfirm = confirm("Clear the conversation logs for this bot?");
                    if (clearConfirm == true) {
						document.getElementById("updateFrame").src = "clearLog.php?delete=true&botID=<?php echo $botID; ?>";
						alert('Conversation log cleared!');
						location.reload(); //Reload the page
                    }
	}
		 
	function clearLogLine(removeID){
		document.getElementById("updateFrame").src = "clearLogLine.php?delete=true&botID=<?php echo $botID; ?>&logLine=" + removeID;
	}
		 
	alert('Now viewing <?php echo $rowCount; ?> exchanges from the conversation history for <?php echo $_SESSION['botName']; ?>');
    </script>
		
	<input style="display: none;" name="copySay" id="copySay" value="">
	  <iframe id="updateFrame" width="1" height="1"></iframe>
	  
  </body>
</html>