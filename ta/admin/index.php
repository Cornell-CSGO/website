<?php

require "../database.php";
require "admin_list.php";
require "../load_netid.php";

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if(! in_array($netid, $admin_list)) {
	die("<h3>Current netid <code>[$netid]</code> not an authorized admin</h3>");
}


function nrows($tablename) {
	require_once "../database.php";
	global $csgo_db;
	if($rslt = $csgo_db->query("SELECT COUNT(*) AS nrows FROM $tablename")) {
		return  $rslt->fetch_row()[0]; 
	}
}

$formrows = nrows("TAFormData");
$feedrows = nrows("TAFeedback");
$logrows = nrows("TAFormLog");

?>

<h3> Actions </h3>

<a href="setupdb.php">Reset Database </a>


<h3> Download Data: </h3>

 &nbsp;

<table>
	<tr>
		<td><a href="formdata">[form data]</a></td>
		<td><a href="feedback">[feedback]</a></td>
		<td><a href="log">[log]</a><td>
	</tr>
	<tr>
		<?php 
			echo "<td>($formrows rows)</td>";
			echo "<td>($feedrows rows)</td>";
			echo "<td>($logrows rows)</td>";
		 ?>
	</tr>
</table>
