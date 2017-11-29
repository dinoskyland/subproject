<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

include_once '../clisconnect.php';


// prepare and bind
$stmt = $connClis->prepare("DELETE from csm03_spl_pickup_request_staff where user_ID=?");
$stmt->bind_param("s", $staffid);
$staffid = $_POST['staffid'];

if ($stmt->execute() === TRUE) {
    echo '삭제되었습니다';
} else {
    echo "Error: " . $connClis->error;
}
$stmt->close();
?>
