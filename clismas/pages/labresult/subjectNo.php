<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../limsconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$protocol = $_SESSION['protocol']; 
$site = $_SESSION['site']; 

$sql = "SELECT sbj_no, sbj_cd FROM bim05_subjects where ptl_cd='$protocol' and sbj_site='$site'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
		// echo $row['pl_protocol_cd'];
		echo "<option id='{$row['sbj_cd']}'>{$row['sbj_no']}</option>";	
	}
} else {
	echo "<option>0 result</option>";		
}



?>
