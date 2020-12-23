<?php 
require dirname( __FILE__ ) . "/../conf/options.php";
global $Opt;
$servername = "localhost";
$username = $Opt["dbUser"];
$password = $Opt["dbPassword"];
$dbname = $Opt["dbName"];

global $csgo_db;
$csgo_db = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($csgo_db->connect_error) {
    die("Connection failed: " . $csgo_db->connect_error);
}
?>
