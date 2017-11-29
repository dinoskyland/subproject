<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';

$pick_req_cd=substr(date("Ymd"),2);

$sql = "SELECT pick_req_cd FROM csm03_spl_pickup_request where pick_req_cd like '$pick_req_cd%' ORDER BY pick_req_cd DESC LIMIT 1";
$result = $connClis->query($sql);
//number of rows
//$numResults = $result->num_rows;

if ($result->num_rows == 0) {
	$pick_req_cd = $pick_req_cd . '001';
} else {
	while($row = $result->fetch_assoc()) {
		// last row
		$counter = substr($row['pick_req_cd'], 6);
		$counter++;
		if ($counter > 99) {
			$pick_req_cd = $pick_req_cd . $counter;
		} else if ($counter > 9) {
			$pick_req_cd = $pick_req_cd . '0' . $counter;
		} else {
			$pick_req_cd = $pick_req_cd . '00' . $counter;
		//echo $pick_req_cd;
		}
		
	}		

}

echo $pick_req_cd;
?>
