<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$id = $_POST['id']; 
$regidate = date("Y-m-d h:ia");
$register = $_SESSION['login_user'];

$sql = "UPDATE csm03_pickup_request_detail set status='requested', regidate='$regidate', register='$register' where id='$id'";

if ($connClis->query($sql) === TRUE) {
    echo 'requested';
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}

/*$changed = date("Y-m-d h:ia");

$sql = "UPDATE csm03_spl_pickup_request set change_datetime='$changed' where id='$id'";

if ($connClis->query($sql) === TRUE) {
    echo '입력되었습니다';
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}
*/

?>
