<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$json = array();

$protocol     = $_SESSION['protocol'];
$json[] = ['protocol' => $protocol];

$protocolname = $_SESSION['protocolname'];
$json[] = ['protocolname' => $protocolname];

$site = $_SESSION['site'];
$json[] = ['site' => $site];

$person = $_SESSION['person'];
$json[] = ['person' => $person];

$phone = $_SESSION['phone'];
$json[] = ['phone' => $phone];

$address = $_SESSION['address'];
$json[] = ['address' => $address];

//echo "<option selected='selected'>$protocol</option>";

echo json_encode($json);
    # $site        = $_SESSION['site'];
    # $person      = $_SESSION['person'];
    # $address     = $_SESSION['address'];
    # $phone       = $_SESSION['phone'];
    # $requester   = $_SESSION['person'];
    # $temp        = getStaff($site, 1, $connClis);
    # $staff1name  = $temp[0][0];
    # $staff1phone = $temp[0][1];
    # $temp        = getStaff($site, 2, $connClis);
    # $staff2name  = $temp[0][0];
    # $staff2phone = $temp[0][1];




?>
