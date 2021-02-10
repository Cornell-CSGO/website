<?php
require_once "database.php";
require_once "load_netid.php";


if($rslt = $csgo_db->query(<<<SQL
DELETE FROM TAFormLog WHERE netid = "$netid";
SQL)) {
	echo "<h2>Purge Successful for netid <code>$netid</code></h2>";
}
