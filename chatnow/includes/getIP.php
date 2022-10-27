<?php
  
// Declaring a variable to hold the IP
// address getHostName() gets the name
// of the local machine getHostByName()
// gets the corresponding IP
$localIP = getHostByName(getHostName());
  
// Displaying the address 
echo $localIP;
  
?>