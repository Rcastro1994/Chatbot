<?php

if(!isset($_POST['serverName']) || !isset($_POST['userName']) || !isset($_POST['passwordName']) || !isset($_POST['dbName']) || !isset($_POST['dbPort'])){
    //Show Table
    echo '<center><h1>DB Connection Helper:</h1></center>';

    echo '<center><form action="" method="POST">
    <label for="serverName">Hostname:</label>
    <input type="text" id="serverName" name="serverName" placeholder="localhost" value="localhost" autofocus><br><br>
    
    <label for="userName">DB Username:</label>
    <input type="text" id="userName" name="userName" placeholder="root" value="root"><br><br>
    
    <label for="passwordName">DB Password:</label>
    <input type="text" id="passwordName" name="passwordName" placeholder="root" value="root"><br><br>

    <label for="dbName">DB Name:</label>
    <input type="text" id="dbName" name="dbName" placeholder="chatbot" value="chatbot"><br><br>


    <label for="dbPort">DB Port:</label>
    <input type="text" id="dbPort" name="dbPort" placeholder="3306" value="3306"><br><br>

    <input type="submit" value="Test Connection">
    </form></center>';

    exit();
}

//For local development server
$serverName = $_POST['serverName'];
$userName = $_POST['userName'];
$passWord = $_POST['passwordName'];

$dbName = $_POST['dbName'];
$dbPort = $_POST['dbPort'];

$connection = mysqli_connect($serverName, $userName, $passWord, $dbName, 3306);

//echo $serverName.', '.$userName.', '.$passWord.', '.$dbName.', '.$dbPort.'<hr>';

// Check connection
if (!$connection) {
  die("<center><h1>DB Connection failed!</h1><a href='dbTest.php'>Try Again</a></center>");
}else{
    echo '<center><h1>Success!</h1>Connected to Database named <u>'.$dbName.'</u></center>';
}
//echo "<script>console.log('Connected successfully');</script>";
?>