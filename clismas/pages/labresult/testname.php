<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../limsconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$subjectCode = $_GET['subjectCode']; 
$protocol = $_SESSION['protocol']; 
$site = $_SESSION['site']; 

$sql = "SELECT t_test_cd, t_test_name FROM lrm02_test_result where t_sbj_cd='$subjectCode' GROUP BY t_test_cd";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
		// echo $row['pl_protocol_cd'];
		echo "<option id='{$row['t_test_cd']}'>{$row['t_test_name']}</option>";	
	}
} else {
	echo "<option>0 result</option>";		
}


?>
