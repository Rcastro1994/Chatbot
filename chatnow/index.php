<?php
session_start();
date_default_timezone_set('America/New_York');

//Are you logged in?
include('authCheck.php');

unset($_SESSION['name']);
unset($_SESSION['lastQuestion']);
//unset($_SESSION['conversationID']);

//Get the URL for sharing bot links:
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$siteURL = str_replace("index.php","",$url);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP ChatBot</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="css/chatCustom.css" rel="stylesheet">
	  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
	  <?php include('favicons.php'); ?>
	  
  </head>
  <body>
	<?php include('includes/topNav.php'); ?>
	  
	 <?php include('db.php'); ?>
	  
	 <div class="container-sm content">
		 <img src="images/logo200.png" alt="PHP ChatBot"/><br>
		 <h2>Available ChatBots:</h2>
		 
		 <a class="btn btn-primary btn-lg" id="newBot" role="button">Create a New Chat Bot</a>
		 <hr>
		 
		 <table class="table">
		  <thead class="thead-dark">
			<tr>
			  <th scope="col">#</th>
			  <th scope="col">ChatBot Name</th>
			  <th scope="col">Actions</th>
			</tr>
		  </thead>
		  <tbody>

		<?php
		 
		 $table = "botlist";
			  $botCount = 0;
			  $creatorID = $_SESSION['userID'];
		 $SQL = "SELECT * from $table WHERE CREATORID='$creatorID' AND BOTSTATUS='1' ORDER BY ID DESC";
		 if ($result = mysqli_query($connection, $SQL)) {
            while ($row = mysqli_fetch_array($result)) {
				$botCount++;
                $newID = $row['ID'];
				$newName = $row['BOTNAME'];
				$newAvatar = $row['BOTAVATAR'];
				echo '<tr valign="middle">
					  <th scope="row">'.$botCount.'</th>
					  <td><center><strong>'.$newName.'</strong><br><a title="Update Avatar" href="botAvatar.php?botID='.$newID.'"><img class="avatar" src="'.$newAvatar.'"></a></center></td>
					  <td><a title="Settings" href="botSettings.php?botID='.$newID.'" class="btn btn-warning" role="button"><i class="bi bi-gear"></i></a> | <a title="Train Your Bot" href="botTrainer.php?botID='.$newID.'" class="btn btn-info" role="button"><i class="bi bi-sliders"></i></a> | <a title="Chat with this Bot" href="newChat.php?botID='.$newID.'" class="btn btn-primary" role="button"><i class="bi bi-chat-left-dots"></i></a> | <a title="Share this Bot" href="#" onClick="copyData(\''.$siteURL.'newChat2.php?botID='.$newID.'\')" class="btn btn-success" role="button"><i class="bi bi-share"></i></a> | <a title="Delete" href="#" onClick="deleteConfirm(\''.$newID.'\')" class="btn btn-danger" role="button"><i class="bi bi-trash"></i></a></td>
					</tr>';
            }
		}
		 
		 ?>
			 </tbody>
		 </table>
		 		 		 
	</div> 

    <hr>
	
<!-- Modal -->
<div class="modal fade" id="editPopout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Account:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editLine" class="roundForm" action="updateInfo.php" method="post" style="background-color:yellow;">
	  <div class="form-group">
		<label for="userEmail">Update Email:</label>
		<input type="email" class="form-control" id="userEmail" name="userEmail" aria-describedby="userEmail" maxlength="320" placeholder="Enter your email" value="<?php echo $_SESSION['userName']; ?>" required>
		
		<label for="userPassword">Confirm/Update Password:</label>
		<input type="password" class="form-control" id="userPassword" name="userPassword" aria-describedby="userPassword" maxlength="140" placeholder="Enter new password" value="" min="5" required>	
		  
		<label for="userDisplay">Update Your Name:</label>
		<input type="text" class="form-control" id="userDisplay" name="userDisplay" aria-describedby="userDisplay" maxlength="40" placeholder="Type your name" value="<?php echo $_SESSION['displayName']; ?>" required>	  
	  </div>
	  

		  <center><button type="submit" class="btn btn-primary">Update My Account</button>
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
	   alert('Link Copied! You can paste to email, text, or wherever you like!');
	   clearVar = setTimeout(clearCopy, 5000);
    }
	function clearCopy(){
		document.getElementById('copySay').value = '';
	}
		 
	function deleteConfirm(deleteID){
		var deleteBot = deleteID;
		var exit = confirm("Delete this Chat Bot?");
                    if (exit == true) {
                    window.location = "deleteBot.php?delete=true&botID=" + deleteBot;
                    }
	}
	
	$("#newBot").click(function () {
                    var exit = confirm("Create a new Chat Bot?");
                    if (exit == true) {
                    window.location = "botSettings.php?newBot=true";
                    }
                });
    </script>
		
	<input style="display: none;" name="copySay" id="copySay" value="">
	  <iframe id="updateFrame" width="1" height="1"></iframe>
	  
  </body>
</html>