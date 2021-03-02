
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
        $sql = "ALTER TABLE TAFormData  ADD appthours INT";
        if ($rslt = $csgo_db->query($sql)) {
			echo "<h2>Table alter successful</h2>";
        } else {
            echo "<h2>ERROR altering table</h2> <pre>" . $csgo_db->error . "</pre>";
        }
        
        
        $sql = "ALTER TABLE TASemesterAutofill ADD appthours INT";

        if ($rslt = $csgo_db->query($sql)) {
			echo "<h2>Table alter successful</h2>";
        } else {
            echo "<h2>ERROR altering table</h2> <pre>" . $csgo_db->error . "</pre>";
        }
    }
    exit;
    // redirect($_POST['referer']);
}

// Create database unnecsessary

// Create tables
/* (existing tables for /buddy: Reactions, Messages, UserCell, Cells, Users) */

?>


<form action="update2.php" method="post">
    Are you sure you want to perform migration #2?
	<ul>
		<li> Add "Wanted" field to form-data table </li>
		<li> Add "overworked" field to form-data table </li>
	</ul>
	
    <input type="submit" name="confirm" value="Yes">
    <input type="submit" name="confirm" value="No">

    <input type="hidden" name="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
</form>
