<?php

$text = stripslashes(htmlspecialchars($text));

include('db.php');

$table = "botlist";
$SQL = "SELECT * from $table WHERE ID=$saveID ORDER BY ID DESC LIMIT 1";
		 if ($result = mysqli_query($connection, $SQL)) {
            while ($row = mysqli_fetch_array($result)) {
				$threshold = $row['CLOSEMATCH'];
				$exactThreshold = $row['EXACTMATCH'];
			}
		 }

$table = 'botknowledge';
$SQL = "SELECT * from $table WHERE BOTID=$botID";
$textMatch = strtoupper(($text));

$responseCount = 0;
	$exactCount = 0;
	$bestMatch = 0;
	$exactID = array();
	$closeID = array();
	$exactMatch = array(); //List anything that is almost an exact match
	$exactPhrase = array();
	$exactPercent = array(); 
	$botResponses = array(); //List anything that exceeds the threshold for a match
	$closePhrase = array();
	$closePercent = array();

if ($result = mysqli_query($connection, $SQL)) {
		while ($row = mysqli_fetch_array($result)) {
		    $botQuestion = $row['QUESTION'];
			$botResponse = $row['BOTRESPONSE'];
			$responseID = $row['ID'];
			//Is it close enough to respond?
			similar_text($textMatch, strtoupper($botQuestion), $matchPercent);
			if($matchPercent >= $exactThreshold){
			    $exactCount++;
				$exactID[] = $responseID;
				$exactPhrase[] = $botQuestion;
			    $exactMatch[] = $botResponse;
				$exactPercent[] = $matchPercent;
			}
			if($matchPercent >= $threshold && $matchPercent < $exactThreshold){
    			$responseCount++;
				$closeID[] = $responseID;
				$closePhrase[] = $botQuestion;
    			$botResponses[] = $botResponse;
				$closePercent[] = $matchPercent;
			}
			if($matchPercent > $bestMatch){
			    $bestMatch = number_format($matchPercent, 0);
			}
		}
	}

//Show best matches first:
if($exactCount > 0){
	echo '<br><strong>Near exact matches ('.$exactThreshold.'+):</strong><br>';
	echo '<table class="table table-bordered table-hover" style="background-color:#fff;">
		  <thead>
			<tr>
			  <th scope="col">Statement</th>
			  <th scope="col">Bot Response</th>
			  <th scope="col">Match %</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead><tbody>';
	for($i = 0; $i < $exactCount; $i++){
		echo '<tr>
		  <td>'.$exactPhrase[$i].'</td>
		  <td>'.$exactMatch[$i].'</td>
		  <td>'.number_format($exactPercent[$i],1).'</td>
		  <td><a href="#" data-toggle="modal" data-target="#editPopout" onclick="document.getElementById(\'userSays2\').value=\''.urlencode($exactPhrase[$i]).'\'; document.getElementById(\'botReplyNew\').value=\''.urlencode($exactMatch[$i]).'\'; document.getElementById(\'editID\').value=\''.$exactID[$i].'\'; fixForm();">Edit</a> | <a href="#" onclick="this.parentElement.parentElement.style.display=\'none\'; deleteConfirm(\''.$exactID[$i].'\');">Delete</a></td>
		</tr>';
		}
	echo '</tbody></table><br>';
}

//Show close matches next:
if($responseCount > 0){
	echo '<br><strong>Matches that beat the threshold ('.$threshold.'+):</strong><br>';
	echo '<table class="table table-bordered table-hover" style="background-color:#fff;">
		  <thead>
			<tr>
			  <th scope="col">Statement</th>
			  <th scope="col">Bot Response</th>
			  <th scope="col">Match %</th>
			  <th scope="col">Action</th>
			</tr>
		  </thead><tbody>';
	for($i = 0; $i < $responseCount; $i++){
		echo '<tr>
		  <td>'.$closePhrase[$i].'</td>
		  <td>'.$botResponses[$i].'</td>
		  <td>'.number_format($closePercent[$i],1).'</td>
		  <td><a href="#" data-toggle="modal" data-target="#editPopout" onclick="document.getElementById(\'userSays2\').value=\''.urlencode($closePhrase[$i]).'\'; document.getElementById(\'botReplyNew\').value=\''.urlencode($botResponses[$i]).'\'; document.getElementById(\'editID\').value=\''.$closeID[$i].'\'; fixForm();">Edit</a> | <a href="#" onclick="this.parentElement.parentElement.style.display=\'none\'; deleteConfirm(\''.$closeID[$i].'\');">Delete</a></td>
		</tr>';
		}
	echo '</tbody></table><br>';
}

if($exactCount == 0 && $responseCount == 0){
	echo '<h3>No response for that comment!</h3>';
}

echo '<small>*Not getting quality responses?<br> Consider adding more info to your bot or <a href="botSettings.php?botID='.$saveID.'">adjusting confidence levels in the bot settings</a>.</small><br>';

?>