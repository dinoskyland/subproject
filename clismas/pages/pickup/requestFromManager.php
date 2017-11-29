<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$protocol = $_SESSION['protocol']; 
$site = $_SESSION['site']; // from protocolsearch2.php when registering.
$json = array();

$sql = "SELECT user_contact phone, desig_time pickupTime, desig_locaiton pickupLoc FROM csm01_users where protocol_cd='$protocol' AND site_name='$site' LIMIT 1";

$result = $connClis->query($sql);

if ($result->num_rows > 0) {
// output data of each row
    while($row = $result->fetch_assoc()) {
        // echo $row['pl_protocol_cd'];
        $json[] = $row; //0
    }
} else {
    $json[] = ['phone' => '', 'pickupTime' => '', 'pickupLoc' => '']; 
}

$sql = "SELECT manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE site_name='$site' and role='주담당자'";

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row; // 1
    }
} else {
    $json[] = ['manager_name' => '', 'mobile' => '', 'role' => '']; 
    //0 result
}

$sql = "SELECT manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE site_name='$site' and role='부담당자'";

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $json[] = $row; // 2
    }
} else {
    $json[] = ['manager_name' => '', 'mobile' => '', 'role' => '']; 
    //0 result
}
echo json_encode($json);
?>
