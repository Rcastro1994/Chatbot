<?php
session_start();
date_default_timezone_set('America/New_York');

//Are we logging in:
if(isset($_POST['loginNow']) && $_POST['loginNow'] == "yes"){
	$userEmail = trim($_POST['login']);
	$userPass = $_POST['password'];
		$theSalt = "chatty";
		$userPass = md5($theSalt.$userPass);
	
	//Check against DB:
	include('db.php');
	$table = 'botmakers';
	
	//Sanitize:
	$userEmail = $connection->real_escape_string($userEmail);
	$userPass = $connection->real_escape_string($userPass);
	
	$authorized = 0;
	$SQL = "SELECT * from $table WHERE USERNAME='$userEmail' AND PASSWORD='$userPass' AND USERSTATUS='1'";
	
	if ($result = mysqli_query($connection, $SQL)) {
		$authorized = mysqli_num_rows($result);
		while ($row = mysqli_fetch_array($result)) {
			$_SESSION['userID'] = $row['ID'];
			$_SESSION['displayName'] = $row['DISPLAYNAME'];
		}
	}
	
	if($authorized){
		$_SESSION['userName'] = $userEmail;		 
	}
	
}

if(isset($_SESSION['userName'])){
	header('Location: index.php');
	exit;
}

unset($_SESSION['name']);
unset($_SESSION['conversationID']);

$siteURL = "https://www.phpchatbot.com/chatnow/";

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP ChatBot Login</title>
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
		 <center>
		 <img src="images/logo200.png" alt="PHP ChatBot"/><br>
		 <h2>Login to the ChatBot Manager:</h2>
		 
		 <!-- Login Form -->    	
		 <form action="" method="post" class="roundForm" style="background-color: cornflowerblue;">
		<div class="form-group">
      		<input style="max-width: 100%;" type="email" id="login" name="login" size="50" placeholder="Enter your email address" required autofocus><br>
		</div>
		<div class="form-group">
	      <input type="password" id="password" name="password" placeholder="password" required><br>
		</div>
			 <input type="hidden" name="loginNow" value="yes">
      <input type="submit" value="Log In">
    </form>
		 </center>
		 
		 		 		 
	</div> 

    <hr>
	
	  
<?php include('includes/footer.php'); ?>
	  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>	 
	  
  </body>
</html>