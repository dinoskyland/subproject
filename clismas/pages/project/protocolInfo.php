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

$json=array();

//echo $protocol;
$sql = "SELECT pl_study_begin, pl_study_end, pl_sponser_name, pl_PI_name, pl_diseases, pl_estimate_cost FROM bim07_protocolbase WHERE pl_protocol_cd='$protocol'";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$json[]=$row;

echo json_encode($json);

?>