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

$sql = "SELECT pp_visit_cd, pp_visit_name FROM bim07_protocolplan where protocol_cd='$protocol' ORDER BY pp_visit_cd DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    if ($row = $result->fetch_assoc()) {
        $_SESSION['visitName'] = $row['pp_visit_name']; //display 검체 y/n at first
	    $options = "<option>{$row['pp_visit_name']}</option>";
	    while ($row = $result->fetch_assoc()) {
	        $options .= "<option>{$row['pp_visit_name']}</option>";
	    }
    } else {
    	
    }

} else {
    echo "0 results";
}

echo $options;
?>
