<?php 
	require_once "database.php";
	require_once "messages.php";

	if(array_key_exists("NETID", getallheaders())) {
		$netid = getallheaders()["NETID"];
		$cell = getCell($netid);
		sendMessage($netid, $cell, $_POST["message"], null);
	}
	else {
		header('HTTP/1.0 403 Forbidden'); 
		die("You don't have permission to send messages. Log in first.");
	}

 ?>
