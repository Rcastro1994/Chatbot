<?php

session_start();

//echo session_id();
//session_regenerate_id

date_default_timezone_set('America/New_York');

 
if(isset($_GET['logout'])){    
     
    //Simple exit message
    $logout_message = "<div class='msgln'><span class='left-info'><b class='user-name-left'>". $_SESSION['name'] ."</b> has left the chat session.</span><br></div>";
     
    session_destroy();	
    header("Location: index.php"); //Redirect the user
}
 
if(isset($_POST['enter'])){
    if($_POST['name'] != ""){
        $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
		$_SESSION['savedName'] = $_SESSION['name'];
		$_SESSION['avatar'] = "images/avatar.png";
		//$_SESSION['badgeColor'] = $_POST['badgeColor'];		
    }
    else{
        echo '<span class="error">Please type in a name</span>';
    }
}
 
function loginForm(){
    echo
    '<div class="container-sm content">
	<div id="loginform">
	<center>
    <h3>Please enter your name to continue!</h3>
    <form action="" method="post">
      <input type="text" name="name" id="name" value="'.$_SESSION['identity']->nombre.'" placeholder="Please enter your name..." maxlength="40" autofocus required />
   		<!--<input type="color" name="badgeColor" id="colorpicker" value="#00ffff">-->
		<br><br>

      <input type="submit" name="enter" id="enter" value="Enter Chat" />
    </form>
	</center>
  </div>
  </div><br><hr>';
}

function addGreeting(){
	//Add the initial greeting:
	include('db.php');
	$table = "botlogs";
	$timeStamp = time();
	$conversationID = $_SESSION['conversationID'];
	$botID = $_SESSION['botID'];
	$botName = $_SESSION['botName'];
	$botAvatar = $_SESSION['botAvatar'];
	$sayFirst = $_SESSION['greeting'];
	$firstMessage = '<li class="out"><div class="chat-img"><img alt="Avatar" src="'.$botAvatar.'"></div><div class="chat-body"><div class="chat-message"><h5>'.$botName.'</h5><p>'.$sayFirst.'<br><small>'.date("g:i A").'</small></p></div></div></li>';
    $saveDialog = $connection->real_escape_string($firstMessage);
    mysqli_query($connection,"INSERT INTO $table(BOTID,CONVERSATIONID,DIALOG,TIMESTAMP) VALUES('$botID','$conversationID','$saveDialog','$timeStamp');");
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
	  
	  <script>
    var userSound = new Audio('audio/userSend.mp3');
    var botSound = new Audio('audio/botSend.mp3');

    function playAudio1() {
      userSound.play();
    }
    function playAudio2() {
      botSound.play();
    }
    </script>
	  
  </head>
  <body>
	<?php include('includes/topNav.php'); ?>
	  
	 <?php
    if(!isset($_SESSION['name'])){
		//echo session_id().'<br>';
		session_regenerate_id();
		//echo session_id().'<hr>';
        loginForm();
    }
    else {
		//Who are we talking to?
		if(!isset($_SESSION['conversationID'])){
			$_SESSION['conversationID'] = session_id();
			addGreeting();
		}
		if(isset($_GET['botID'])){
			$_SESSION['botID'] = $_GET['botID'];
		}
		if(!isset($_SESSION['botID'])){
			$_SESSION['botID'] = 0;
		}
		$botName = $_SESSION['botName'];
		$botAvatar = $_SESSION['botAvatar'];
    ?> 
	  
	 <div class="container-sm content">

        	<div class="card">
        		<div class="card-header"><?php echo $botName; ?> - Chat</div>
        		<div class="card-body height3">
        			<ul class="chat-list" id="chatbox">
					  <center><img id="loadingGif" src="images/loading.gif" width="300" height="300" alt="Loading"/></center>
                    </ul>
        		</div>		
	</div>
<!--Chat Entry Form-->
<form action="" style="margin-top: 10px;">
<div class="input-group">
  <input name="userText" id="userText" autofocus type="text" class="form-control" placeholder="Enter your message here..." aria-label="Enter your message here..." aria-describedby="basic-addon2">
  <div class="input-group-append">
    <button class="btn btn-outline-secondary" type="submit" name="submitmsg" id="submitmsg">Send</button>
  </div>
</div>
</form>
<!--End Submit Form-->		 
</div> 

	
	  <?php
}
?>
	  
<?php include('includes/footer.php'); ?>
	  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap-4.4.1.js"></script>
	  
	  <script type="text/javascript">
            // jQuery Document
            $(document).ready(function () {
                $("#submitmsg").click(function () {
					//alert("Click!"); //Debug only
                    var clientmsg = $("#userText").val();
					var showLast = '<li class="in"><div class="chat-img"><img alt="Avatar" src="../uploads/images/<?=$_SESSION['identity']->imagen?>"></div><div class="chat-body"><div class="chat-message"><h5><?php echo $_SESSION['name']; ?></h5><p>' + clientmsg + '<br><small>Just now</small></p></div></div></li>';
					$("#chatbox").append(showLast); //Add to window instantly
					playAudio1();					
                    $.post("postDB.php", { text: clientmsg, botID: "<?php echo $_SESSION['botID']; ?>" });
                    $("#userText").val("");	
					document.getElementById("userText").disabled = true;
					setTimeout(showTyping, 500);
                    return false;
                });								
				
				function showTyping(){
					var typingHTML = '<li class="out"><div class="chat-img"><img alt="Avatar" src="<?php echo $botAvatar; ?>"></div><div class="chat-body"><div class="chat-message"><h5><?php echo $botName; ?></h5><p><center><img src="images/typingnow.gif" style="max-width:50px;""></center></p></div></div></li>';
					$("#chatbox").append(typingHTML);
					document.getElementById("userText").focus(); //Scroll down
					setTimeout(loadLog, 1500);
				}
 
                function loadLog() {
					$("loadingGif").hide();
                    //var oldscrollHeight = $("#chatbox")[0].scrollHeight; //Scroll height before the request
 
                    $.ajax({
                        url: "loadChat.php",
                        cache: false,
                        success: function (html) {
                            $("#chatbox").html(html); //Insert chat log into the #chatbox div
							playAudio2();
                            //Auto-scroll
							document.getElementById("userText").disabled = false;
							document.getElementById("userText").focus(); //Scroll down
                            //var newscrollHeight = $("#chatbox")[0].scrollHeight; //Scroll height after the request
                            //if(newscrollHeight > oldscrollHeight - 10){
                                //$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                            //}   
                        }
                    });
                }
 				
                //setInterval (loadLog, 3000);
				setTimeout(loadLog, 1000);
 
                $("#exit").click(function () {
                    var exit = confirm("Are you sure you want to end the session?");
                    if (exit == true) {
                    window.location = "chat.php?logout=true&botID=<?php echo $_SESSION['botID']; ?>";
                    }
                });
            });
		
//This function collects and sends a message from a button in the chat:
        function sendFromButton(sendText){
            document.getElementById('userText').value = sendText;					
            $( "#submitmsg" ).click();
        }		
		  
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
	<iframe id="updateFrame" width="1" height="1"></iframe>
	  
	  <script>
	  //Get the user timezone:
		  const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
		  document.getElementById("updateFrame").src = "setTimeZone.php?timezoneD=" + timezone;
		  console.log(timezone);
		  //alert(timezone);
	  </script>
	  
  </body>
</html>