<?php
// requires database.php to be loaded for global!
function getMessagesFor($netid) {
	global $csgo_db;
	// Create tables
	$sql = sprintf("SELECT sender, data, parent,ts FROM Messages JOIN UserCell as me on me.cell=Messages.channel WHERE me.user = '%s' ORDER BY ts DESC", $netid);

	$rslt = $csgo_db->query($sql) ;
	
	$rows = [];
	while ($row = $rslt->fetch_assoc()) {
		array_push($rows, $row);
	}
	/* free result set */
	$rslt->free();
	return $rows;
}

//only works if theres's a unique cell
function getCell($netid) {
	global $csgo_db;
	// Create tables
	$sql = sprintf("SELECT cell from UserCell WHERE user = '%s'", $netid);
	$rslt = $csgo_db->query($sql) ;
	return $rslt->fetch_assoc()["cell"];
}

function sendMessage($netid, $channel, $message, $parent) {
	global $csgo_db;
	$stmt = $csgo_db->prepare("INSERT INTO Messages (parent,data,sender,channel) VALUES (?,?,?,?)");
	$stmt->bind_param("sssi", $p, $m, $n, $c);
	
	// this is very stupid.
	$n = $netid;
	$p = $parent;
	$m = $message;
	$c = $channel;
	
	$rc = $stmt->execute();
	if ($rc === false) {
		die('execute failed()' . htmlspecialchars($stmt->error));
	}	
	$stmt->close();
}

?>
