<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

$pickup_no = $_POST['pickup_no'];
$subject = $_POST['subject'];
$subjectCode = $_POST['subjectCode'];
$visitName = $_POST['visitName'];
$dong = $_POST['dong'];
$jang = $_POST['jang'];
$shil = $_POST['shil'];
$status = 'requested';
$regidate = date("Y-m-d h:ia");
$register = $_SESSION['person'];
//$register = $_SESSION['login_user'];

//insert kit
$sql = "INSERT INTO csm03_pickup_request_detail (pick_req_cd,sbj_cd,sbj_no,visit_name,spl_freezed_cnt,spl_cold_cnt,spl_room_temp_cnt,status,regidate,register,change_datetime,changer) VALUES ('$pickup_no','$subjectCode','$subject','$visitName','$dong','$jang','$shil','$status','$regidate','$register','$regidate','$register')";

if ($connClis->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}

?>
