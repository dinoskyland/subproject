<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../clisconnect.php';

$staffid = $_SESSION['login_user'];

$sql = "SELECT * FROM csm03_spl_pickup_request_staff WHERE user_ID='$staffid' AND register is not null";

$result = $connClis->query($sql);
$row = $result->fetch_assoc();
$json[]=$row;

echo json_encode($json);


?>