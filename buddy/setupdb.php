<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "database.php";
global $csgo_db;

// Create database unnecsessary

// Create tables
$sql = "DROP TABLE IF EXISTS UserCell, Cells, Users;";
$sql .= "CREATE TABLE Cells (id INT NOT NULL AUTO_INCREMENT, meettime DATE, PRIMARY KEY (id)); ";
$sql .= "CREATE TABLE Users (netid VARCHAR(10), fname VARCHAR(30), lname VARCHAR(50), last_online DATETIME, PRIMARY KEY (netid) ); ";
$sql .= "CREATE TABLE UserCell (user VARCHAR(10), cell INT, FOREIGN KEY (user) REFERENCES Users(netid), FOREIGN KEY (cell) REFERENCES Cells(id) );";

echo $sql;
echo '<br><br>';

if ($csgo_db->multi_query($sql)) {
	do {
		$rslt = $csgo_db->use_result();
    	echo "Table created? ". $rslt;
		if(!$csgo_db->more_results()){break;}
	} while ($csgo_db->next_result());
} else {
    echo "Error creating tables: " . $csgo_db->error;
}

// populate students
$stufile = fopen('students.csv', 'r');

while(($arr = fgetcsv($stufile)) !== FALSE ) {
	$sqlInsert = sprintf("INSERT INTO Users (netid, fname, lname, last_online) VALUES ('%s', '%s', '%s', NULL)", $arr[0], $arr[1], $arr[2]);
	
	// echo "<br>".$sqlInsert;

	$rslt = $csgo_db->query($sqlInsert);
	if ( $rslt === TRUE ){
		// echo "✓";
	} else {
		echo "Error: " . $sqlInsert . "<br>" . $csgo_db->error;
	} 
}

// populate groups from group list
$grpfile = fopen('groups.txt', 'r');
if ($grpfile) {
    while (($line = fgets($grpfile)) !== false) {
		$sql_grpins = "INSERT INTO Cells (meettime) VALUES (NULL)";
		$csgo_db->query($sql_grpins);
		$grp_id = $csgo_db->insert_id;
		echo "making grp ".$grp_id;
	
		foreach(array_map('trim', explode(",", $line)) as $id){
			$sql_celluser = sprintf("INSERT INTO UserCell (user,cell) VALUES ('%s', %d)", $id, $grp_id);
			// echo "<br>". $sql_celluser;
			$rslt = $csgo_db->query($sql_celluser);
			if ( $rslt){
				// echo "... good";
			}
			else{
				echo "Error: " . $sql_celluser . "<br>" . $csgo_db->error;
			} 
		}	
    }

    fclose($grpfile);
} else {
	echo "Error opening groups.csv";
} 
//
//$csgo_db->close();
?>
