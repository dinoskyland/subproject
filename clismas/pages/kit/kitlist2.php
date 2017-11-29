<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../clisconnect.php';

$protocol = $_SESSION['protocol'];

$requestData= $_REQUEST;

$sql = "SELECT id,kit_name FROM csm04_protocol_KIT where protocol_cd='$protocol'";
$result = $connClis->query($sql);

$result        = $connClis->query($sql);
$totaldata     = $result->num_rows;
$totalfiltered = $result->num_rows;

$jason_data = array();

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $jason_data[] = $row;
    }
} else {
    //echo "0 results";
}

$json = array(
    "draw" => intval($_REQUEST['draw']),
    "recordsTotal" => $totaldata,
    "recordsFiltered" => $totalfiltered,
    "data" => $jason_data
);
echo json_encode($json);

?>
