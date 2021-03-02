<?php  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

var_dump($_POST);

// load twig engine...
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader([ __DIR__ . '/twigs',  __DIR__ . '/../twigs' ]);
$twig = new \Twig\Environment($loader, [
    // 'cache' => __DIR__ . '/twigs/cache',
 	// 'auto_reload' => true
]);


require_once "database.php";
require_once "load_netid.php";



$wantedta = intval(array_key_exists('wantedta', $_POST));
$consent = intval(array_key_exists('once_per_semester_consent', $_POST));
$overworked = intval(array_key_exists('overworked', $_POST));

// do this before we clear courese & instructor
if($consent) {
	if( $csgo_db->query(<<<SQL
		REPLACE INTO TASemesterAutofill
			(netid, course, instructor, appthours, irelation, proficiency, wantedta, consent)
		values (
			"$netid",
			"{$_POST['course']}",
			"{$_POST['instructor']}",
			"{$_POST['appthours']}",
			"{$_POST['irelation']}",
			"{$_POST['proficiency']}",
			"$wantedta", TRUE)
		SQL))
	{	echo "<h2> Autofill table updated </h2>";  }
	else {echo "Inserts failed (" . $csgo_db->errno . ') ' . $csgo_db->error;}
} else {
	$csgo_db-> query("DELETE FROM TASemesterAutofill WHERE netid = \"$netid\"");
}

if($_POST['associate_course'] == "never") {
	$_POST['instructor'] = NULL;
	$_POST['course'] = NULL;
}


$maybenetid = NULL;
if(array_key_exists('extra_associcate_netid', $_POST)) {
	$maybenetid = $netid;	
}

$defer = intval(array( "now" => FALSE, "later" => TRUE )[$_POST['associate_course']]);
$sql = <<<SQL
INSERT INTO TAFormLog (netid) values ("$netid");
INSERT INTO TAFormData
 		(course, instructor, appthours, irelation, proficiency, wantedta, ohours, ahours, happiness, overworked, defer)
 	values ( 
		"{$_POST['course']}", 
		"{$_POST['instructor']}",
		"{$_POST['appthours']}",
		"{$_POST['irelation']}",
		"{$_POST['proficiency']}",
		"{$wantedta}"
		"{$_POST['ahours']}",
		"{$_POST['ohours']}",
		"{$_POST['happiness']}",
		"{$overworked}"
		"{$defer}" );
INSERT INTO TAFeedback (extra, extra_netid, course, instructor)
	values ("{$_POST['extra']}", "$maybenetid", "{$_POST['course']}", "{$_POST['instructor']}");
SQL;


// $template = $twig->load('report.twig.html');
if($netid !== NULL) {
	if( $csgo_db->multi_query($sql)) {
		echo "<h1> :D </h1>";
	} else {
		echo "<h1> :( </h1>";
		echo "Inserts failed (" . $csgo_db->errno . ') ' . $csgo_db->error;
	}
	
	echo "<h1> :) </h1>";
	
	$csgo_db->close();
}
else {
	echo $template->renderBlock('unauthenticated', []);
}
?>
