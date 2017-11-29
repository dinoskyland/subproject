<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';

$id = $_GET['id']; 

$sql = "SELECT requester, requester_mobile, desig_time, desig_location FROM csm03_spl_pickup_request where pick_req_cd = '$id'";
$result = $connClis->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
    $json[] = $row;
}

echo json_encode($json);
?>
