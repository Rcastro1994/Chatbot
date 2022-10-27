<?php

//For local development server
$serverName = "localhost";
$userName = "root";
$passWord = "";


//Uncomment the next 3 lines after setting up a new user in PHPmyadmin for production:
//$serverName = "localhost";
//$userName = "chatbot";
//$passWord = "letsplayagame";

//Change the line below to match the name of your Database table:
$dbTable = "sdteeulmhcln";

$connection = mysqli_connect($serverName, $userName, $passWord, $dbTable, 3306);

// Check connection
if (!$connection) {
  die("DB Connection failed!");
}
//echo "<script>console.log('Connected successfully');</script>";
?>