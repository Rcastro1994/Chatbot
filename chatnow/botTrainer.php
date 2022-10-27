<?php
session_start();
date_default_timezone_set('America/New_York');

//Are you logged in?
include('authCheck.php');

if(!isset($_GET['botID'])){
	header("Location: index.php"); //Redirect the user
	exit();
}

if(isset($_SESSION['lastQuestion'])){
    $showText = stripslashes($_SESSION['lastQuestion']);		
}

if($_POST['newFile'] == "yes"){
	unset($_SESSION['lastQuestion']);
	$saveID = $_GET['botID'];
	$importType = $_POST['csvType'];
	include('convertcsv.php');
	if($uploadOk == 1){
		echo '<script>alert(\'Import Complete!\');</script>';
	}
}

$updateConfirm = "";
if($_POST['newKnowledge'] == "yes"){
	$saveID = $_GET['botID'];	
	include('addReply.php');
}

if($_POST['editKnowledge'] == "yes" && isset($_POST['editID'])){
	$saveID = $_GET['botID'];
	$updateID = $_POST['editID'];
	include('editReply.php');
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP ChatBot Knowledge Update</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="css/chatCustom.css" rel="stylesheet">
	  <?php include('favicons.php'); ?>

	  
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
			}
		 }
	
	echo '<center><h1>Knowledge Training for<br> '.$_SESSION['botName'].':<br>
	<img class="avatar" src="'.$_SESSION['botAvatar'].'"></h1></center><hr>';
	
	echo '
	<form class="roundForm" action="" method="post">
	<center><strong>Test Bot Response:</strong></center>
	  <div class="form-group">
		<label for="testMessage">Send a message to your bot to check for a response:</label>
		<input type="text" class="form-control" id="testMessage" name="testMessage" aria-describedby="testMessage" maxlength="140" placeholder="Enter your message..." value="'.$_POST['testMessage'].'" required>				
	  </div>
   
  <input type="hidden" name="testKnowledge" value="yes">
  
  <center><button type="submit" class="btn btn-primary">Send Message to Bot</button><br>';		
	
	
	//Check for responses:
	if($_POST['testKnowledge'] == "yes"){
		$saveID = $_GET['botID'];
		$text = $_POST['testMessage'];
		include('testReply.php');
	}
	//Run this if we just updated a response:
	if(isset($_SESSION['lastQuestion'])){
		$saveID = $_GET['botID'];
		$text = $_SESSION['lastQuestion'];
		include('testReply.php');
	}
	
	//Are we retraining?
	if($_GET['retrain'] == "yes"){
		$text = $_GET['trainData'];
	}
		
	
	echo '</form></center><br><hr><br>';

	
	
	echo '
	<form class="roundForm" action="" method="post">
	<center><strong>Add a reponse to your Bot:</strong></center>
	  <div class="form-group">
		<label for="userSays">When a user types:</label>
		<input type="text" class="form-control" id="userSays" name="userSays" aria-describedby="userSays" maxlength="140" placeholder="Enter something a user might say" value="'.$text.'" required><br>
		
		<label for="userSays">Response(s):</label>
		<input type="text" class="form-control" id="botReply1" name="botReply1" aria-describedby="botReply1" placeholder="Possible Reply #1" value="" required>
		<input type="text" class="form-control" id="botReply2" name="botReply2" aria-describedby="botReply2" placeholder="Possible Reply #2" value="">
		<input type="text" class="form-control" id="botReply3" name="botReply3" aria-describedby="botReply3" placeholder="Possible Reply #3" value="">
		<input type="text" class="form-control" id="botReply4" name="botReply4" aria-describedby="botReply4" placeholder="Possible Reply #4" value="">
		<input type="text" class="form-control" id="botReply5" name="botReply5" aria-describedby="botReply5" placeholder="Possible Reply #5" value="">
		<small id="replyHelp" class="form-text text-muted">*If you supply multiple replies, they will be randomly chosen by your bot</small>
		
	  </div>
  
  
  <input type="hidden" name="newKnowledge" value="yes">
  
  <center><button type="submit" class="btn btn-primary">Update Bot Knowledge</button><br>'.$updateConfirm.'
</form></center><br><hr>';
	
	echo '<center><button onclick="idkResponse();" class="btn btn-primary">Generate "I don\'t know" Response</button><br>
		<button onclick="timeResponse();" class="btn btn-info">Generate Time Response</button><br>
		<button onclick="dateResponse();" class="btn btn-info">Generate Date Response</button>
	</center>
	<hr>';
	
	echo '
	<div class="roundForm">
	<center><strong>Generate auto-reponse buttons for your Bot:</strong></center>
	  <div class="form-group">
		<label for="buttonLabel">Text for button:</label>
		<input type="text" class="form-control" id="buttonLabel" name="buttonLabel" aria-describedby="buttonLabel" maxlength="140" placeholder="Enter text for the button" value="" required><br>
		
		<label for="chatSays">Text to send to the bot:</label>
		<input type="text" class="form-control" id="chatSays" name="chatSays" aria-describedby="chatSays" maxlength="140" placeholder="What to send to the bot" value="" required>
		
		<small id="replyHelp" class="form-text text-muted">*This will generate buttons that can help keep the conversation moving with your bot</small>
		
	  </div>    
  <input type="hidden" name="newButton" value="yes">
  
  <center><button onclick="makeButton();" class="btn btn-primary">Generate Button Code</button><br><br>
  
  <textarea rows="3" id="buttonCode" placeholder="Button code will be generated here" style="width:95%; text-align:center;"></textarea>
  
