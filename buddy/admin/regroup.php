<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../database.php";
global $csgo_db;


// populate groups from group list
$grpfile = fopen('groups.txt', 'r');
if ($grpfile) {
	// assuming same order makes this easeier. Not same order => everyone's logs are cleared.
	$grp_id = 0;
	$participants = [];
    while (($line = fgets($grpfile)) !== false) {
		// $sql_grpins = "INSERT INTO Cells (meettime) VALUES (NULL)";
		// $csgo_db->query($sql_grpins);
		// $grp_id = $csgo_db->insert_id;
		// echo "making grp ".$grp_id;
		
		$grp_id += 1;

		foreach(array_map('trim', explode(",", $line)) as $id){
			echo " ; ".$id;
			array_push($participants, $id);
			
			$sql = "SELECT cell FROM UserCell WHERE user=".$id." AND cell=".$grp_id;
			if($rslt = $csgo_db->query($sql) ) {
				if ( $rslt->num_rows === 0) {
					echo "Zero rows for: ".$sql;
					// (1) if CellUser[$id] != $grp_id, drop messages for $grpid.
					echo "DELETING Messages from Group ". $grp_id." because ". $id . " has now joined. ";
					$csgo_db->query("DELETE FROM Messages WHERE channel=".$grp_id)
						or die($csgo_db->error);

					// (2) update CellUser set cell = $grp_id where user = $id
					echo "updating ". $grp_id;
					$csgo_db->query("UPDATE UserCell SET cell=".$grp_id." WHERE user='".$id."'")
						or die($csgo_db->error);
				}
			}
		}
		
    }
	echo "<h3> Total participants: " . count($participants) . "</h3>";
	// (3) remove all UserCell rows that are not in any group.
	$rslt = $csgo_db->query("SELECT user FROM UserCell");
	while ($row = $rslt->fetch_assoc()) {
		$id = $row['user'];
		if(! in_array($id, $participants, TRUE)) {
			echo "<br> ". $id . " not in $participants; removing".
			$csgo_db->query("DELETE FROM UserCell WHERE user='".$id."'");
		}
	}

    fclose($grpfile);
} else {
	echo "Error opening groups.csv";
} 
