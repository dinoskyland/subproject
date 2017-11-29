<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../limsconnect.php';
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 
$staffId = $_POST['staffid'];

$sql = "SELECT DISTINCT ps_site_name 
		FROM bim07_protocol_site ORDER BY ps_site_name ASC";

/*$sql = "SELECT DISTINCT ps_site_cd, ps_site_name 
		FROM bim07_protocol_site ORDER BY ps_site_name ASC";
*/

$result = $conn->query($sql);
$siteNameFromLims = array();

if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
		// echo $row['pl_protocol_cd'];
        $siteNameFromLims[] = $row; // 6, 7, 8
		//echo "<option>{$row['ps_site_name']}</option>";	
	}
} else {
	echo "0 results";
}

$sql = "SELECT DISTINCT site_name 
		FROM csm03_spl_pickup_request_staff WHERE user_ID = '$staffId' AND register IS NULL ORDER BY site_name ASC";

$result = $connClis->query($sql);
$siteNameFromClis = array();

if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
        $siteNameFromClis[] = $row; // 6, 7, 8
		// echo $row['pl_protocol_cd'];
	}
} else {
	echo "0 results";
}

foreach ($siteNameFromClis as $valueFromClis) {
	echo "$valueFromClis[site_name]";
}

$match = false;
foreach ($siteNameFromLims as $valueFromLims) {
	foreach ($siteNameFromClis as $valueFromClis) {
		if ($valueFromLims['ps_site_name'] == $valueFromClis['site_name']) {
			$match = true;
			break;	
		}
	}
	if ($match) {
		echo "<option selected>{$valueFromLims['ps_site_name']}</option>";	
		$match = false;	
	} else {
		echo "<option>{$valueFromLims['ps_site_name']}</option>";				
	}
}

?>
