<?php
//get subject info from bim05_subjects table with protocol and site
//which is used in modal

//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../limsconnect.php';

$options='';
$protocol=$_SESSION['protocol'];
$visitName=$_POST['visitName'];    
$json=array();

$sql = "SELECT ps_spl_condition FROM bim07_protocol_samples where protocol_cd='$protocol' AND ps_visit_name='$visitName' ORDER BY ps_spl_condition ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $json[]=$row;
    }
} else {
    echo "0 results";
}

echo json_encode($json);
?>
