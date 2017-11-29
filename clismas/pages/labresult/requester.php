<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$json = array();

$protocol     = $_SESSION['protocol']; //0
$json[] = ['protocol' => $protocol];

$protocolname = $_SESSION['protocolname'];
$json[] = ['protocolname' => $protocolname];

$site = $_SESSION['site'];
$json[] = ['site' => $site];

$person = $_SESSION['person'];
$json[] = ['person' => $person];

$phone = $_SESSION['phone'];
$json[] = ['phone' => $phone];

$address = $_SESSION['address']; //5
$json[] = ['address' => $address];

echo json_encode($json);
?>
