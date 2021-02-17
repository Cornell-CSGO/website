<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require "../database.php";
require "../load_netid.php";
if(! in_array($netid, array("oer5"))) {
 	throw new Exception("No permission to clear database");
}

global $csgo_db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['confirm'] == 'Yes') {
        $sql = <<<SQL
        DROP TABLE IF EXISTS TAFormLog, TASemesterAutofill, TAFormData, TAFeedback;
        CREATE TABLE TAFormLog (
        	id INT NOT NULL AUTO_INCREMENT,
        	netid VARCHAR(10),
        	ts TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP),
        		PRIMARY KEY (id)); 
        CREATE TABLE TASemesterAutofill (
        	netid VARCHAR(10),
        	course VARCHAR(20),
        	instructor VARCHAR(30),
        	irelation VARCHAR(40),
        	proficiency INT,
        	wantedta VARCHAR(10),
        	consent VARCHAR(10),
        		PRIMARY KEY (netid)	);
        CREATE TABLE TAFormData (
        	id INT NOT NULL AUTO_INCREMENT,
         	course VARCHAR(20),
        	instructor VARCHAR(30),
        	irelation VARCHAR(40),
        	proficiency INT,
        	ohours FLOAT,
        	ahours FLOAT,
        	happiness INT,
        	defer BOOLEAN,
         	ts TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP),
        		PRIMARY KEY (id));
         CREATE TABLE TAFeedback (
        	extra TEXT,
        	extra_netid VARCHAR(10),
        	course VARCHAR(20),
        	instructor VARCHAR(30),
        	ts TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP));
        SQL;

        // echo $sql;
        // echo '<br><br>';

        if ($csgo_db->multi_query($sql)) {
        	do {
        		$rslt = $csgo_db->use_result();
            	echo "Table created~ ". $rslt;
        		if( $csgo_db->more_results() ){
        			 printf("  &  ");
        		}
        		else {  }
        		// else { echo "MORE RESULTS ?"; }
        	} while ($csgo_db->next_result());
        } else {
            echo "Error creating tables: " . $csgo_db->error;
        }
    }
    redirect($_POST['referer']);
}

// Create database unnecsessary

// Create tables
/* (existing tables for /buddy: Reactions, Messages, UserCell, Cells, Users) */

?>


<form action="setupdb.php" method="post">
    Are you sure you want to reset the database?
    <input type="submit" name="confirm" value="Yes">
    <input type="submit" name="confirm" value="No">

    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
</form>
