<?php 
	$netid = NULL;
	if (array_key_exists("NETID", getallheaders())) {
		$netid = getallheaders()["NETID"];
	} elseif (array_key_exists("TEST_NETID", $Opt)) {
		$netid = $Opt['TEST_NETID'];
	}
?>
