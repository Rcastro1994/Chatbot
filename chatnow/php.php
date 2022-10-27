<?php
echo 'PHP version: ' . phpversion();

echo '<hr>';

$uri = $_SERVER['REQUEST_URI'];
echo $uri; // Outputs: URI

echo '<hr>';

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
 
$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
echo $url; // Outputs: Full URL

?>