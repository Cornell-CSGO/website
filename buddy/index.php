<?php  
//	ini_set('display_errors', 1);
//	ini_set('display_startup_errors', 1);
//	error_reporting(E_ALL);
	
	// load twig engine...
	require_once '../vendor/autoload.php';

	$loader = new \Twig\Loader\FilesystemLoader([ __DIR__ . '/twigs',  __DIR__ . '/../twigs' ]);
	$twig = new \Twig\Environment($loader, [
	    // 'cache' => __DIR__ . '/twigs/cache',
		 // 'auto_reload' => true
	]);
	
	$template = $twig->load('buddy.twig.html');
	
	
	require_once "database.php";
	require_once "buddies_from_db.php";
	require_once "messages.php";
		
	require_once "load_netid.php";
	
	if($netid !== NULL) {
		// $cell = getCell($netid);
		$csgo_db->query("UPDATE Users SET last_online=now() WHERE netid='".$netid."'");

		$buds = getBuds($netid);
		$messages = getMessagesFor($netid);
		
		echo $template->render(['netid' => $netid, 'buddies' => $buds, 'messages'=>$messages]);
		
		$csgo_db->close();
	}
	else {
		echo $template->renderBlock('unauthenticated', []);
	}
?>
