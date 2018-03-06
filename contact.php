<?php

$configJson = file_get_contents('/var/prison/textbelt_config.json');
$config = json_decode($configJson,true);

$name = escapeshellarg($_POST["name"]);
$phone = escapeshellarg($_POST["phone"]);
$message = escapeshellarg($_POST["message"]);

$message = "CONTACT REQUESTED:\nNAME:".$name."\nPHONE:".$phone."\nMESSAGE:\n".$message;

//... This is probably the shittiest thing I've written tonight.... 
// There has to be a better way to do this
$message = str_replace('"','',$message);
$message = str_replace(';','',$message);
$message = str_replace('|','',$message);
$message = str_replace('&','',$message);
$message = str_replace('!','',$message);
$message = str_replace('#','',$message);

$command = "curl -X POST https://textbelt.com/text --data-urlencode phone='".$config["phoneNumber"]."' --data-urlencode message=\"".$message."\" -d key='".$config["apiKey"]."'";

shell_exec($command);
header('Location: https://www.ARussellRentals.com');

?>
