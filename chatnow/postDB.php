<?php

session_start();

//Which bot are we talking to?
if (!isset($_SESSION['conversationID'])) {
    $_SESSION['conversationID'] = session_id();
}
//Get the bot ID:
if (isset($_POST['botID'])) {
    $_SESSION['botID'] = $_POST['botID'];
}
if (!isset($_SESSION['botID'])) {
    $_SESSION['botID'] = 1;
}

$conversationID = $_SESSION['conversationID'];
$botID = $_SESSION['botID'];
$botName = $_SESSION['botName'];
$botAvatar = $_SESSION['botAvatar'];

//Try to get the user time zone:
if (!isset($_SESSION['USERTIME'])) {
    $_SESSION['USERTIME'] = "America/New_York";
}
date_default_timezone_set($_SESSION['USERTIME']);

function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }

    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

function linkify($value, $protocols = array('http', 'mail'), array $attributes = array()) {
    // Link attributes
    $attr = '';
    foreach ($attributes as $key => $val) {
        $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
    }

    $links = array();

    // Extract existing links and tags
    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {
        return '<' . array_push($links, $match[1]) . '>';
    }, $value);

    // Extract text links for each protocol
    foreach ((array) $protocols as $protocol) {
        switch ($protocol) {
            case 'http':
            case 'https': $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    if ($match[1])
                        $protocol = $match[1];
                    $link = $match[2] ?: $match[3];
                    return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
                }, $value);
                break;
            case 'mail': $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
            case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\">{$match[0]}</a>") . '>';
                }, $value);
                break;
            default: $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
        }
    }

    // Insert all links
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {
        return $links[$match[1] - 1];
    }, $value);
}

$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");

