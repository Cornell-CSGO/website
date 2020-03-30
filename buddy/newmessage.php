<?php 
	require_once "database.php";
	require_once "messages.php";
	require_once "buddies_from_db.php";

	require_once "load_netid.php";
	if($netid !== NULL) {
		$cell = getCell($netid);
		sendMessage($netid, $cell, $_POST["message"], null);
		
		if($_POST["asemail"]) {
			$buds = getBuds($netid);
			foreach($buds as $bud) {
				$to_addr[] = $bud['netid'] . "@cornell.edu";
				$to_str[] = $bud['fname'] . ' <'.$bud['netid'].'@cornell.edu>';
			}
			
			$to = implode(', ', $to_addr);
			$subject = '[Buddy System Message]';
			$headers[] = 'To: '.implode(', ', $to_str);
			$headers[] = 'From: '.$netid.'<noreply@csgo.cornell.edu>';
			
			// echo $to;
			// echo $subject;
			// echo $_POST['message'];
			// echo implode("\r\n", $headers);
			mail($to, $subject, $_POST["message"], implode("\r\n", $headers));
		}
	}
	else {
		header('HTTP/1.0 403 Forbidden'); 
		die("You don't have permission to send messages. Log in first.");
	}

 ?>
