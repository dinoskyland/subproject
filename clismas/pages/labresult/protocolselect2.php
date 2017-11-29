<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$_SESSION['site'] = null;
$_SESSION['protocol'] = null;
$_SESSION['protocolname'] = null;

//manager
include_once '../limsconnect.php';
$sql   = "SELECT pl_protocol_cd, pl_protocol_name FROM bim07_protocolbase";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        // echo $row['pl_protocol_cd'];
        echo "<option id='{$row['pl_protocol_name']}'>{$row['pl_protocol_cd']}</option>";
    }
} else {
    //echo "0 results";
}



?>
