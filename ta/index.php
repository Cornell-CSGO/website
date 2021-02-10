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
	
	$template = $twig->load('report.twig.html');
	
	
	require_once "database.php";
	// require_once "buddies_from_db.php";
	// require_once "messages.php";
		
	require_once "load_netid.php";
	
	if($netid !== NULL) {
		if($rslt = $csgo_db->query(
				"SELECT * FROM TASemesterAutofill WHERE netid=\"$netid\" ")) {
			$saved = $rslt->fetch_assoc();
			$rslt->free();
		}
		require_once "current-week.php";
		// echo var_dump($timewindow);
		
		echo $template->render(['netid' => $netid, 'saved' => $saved, 'tw' => $timewindow]);
		
		$csgo_db->close();
	}
	else {
		echo $template->renderBlock('unauthenticated', []);
	}
?>
