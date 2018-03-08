<?php

	$configJson = file_get_contents('/var/prison/textbelt_config.json');
	$config = json_decode($configJson,true);
	$capKey = $config["contact_capApiKey"];


	$capTest = curl_init();

	$capResponse = $_POST["g-recaptcha-response"];

	curl_setopt($capTest,CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($capTest,CURL_POST,3);
	curl_setopt($capTest,CURLOPT_POSTFIELDS,"secret=".$capKey."&response=".$capResponse."&remoteip=".$_SERVER["REMOTE_ADDR"]);
	curl_setopt($capTest,CURLOPT_RETURNTRANSFER,1);

	$capValidString = curl_exec($capTest);
	$capValidJson = json_decode($capValidString,TRUE);

	if($capValidJson["success"])
	{
		$name = escapeshellarg($_POST["name"]);
		$phone = escapeshellarg($_POST["phone"]);
		$message = escapeshellarg($_POST["message"]);

		$message = "CONTACT REQUESTED:\nNAME:".$name."\nPHONE:".$phone."\nMESSAGE:\n".$message;

		$url = "https://textbelt.com/text";

		$ch = curl_init();

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,3);
		curl_setopt($ch,CURLOPT_POSTFIELDS,"phone=".$config["phoneNumber"]."&message=".$message."&key=".$config["apiKey"]);

		curl_exec($ch);

	}

	header('Location: https://www.ARussellRentals.com');

?>
