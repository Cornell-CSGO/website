<?php


function table2csv($database, $tablename) {
	header('Content-Type: text/csv; charset=utf-8');
	header("Content-Disposition: attachment; filename=$tablename.csv");

	$output =  fopen('php://output', 'w');
	$rslt = $database->query("SELECT * FROM $tablename") or die($database->error());

	$fieldnames= array_column($rslt->fetch_fields(), 'name');
	fputcsv($output, $fieldnames);
	// echo count($fieldnames ). "<br>";

	while($row = $rslt->fetch_row()) {
		// echo count($row ). "<br>";
		fputcsv($output, $row); 
	}

	$rslt->free();
	fclose($output);
}

//no longer necessary
// echo $out;
