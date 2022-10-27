<?php
session_start();
date_default_timezone_set('America/New_York');

if(!isset($_GET['botID'])){
	header("Location: index.php"); //Redirect the user
	exit();
}

if($_POST['newFile'] == "yes"){
	include('avatarUpload.php');
}

if($_GET['updateBot'] == "yes" || $uploadOk == 1){
	include('db.php');
	$saveID = $_GET['botID'];
	$newAvatar = stripslashes(htmlspecialchars($_GET['newAvatar']));
	
	if($uploadOk == 1){
		$newAvatar = $target_file;
	}
	
	//Cleanup:
	$newAvatar = $connection->real_escape_string($newAvatar);
	
	//Update the DB:
	$table = "botlist";

	mysqli_query($connection,"UPDATE $table SET 
		BOTAVATAR='$newAvatar'
		WHERE ID = '$saveID'");
		echo '<script>alert(\'New Avatar Assigned!\'); window.location.replace("index.php");</script>';
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP ChatBot Avatar Update</title>
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
			}
		 }

	echo '<center><h1>Update Avatar for<br> '.$_SESSION['botName'].':<br>
	<img class="avatar" src="'.$_SESSION['botAvatar'].'"></h1></center><hr>';
	
	echo '<strong>Existing Avatars: (click to assign):</strong><br>';
	//Show existing avatars:
	$dir = "avatars/";
	// Sort in ascending order - this is default
	$a = scandir($dir);
	
	for($i = 0; $i < count($a); $i++){
		if($a[$i] != '.' && $a[$i] != '..'){
			echo '<a href="?botID='.$botID.'&updateBot=yes&newAvatar=avatars/'.$a[$i].'"><img style="margin:2px;" class="avatar" src="avatars/'.$a[$i].'"></a>';
		}
	}
	
	echo '<hr>
	<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="fileToUpload">Upload a new avatar:</label>
	<input type="file" name="fileToUpload" id="fileToUpload">    
    <small id="fileHelp" class="form-text text-muted">Please upload a JPG, PNG, or GIF file</small>
  </div>
  
  <input type="hidden" name="newFile" value="yes">
  
  <button type="submit" class="btn btn-primary">Upload Image</button>
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