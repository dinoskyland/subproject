<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../clisconnect.php';

$userid = $_SESSION['login_user'];

$sql = "SELECT * FROM csm01_users WHERE user_ID='$userid'";

$result = $connClis->query($sql);
$row = $result->fetch_assoc();
$json[]=$row;

echo json_encode($json);


?>