<?php  
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
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

	// $netid = 'oer5';
	if(array_key_exists("NETID", getallheaders())) {
		$netid = getallheaders()["NETID"];
		$buds = getBuds($netid);
		
		echo $template->render(['buddies' => $buds]);
		
		$csgo_db->query("UPDATE Users SET last_online=now() WHERE netid='".$netid."'");
		$csgo_db->close();
	}
	else {
		echo $template->render(['buddies' => []]);
	}
?>