</div></center><br><hr><br>';
	
	echo '<center>
	<form class="roundForm" action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="fileToUpload"><strong>Upload Knowledge via CSV file:</strong></label><br>
	<input type="file" name="fileToUpload" id="fileToUpload" required>    
    <small id="fileHelp" class="form-text text-muted">Please upload a CSV knowledge file</small>
  </div>
  
  <input type="hidden" name="newFile" value="yes">
  
  <label for="csvType">Import Type:</label><br>
  <select name="csvType" id="csvType">
  <option value="add">Add Knowledge</option>
  <option value="replace">Replace All Current Knowledge</option>
  </select><br><br>
  
  <button type="submit" class="btn btn-primary">Import Knowledge File</button><br>
</form></center>';
	
}

?>
	
</div> 

    <hr>
	  
	  <center>
	  <a class="btn btn-lg btn-secondary" onclick="alert('This may take a moment for a bot with a large knowledge base.');" href="viewKnowledge.php?botID=<?php echo $botID; ?>" role="button">View Bot Knowledge Base</a> | 
	  <a class="btn btn-lg btn-success" href="exportKnowledge.php?botID=<?php echo $botID; ?>" role="button">Export Bot Knowledge as CSV</a><br><br>
	  <a class="btn btn-lg btn-info" href="viewConversations.php?botID=<?php echo $botID; ?>" role="button">View Recent Conversations</a> | <a class="btn btn-lg btn-warning" href="exportConversations.php?botID=<?php echo $botID; ?>" role="button">Export Bot Conversation Log as CSV</a> | <button type="button" class="btn btn-lg btn-danger" onclick="clearConfirm(<?php echo $botID; ?>);">Clear Logs</button>
		  
	</center>
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
        <form id="editLine" class="roundForm" action="" method="post" style="background-color:yellow;">
	<center><strong>Edit a reponse for your Bot:</strong></center>
	  <div class="form-group">
		<label for="userSays2">When a user types:</label>
		<input type="text" class="form-control" id="userSays2" name="userSays2" aria-describedby="userSays2" maxlength="140" placeholder="Enter something a user might say" value="" required><br>
		
		<label for="botSays">Response:</label>
		<input type="text" class="form-control" id="botReplyNew" name="botReply1" aria-describedby="botReplyNew" placeholder="Bot Reply" value="" required>				
	  </div>
		  <input type="hidden" name="editKnowledge" value="yes">
		  <input type="hidden" id="editID" name="editID" value="">

		  <center><button type="submit" class="btn btn-primary">Update Bot Knowledge</button>
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
		 
	function fixForm(){
		var fixUsersays = document.getElementById('userSays2').value;
		fixUsersays = fixUsersays.replace(/\+/g, '%20');
		document.getElementById('userSays2').value = decodeURIComponent(fixUsersays);
		var fixBotreply = document.getElementById('botReplyNew').value;
		fixBotreply = fixBotreply.replace(/\+/g, '%20');
		document.getElementById('botReplyNew').value = decodeURIComponent(fixBotreply);
		//alert('I can fix it!');
	}
    </script>
		
	<input style="display: none;" name="copySay" id="copySay" value="">
	<iframe id="updateFrame" width="1" height="1"></iframe>
	  
<script>
	  function deleteConfirm(deleteID){
		var deleteID = deleteID;
		var exit = confirm("Delete this line from the knowledge base?");
                    if (exit == true) {
						document.getElementById("updateFrame").src = "deleteKnowledge.php?delete=true&botID=<?php echo $botID; ?>&lineID=" + deleteID;
                    }
	}
	
	function clearConfirm(deleteID){
		var clearID = deleteID;
		var clearConfirm = confirm("Clear the conversation logs for this bot?");
                    if (clearConfirm == true) {
						document.getElementById("updateFrame").src = "clearLog.php?delete=true&botID=<?php echo $botID; ?>";
						alert('Conversation log cleared!');
                    }
	}
	
	function makeButton(){
		var buttonLabel = document.getElementById('buttonLabel').value;
		var chatSend = document.getElementById('chatSays').value.replace(/(<([^>]+)>)/gi, "");
			chatSend = chatSend.replace(/'/g,"\\'");
		var buttonCode = '<br><br><button onclick="sendFromButton(\'' + chatSend + '\');" type="button" class="btn btn-light btn-sm autoButton">' + buttonLabel + '</button>';
		document.getElementById('buttonCode').value = buttonCode;
		copyData(buttonCode);
		alert('You can paste the code generated into a bot response!');
	}
	
	function idkResponse(){
		document.getElementById('userSays').value = "IDKnull";
		alert('Please add up to 5 "I don\'t know" responses.');
	}
	function timeResponse(){
		document.getElementById('userSays').value = "What time is it?";
		document.getElementById('botReply1').value = "getTIME";
		alert('Please add a user prompt above to generate an answer with the time.');
	}
	function dateResponse(){
		document.getElementById('userSays').value = "What is the current date?";
		document.getElementById('botReply1').value = "getDATE";
		alert('Please add a user prompt above to generate an answer with the date.');
	}
</script>
	  
  </body>
</html>