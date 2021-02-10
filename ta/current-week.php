<?php
require_once 'database.php';
require_once 'load_netid.php';

$window_end = strtotime("last Friday");
$window_start = strtotime("-7 day", $window_end);

// echo "<h2>". date('j M', $start) ."</h2>";
// echo "<h2>". date('j M', $end) ."</h2>";

if($rslt = $csgo_db->query("SELECT ts FROM TAFormLog WHERE netid = \"$netid\"")) {
	if($rslt->num_rows > 0) {
		$last_submit = strtotime($rslt->fetch_row()[0]);
		$survey_recieving = strtotime("-3 day",strtotime("last Friday",  $last_submit)) < $window_start; 
	} else {
		$survey_recieving = true;
		$last_submit = NULL;
	}
} else {
	echo $csgo_db->error;
}

$timewindow = array('start'=> $window_start, 
	'end' => $window_end,
	'last_submit' => $last_submit,
	'receiving' => $survey_recieving);
	
// echo "<h2>" . var_dump($last_submit) . "</h2>";
?>
