
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../../database.php";
require "../../load_netid.php";

if(! in_array($netid, array("oer5"))) {
 	throw new Exception("No permission to perform Migration 1");
}

global $csgo_db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['confirm'] == 'Yes') {
        $sql = <<<SQL
		ALTER TABLE TAFormData
		MODIFY ts TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		ADD overworked BOOLEAN, 
		ADD wantedta BOOLEAN;
		SQL;

        if ($rslt = $csgo_db->query($sql)) {
			echo "<h2>Table alter successful</h2>";
        } else {
            echo "<h2>ERROR altering table</h2> <pre>" . $csgo_db->error . "</pre>";
        }
    }
    redirect($_POST['referer']);
}

// Create database unnecsessary

// Create tables
/* (existing tables for /buddy: Reactions, Messages, UserCell, Cells, Users) */

?>


<form action="update1.php" method="post">
    Are you sure you want to perform migration #1?
	<ul>
		<li> Add "Wanted" field to form-data table </li>
		<li> Add "overworked" field to form-data table </li>
	</ul>
	
    <input type="submit" name="confirm" value="Yes">
    <input type="submit" name="confirm" value="No">

    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
</form>
