<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$protocol = $_SESSION['protocol'];
$register = $_SESSION['login_user'];
$kitname = $_POST['kitname'];
$date = date("Ymd");

$sql = "INSERT INTO csm04_protocol_KIT (protocol_cd,kit_name,regidate,register) VALUES ('$protocol','$kitname','$date','$register')";

if ($connClis->query($sql) === TRUE) {
// echo "1";
} else {
	echo "Error: " . $sql . "<br>" . $connClis->error;
}
?>
