<?php

$target_dir = "csv/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists. Please rename your file, then try uploading again.";
  //$target_file = $target_dir .'avatar'. uniqid(). '.' . $imageFileType;
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 2000000) {
  echo "Sorry, your file is too large.<br>";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "csv") {
  echo "Sorry, only CSV files are allowed here.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

if($uploadOk == 1){
include('db.php');
	
	//Check DB to see if they were already called in:
	$table = 'botknowledge';
	$botID = $saveID;

	if($importType == "replace"){
		//Clear the current knowledge for this bot:
		mysqli_query($connection,"DELETE FROM $table WHERE BOTID = '$botID'");
		echo "All existing knowledge has been cleared and replaced.";
	}

$csvFile = $target_file;
	$fp = fopen($csvFile,'r') or die("can not open file");
		  $rowCount = 0;
	 	  $staffCount = 0;
	while($csv_line = fgetcsv($fp)) {
        $rowCount++;
        if($rowCount > 1){
            $botQuestion = $csv_line[0];
            $botResponse = $csv_line[1];
        	//Clean these two up:
            $botQuestion = $connection->real_escape_string($botQuestion);
            $botResponse = $connection->real_escape_string($botResponse);
        
            mysqli_query($connection,"INSERT INTO $table(BOTID, QUESTION,BOTRESPONSE) VALUES('$botID','$botQuestion','$botResponse');");
            //echo "INSERT INTO $table(QUESTION,BOTRESPONSE) VALUES('$botQuestion','$botResponse');<br>";
        }
	}
	//Remove the CSV file from the server:
	unlink($target_file);
}
?>