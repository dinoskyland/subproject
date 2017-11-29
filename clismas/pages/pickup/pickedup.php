<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$id = $_POST['id']; 
// $pickupDong = $_POST['pickupDong']; 
// $pickupNang = $_POST['pickupNang'];
// $pickupShil = $_POST['pickupShil']; 
$regidate = date("Y-m-d h:ia");
$register = $_SESSION['login_user'];

$sql = "UPDATE csm03_pickup_request_detail set status='complete', regidate='$regidate' where id='$id'";
// $sql = "UPDATE csm03_pickup_request_detail set spl_freezed_picked='$pickupDong',spl_cold_picked='$pickupNang',spl_room_temp_picked='$pickupShil', status='complete', regidate='$regidate' where id='$id'";

if ($connClis->query($sql) === TRUE) {
    echo '입력되었습니다';
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
