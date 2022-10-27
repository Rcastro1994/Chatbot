<?php

function setupDatabase(){
	$serverName = "localhost:3306";
	$userName = "root";
	$passWord = "root";

	$db = new PDO("mysql:host=$serverName", $userName, $passWord);

	$query = file_get_contents("newDB.sql");

	$stmt = $db->prepare($query);

	if ($stmt->execute()){
		 echo "<center>Database Tables set up successfully...</center>";
	}else{ 
		 echo "<center>Database Setup Failure</center>";
	}
}

if(isset($_GET['download']) && $_GET['download'] == "yes"){ 
	
	//Make sure we didn't already do this:
	if(is_dir('chatnow')){
		exit('<center>Seems you\'ve already done this!<br>Try removing the chatbot folder, then running this script again!<br><br><br><a href="import.php">OK, try again</a><br><br><br><a href="phpMyAdmin" target="_blank">Set up the database</a></center>');
	}
	
	// Initialize a file URL to the variable
	$url = 'https://www.phpchatbot.com/chatbot/latest.zip';

	// Use basename() function to return the base name of file
	$file_name = basename($url);

	// Use file_get_contents() function to get the file
	// from url and use file_put_contents() function to
	// save the file by using base name
	if(file_put_contents( $file_name,file_get_contents($url))) {
		//echo "File downloaded successfully<br>";

		$zip = new ZipArchive;

		// Zip File Name
		if ($zip->open('latest.zip') === TRUE) {

			// Unzip Path
			mkdir('chatnow');
			$zip->extractTo('chatnow/');
			$zip->close();
			//Setup the DB:
			setupDatabase();
			echo '<center><h1><img src="https://www.phpchatbot.com/chatnow/images/logo200.png"><br>PHP ChatBot Package Import Tool</h1>Import Process Successful!<br><br><a href="chatnow" target="_blank">Start working with your ChatBots</a><br><br>
			<ol>
			</ol>
			</center>';
		} else {
			echo '<center>Import Process failed</center>';
		}
	}
	else {
		echo "<center>File download failed.</center>";
	}
}else{
	echo '<center><h1><img src="https://www.phpchatbot.com/chatnow/images/logo200.png"><br>PHP ChatBot Package Import Tool</h1>
	<a href="?download=yes">Click here to import the PHP ChatBot files to your local sever</a>
	</center>';
}
 
?>