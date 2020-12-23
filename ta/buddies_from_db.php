<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// requires database.php to be loaded for global!
function getBuds($netid) {
	global $csgo_db;
	// Create tables
	$sql = sprintf("SELECT other.fname as fname, other.lname as lname, other.netid as netid, other.last_online as last_online FROM UserCell JOIN Users AS other on other.netid=UserCell.user JOIN UserCell as me on me.cell=UserCell.cell WHERE me.user = '%s'", $netid);

	$rslt = $csgo_db->query($sql) ;

	$rows = [];
	while ($row = $rslt->fetch_assoc()) {
		array_push($rows, $row);
	}
	/* free result set */
	$rslt->free();
	return $rows;
}

?>
