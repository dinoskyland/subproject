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

$sql = "SELECT manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE site_name='$site' and role='주담당자'";

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }
} else {
    //0 result
}

$sql = "SELECT manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE site_name='$site' and role='부담당자'";

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row;
    }
} else {
    //0 result
}

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
