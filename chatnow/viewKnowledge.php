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
    <title>PHP ChatBot Knowledge Base Viewer</title>
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

	echo '<center><h1>Knowledge Base for<br> '.$_SESSION['botName'].':<br>
	<a class="btn btn-primary" href="botTrainer.php?botID='.$botID.'" role="button">Back to Training</a><br>
	<a class="btn btn-lg btn-success" href="exportKnowledge.php?botID='.$botID.'" role="button">Export Bot Knowledge as CSV</a><br>
	<img class="avatar" src="'.$_SESSION['botAvatar'].'"></h1></center><hr>';
	
	echo '<table class="table table-bordered table-hover" style="background-color:#fff;">
		  <thead>
			<tr>
			  <th scope="col">Visitor Says</th>
			  <th scope="col">Bot Response</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead><tbody>';
	
	//Load the knowledge and display it:
	// Fetch records from database 
	$table = "botknowledge";
	$rowCount = 0;
	$SQL = "SELECT * from $table WHERE BOTID = $botID ORDER BY ID DESC";
	if ($result = mysqli_query($connection, $SQL)) {
		while ($row = mysqli_fetch_array($result)) {			 
		  $rowCount++;
			echo '<tr id="row'.$row['ID'].'">
		  <td id="question'.$row['ID'].'">'.$row['QUESTION'].'</td>
		  <td id="response'.$row['ID'].'">'.$row['BOTRESPONSE'].'</td>
		  <td><a class="btn btn-success" style="margin-bottom:5px;" data-toggle="modal" data-target="#editPopout" onclick="document.getElementById(\'userSays2\').value=\''.urlencode($row['QUESTION']).'\'; document.getElementById(\'botReplyNew\').value=\''.urlencode($row['BOTRESPONSE']).'\'; document.getElementById(\'editID\').value=\''.$row['ID'].'\'; fixForm();">Edit</a><br><a onclick="clearConfirm('.$row['ID'].');" class="btn btn-danger" role="button">Delete</a></td>
		  </tr>';
	}
}
	echo '</tbody></table><br>';
	
}

?>
	
</div> 

    <hr>

	  <!-- Modal -->
<div class="modal fade" id="editPopout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Knowledge</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editLine" class="roundForm" action="editReply.php" target="updateFrame" method="post" style="background-color:yellow;">
	<center><strong>Edit a reponse for your Bot:</strong></center>
	  <div class="form-group">
		<label for="userSays2">When a user types:</label>
		<input type="text" class="form-control" id="userSays2" name="userSays2" aria-describedby="userSays2" maxlength="140" placeholder="Enter something a user might say" value="" required><br>
		
		<label for="botSays">Response:</label>
		<input type="text" class="form-control" id="botReplyNew" name="botReply1" aria-describedby="botReplyNew" placeholder="Bot Reply" value="" required>				
	  </div>
		  <input type="hidden" name="editKnowledge" value="yes">
		  <input type="hidden" id="editID" name="editID" value="">
			<input type="hidden" id="savebotID" name="savebotID" value="<?php echo $botID; ?>">

		  <center><button type="submit" class="btn btn-primary" onclick="closeEditBox(document.getElementById('editID').value);">Update Bot Knowledge</button>
		</form></center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
	  
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
	
	function clearConfirm(removeID){
		var clearConfirm = confirm("Delete this from the knowledge base?");
                    if (clearConfirm == true) {
						document.getElementById("updateFrame").src = "deleteKnowledge.php?delete=true&redirect=0&botID=<?php echo $botID; ?>&lineID=" + removeID;
						document.getElementById("row"+removeID).style.display="none";
                    }
	}		 		 
		 
	function fixForm(){
		var fixUsersays = document.getElementById('userSays2').value;
		fixUsersays = fixUsersays.replace(/\+/g, '%20');
		document.getElementById('userSays2').value = decodeURIComponent(fixUsersays);
		var fixBotreply = document.getElementById('botReplyNew').value;
		fixBotreply = fixBotreply.replace(/\+/g, '%20');
		document.getElementById('botReplyNew').value = decodeURIComponent(fixBotreply);
		//alert('I can fix it!');
	}		 
	
	function closeEditBox(rowNumber){
		var qUpdate = "question" + rowNumber;
		var rUpdate = "response" + rowNumber;
		document.getElementById(qUpdate).innerHTML = document.getElementById('userSays2').value;
		document.getElementById(rUpdate).innerHTML = document.getElementById('botReplyNew').value;
		setTimeout(function(){ $("#editPopout").modal("hide"); }, 500);
	}
		 
	alert('Now viewing <?php echo $rowCount; ?> entries from the Knowledge Base for <?php echo $_SESSION['botName']; ?>');
    </script>
		
	<input style="display: none;" name="copySay" id="copySay" value="">
	  <iframe id="updateFrame" name="updateFrame" width="1" height="1"></iframe>
	  
  </body>
</html>