<?php 
	$netid = NULL;
	if (array_key_exists("uid", $_SERVER)) {
		$netid = $_SERVER["uid"];
	} elseif (array_key_exists("TEST_NETID", $Opt)) {
		$netid = $Opt['TEST_NETID'];
	}
?>
