<?php
session_start();
date_default_timezone_set('America/New_York');

//Are you logged in?
include('authCheck.php');

if(!isset($_GET['botID']) && !isset($_GET['newBot'])){
	header("Location: index.php"); //Redirect the user
	exit();
}

if($_GET['newBot'] == "true"){
	include('db.php');
	$randomNumber = rand(100,999);
	$table = "botlist";
	$newName = $connection->real_escape_string("ChatBot".$randomNumber);
	$creationDate = time();
	$creatorID = $_SESSION['userID'];
	mysqli_query($connection,"INSERT INTO $table(BOTNAME,CREATIONDATE,CREATORID) VALUES('$newName','$creationDate','$creatorID');");
	$last_id = $connection->insert_id;
	header("Location: botSettings.php?botID=".$last_id);
	exit();
}

if($_POST['updateBot'] == "yes"){
	include('db.php');
	$saveID = $_GET['botID'];
	$newName = stripslashes(htmlspecialchars($_POST['chatbotName']));
	$newGreeting = stripslashes(htmlspecialchars($_POST['chatbotGreeting']));		
	$closeMatch = $_POST['matchThreshold'];
	$exactMatch = $_POST['exactThreshold'];
	$botCreator = stripslashes(htmlspecialchars($_POST['botCreator']));
	
	//Cleanup:
	$newName = $connection->real_escape_string($newName);
	$creatorName = $connection->real_escape_string($botCreator);
	$newGreeting = $connection->real_escape_string($newGreeting);
	
	//Update the DB:
	$table = "botlist";
	mysqli_query($connection,"UPDATE $table SET 
		BOTNAME='$newName',
		CLOSEMATCH='$closeMatch',
		EXACTMATCH='$exactMatch',
		CREATOR='$creatorName',
		GREETING='$newGreeting'
		WHERE ID = '$saveID'");
		echo '<script>alert(\'Settings Saved!\'); window.location.replace("index.php");</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP ChatBot</title>
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
				$_SESSION['closeMatch'] = $row['CLOSEMATCH'];
				$_SESSION['exactMatch'] = $row['EXACTMATCH'];
				$_SESSION['botCreator'] = $row['CREATOR'];
				$firstGreet = $row['GREETING'];
			}
		 }

	echo '<center><h1>Update ChatBot Settings:</h1></center>
	<form action="" method="post">
  <div class="form-group">
    <label for="chatbotName">ChatBot Name:</label>
    <input type="text" class="form-control" id="chatbotName" name="chatbotName" aria-describedby="nameHelp" maxlength="40" placeholder="Enter a name for your ChatBot" value="'.$_SESSION['botName'].'">
    <small id="nameHelp" class="form-text text-muted">This is the name that will appear when your chatbot sends a message</small>
  </div>
  
  <div class="form-group">
    <label for="chatbotName">Initial Greeting:</label>
    <input type="text" class="form-control" id="chatbotGreeting" name="chatbotGreeting" aria-describedby="greetingHelp" maxlength="40" placeholder="Initial greeting to users" value="'.$firstGreet.'">
    <small id="greetingHelp" class="form-text text-muted">This is the first thing your bot will say to a new visitor</small>
  </div>
  
  <div class="form-group">
    <label for="matchThreshold">Close Match Threshold:</label>
    <input type="number" class="form-control" id="matchThreshold" name="matchThreshold" aria-describedby="matchHelp" min="0" max="100" step="1" value="'.$_SESSION['closeMatch'].'">
    <small id="matchHelp" class="form-text text-muted">How confident does the bot need to be to reply?</small>
  </div>
  
  <div class="form-group">
    <label for="exactThreshold">Exact Match Threshold:</label>
    <input type="number" class="form-control" id="exactThreshold" name="exactThreshold" aria-describedby="matchHelp2" min="0" max="100" step="1" value="'.$_SESSION['exactMatch'].'">
    <small id="matchHelp2" class="form-text text-muted">How confident does the bot need to be for a perfect match?</small>
  </div>
  
  <div class="form-group">
    <label for="creatorName">Bot Creator\'s Name:</label>
    <input type="text" class="form-control" id="creatorName" name="botCreator" aria-describedby="creatorHelp" maxlength="40" placeholder="Enter a creator name" value="'.$_SESSION['botCreator'].'">
    <small id="creatorHelp" class="form-text text-muted">*Optional - Add a creator name to this chatbot</small>
  </div>
  
  <input type="hidden" name="updateBot" value="yes">
  <button type="submit" class="btn btn-primary">Save Changes</button>
</form>';
	
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
    </script>
		
	<input style="display: none;" name="copySay" id="copySay" value="">
	  
  </body>
</html>