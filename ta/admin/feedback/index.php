<?php

require "../../database.php";
require "../../load_netid.php";
require "../admin_list.php";

if(! in_array($netid, $admin_list)) {
 	throw new Exception("No permission to download form data!"); 
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

global $csgo_db;

require "../table2csv.php";

table2csv($csgo_db, "TAFeedback");
