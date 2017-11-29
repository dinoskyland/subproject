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

$protocolname = $_SESSION['protocolname']; //1
$json[] = ['protocolname' => $protocolname];

$site = $_SESSION['site']; //2
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
        $json[] = $row; // 6
    }
} else {
    $json[] = ['manager_name' => '', 'mobile' => '', 'role' => ''];
    //0 result
}

$sql = "SELECT manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE site_name='$site' and role='부담당자'";

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row; //7
    }
} else {
    //0 result
    $json[] = ['manager_name' => '', 'mobile' => '', 'role' => ''];
}

$pickupTime = $_SESSION['pickupTime']; //9
$json[] = ['pickupTime' => $pickupTime];

$pickupLoc = $_SESSION['pickupLoc']; //8
$json[] = ['pickupLoc' => $pickupLoc];

echo json_encode($json);

?>
