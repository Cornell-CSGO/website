<?php  
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// var_dump($_POST);
// load twig engine...
require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader([ __DIR__ . '/twigs',  __DIR__ . '/../twigs' ]);
$twig = new \Twig\Environment($loader, [
    // 'cache' => __DIR__ . '/twigs/cache',
 	// 'auto_reload' => true
]);


require_once "database.php";
require_once "load_netid.php";
require_once "current-week.php";


// 
// var_dump($timewindow);
// var_dump(!$timewindow['receiving']);

if(!$timewindow['receiving']){
	die("<h1> already submitted for this week; ignoring duplicate submission. </h1>");
} else {
	echo "<h1>Response Recieved. Thank you for contributing!</h1><br/>";
	echo "Don't worry about the emoji logs below. <br> <small> (but if one is negative, the developper might appreciate a nudge) </small><br><br>";
}

function strORnull($val) {
	return empty($val) ? "NULL" : "\"$val\"";
}

$wantedta = intval(array_key_exists('wantedta', $_POST));
$consent = intval(array_key_exists('once_per_semester_consent', $_POST));
$overworked = intval(array_key_exists('overworked', $_POST));
// $appthours = empty($_POST['appthours']) ?  "NULL" : "\"{$_POST['appthours']}\"";
$appthrs = strORnull($_POST['appthours']);


// do this before we clear courese & instructor
if($consent) {
	if( $csgo_db->query(<<<SQL
		REPLACE INTO TASemesterAutofill
			(netid, course, instructor, appthours, irelation, proficiency, wantedta, consent)
		values (
			"$netid",
			"{$_POST['course']}",
			"{$_POST['instructor']}",
			{$appthrs},
			"{$_POST['irelation']}",
			"{$_POST['proficiency']}",
			"$wantedta", TRUE)
		SQL))
	{	echo "<h2> :parrot: </h2>";  }
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
$ohrs = strORnull($_POST['ohours']);
$ahrs = strORnull($_POST['ahours']);

$sql = <<<SQL
INSERT INTO TAFormLog (netid) values ("$netid");
INSERT INTO TAFormData
 		(course, instructor, appthours, irelation, proficiency, wantedta, ohours, ahours, happiness, overworked, defer)
 	values ( 
		"{$_POST['course']}", 
		"{$_POST['instructor']}",
		{$appthrs},
		"{$_POST['irelation']}",
		"{$_POST['proficiency']}",
		"{$wantedta}",
		{$ahrs},
		{$ohrs},
		{$_POST['happiness']},
		{$overworked},
		{$defer} );
INSERT INTO TAFeedback (extra, extra_netid, course, instructor)
	values ("{$_POST['extra']}", "$maybenetid", "{$_POST['course']}", "{$_POST['instructor']}");
SQL;


// echo "<pre>$sql</pre><br>";

// $template = $twig->load('report.twig.html');
if($netid !== NULL) {
	if( $csgo_db->multi_query($sql)) {
		$num_reslts = 0;
		do {
			$csgo_db->use_result();
			
			echo "&#x1F642"; // little happy face
			
			if( $csgo_db->more_results() ){
				printf("  &nbsp;&nbsp;  ");
			}
			
			$num_results += 1; // increment.
		} while ($csgo_db->next_result());
		// echo "<br/>[2] :D ";
		echo "<br/> [ $num_results / 3 ] table operations complete. ";
		if($num_results != 3) {
			echo "<br/> &#x1F628";
		}
	} else {
		echo "<h1> :( </h1>";
		echo "Inserts failed (" . $csgo_db->errno . ') ' . $csgo_db->error;
	}
	
	
	$csgo_db->close();
}
else {
	echo $template->renderBlock('unauthenticated', []);
}
// echo "</pre>";
?>