if (isset($_SESSION['name'])) {
    $saveName = $_SESSION['name'];
    $text = $_POST['text'];
    $textMatch = trim($text); //To check the DB for a response
    $ext = getExtension($text);
    $extCheck = strtolower($ext);

    if (in_array($extCheck, $valid_formats) && substr_count($text, ' ') == 0) {
        $imageCode = '<img style="max-width:99%;" src="' . $text . '"><br>';
    } else {
        $imageCode = '';
    }

    $onClick = ' <small><a onClick="copyData(\'' . $text . '\');">📋</a></small>';
    $text = linkify($text); //Search for links and linkify them
    //This is the experimental anti XSS piece:
    $text = stripslashes(htmlspecialchars($text));
    $converted = array("&lt;a", "href=&quot;", "&quot;&gt;", "&lt;/a&gt;");
    $reverted = array('<a', 'href="', '">', '</a>');
    $newText = str_replace($converted, $reverted, $text);
    $text = linkify($newText);
    //End XSS prevention
    $imagen = $_SESSION['identity']->imagen;
    $text_message = '<li class="in"><div class="chat-img"><img alt="Avatar" src="../uploads/images/' . $imagen . '"></div><div class="chat-body"><div class="chat-message"><h5>' . $_SESSION['name'] . '</h5><p>' . $imageCode . $text . '<br><small>' . date("g:i A") . '</small></p></div></div></li>';

    include('db.php');
    //save to logs for display in chat window:
    $table = "botlogs";
    $timeStamp = time();
    $saveDialog = $connection->real_escape_string($text_message);
    mysqli_query($connection, "INSERT INTO $table(BOTID,CONVERSATIONID,DIALOG,TIMESTAMP) VALUES('$botID','$conversationID','$saveDialog','$timeStamp');");
    sleep(4);

    //Check DB to see if they were already called in:
    $table = 'botknowledge';
    $SQL = "SELECT * from $table WHERE BOTID=$botID";

    //This should go in the bot settings in the table:
    $threshold = $_SESSION['closeMatch'];
    $exactThreshold = $_SESSION['exactMatch'];

    $responseCount = 0;
    $exactCount = 0;
    $bestMatch = 0;
    $exactMatch = array(); //List anything that is almost an exact match
    $botResponses = array(); //List anything that exceeds the threshold for a match
    if ($result = mysqli_query($connection, $SQL)) {
        while ($row = mysqli_fetch_array($result)) {
            $botQuestion = $row['QUESTION'];
            $botResponse = $row['BOTRESPONSE'];
            //Is it close enough to respond?
            similar_text(strtoupper($textMatch), strtoupper($botQuestion), $matchPercent);
            if ($matchPercent >= $exactThreshold) {
                $exactCount++;
                $exactMatch[] = $botResponse;
            }
            if ($matchPercent >= $threshold) {
                $responseCount++;
                $botResponses[] = $botResponse;
            }
            if ($matchPercent > $bestMatch) {
                $bestMatch = number_format($matchPercent, 0);
            }
        }
    }
    if ($exactCount > 0) {
        shuffle($exactMatch);
        $text = $exactMatch[0];

        //Check for custom replies:
        if ($text == "getTIME") {
            $text = "La hora es " . date("g:i a");
        } else if ($text == "getDATE") {
            $text = "La fecha es " . date("l, F jS, Y");
        } else if ($text == "getANSIEDAD") {
            $text = '<a>Ingresa al siguiente test: http://localhost/proyecto/test/responderTest&id=2</a>';
        } else if ($text == "getDIAGNOSTICO") {
            $text = '<a>Pronto te sentiras mejor! Ingresa al siguiente link para ver tu diagnóstico inicial: http://localhost/proyecto/usuario/verGrafico</a>';
        } else if ($text == "getTEST1") {
            $text = '<a>Ingresa al siguiente test para poder ayudarte: http://localhost/proyecto/test/responderTest&id=4</a>';
        }

        $ext = getExtension($text);
        $extCheck = strtolower($ext);
        if (in_array($extCheck, $valid_formats) && substr_count($text, ' ') == 0) {
            $imageCode = '<img style="max-width:99%;" src="' . $text . '"><br>';
        } else {
            $imageCode = '';
        }

        $onClick = ' <small><a onClick="copyData(\'' . $text . '\');">📋</a></small>';
        $text = linkify($text); //Search for links and linkify them
    } else if ($responseCount > 0) {
        shuffle($botResponses);
        $text = $botResponses[0];

        //Check for custom replies:
        include('customResponses.php');

        $ext = getExtension($text);
        $extCheck = strtolower($ext);
        if (in_array($extCheck, $valid_formats) && substr_count($text, ' ') == 0) {
            $imageCode = '<img style="max-width:99%;" src="' . $text . '"><br>';
        } else {
            $imageCode = '';
        }
        $onClick = ' <small><a onClick="copyData(\'' . $text . '\');">📋</a></small>';
        $text = linkify($text); //Search for links and linkify them
    } else {
        $SQL = "SELECT * from $table WHERE BOTID=$botID AND QUESTION='IDKNULL' ORDER BY RAND() LIMIT 1";
        $idk = 0;
        if ($result = mysqli_query($connection, $SQL)) {
            while ($row = mysqli_fetch_array($result)) {
                $text = $row['BOTRESPONSE'];
                $idk = 1;
            }
        }
        if (!$idk) {
            $text = "I don't have an appropriate response for that. <br>Maybe I have not been trained yet.";
            //$text = "I don't have an appropriate response for that. <br>Maybe I have not been trained yet.<br><small>".$bestMatch."%</small>";
        }
        $text = linkify($text); //Search for links and linkify them
        //$text = "I don't have an appropriate response for that. <small>".$bestMatch."%</small>";
        $imageCode = '';
        $onClick = ' <small><a onClick="copyData(\'No response.\');">📋</a></small>';
    }
    //End Q Match
    $text_message = '<li class="out"><div class="chat-img"><img alt="Avatar" src="' . $botAvatar . '"></div><div class="chat-body"><div class="chat-message"><h5>' . $botName . '</h5><p>' . $imageCode . $text . '<br><small>' . date("g:i A") . '</small></p></div></div></li>';

    //Save to conversations for training, etc
    $table = "botconversations";
    //Clean these two up:
    $userQuestion = $connection->real_escape_string($textMatch);
    $botResponse = $connection->real_escape_string($text);
    $saveName = $connection->real_escape_string($saveName);
    $botConfidence = $bestMatch;
    $timeStamp = time();

    mysqli_query($connection, "INSERT INTO $table(BOTID,CONVERSATIONID,USERQUERY,BOTRESPONSE,BOTCONFIDENCE,USERNAME,TIMESTAMP) VALUES('$botID','$conversationID','$userQuestion','$botResponse','$botConfidence','$saveName','$timeStamp');");

    //Save to log for display in the actual chat page:
    $table = "botlogs";
    $saveDialog = $connection->real_escape_string($text_message);
    mysqli_query($connection, "INSERT INTO $table(BOTID,CONVERSATIONID,DIALOG,TIMESTAMP) VALUES('$botID','$conversationID','$saveDialog','$timeStamp');");
}
?>