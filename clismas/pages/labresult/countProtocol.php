<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../limsconnect.php';

$protocol=$_SESSION['protocol'];
$count = '';

$sql = "SELECT COUNT(ptl_cd) as countProtocol FROM bim05_subjects where ptl_cd='$protocol'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
    $count = $row['countProtocol'];
} else {
    echo "0 results";
}

echo $count;
?>
