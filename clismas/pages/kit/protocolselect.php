<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

//manager
include_once '../limsconnect.php';
$sql   = "SELECT pl_protocol_cd, pl_protocol_name FROM bim07_protocolbase";

$result = $conn->query($sql);
$json=array();

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $json[]=$row;
        //echo "<option id='{$row['pl_protocol_name']}'>{$row['pl_protocol_cd']}</option>";
    }
} else {
    //echo "0 results";
}
echo json_encode($json);
?>
