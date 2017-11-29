<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../limsconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$protocol = $_POST['protocol']; 
$_SESSION['protocol'] = $_POST['protocol']; 
$_SESSION['protocolname'] = $_POST['protocolname']; 

if ($_SESSION['manager'] == 't') {
	$sql = "SELECT ps_site_cd, ps_site_name FROM bim07_protocol_site where protocol_cd='$protocol'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
			// echo $row['pl_protocol_cd'];
			echo "<option>{$row['ps_site_name']}</option>";	
		}
	} else {
		echo "<option>0 result</option>";		
	}
} else {
	echo "<option>{$_SESSION['site']}</option>";
}


?>
