<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

include_once '../clisconnect.php';

if($_SESSION['manager'] == 't'){
	// prepare and bind
	$stmt = $connClis->prepare("UPDATE csm01_users set user_name=?,user_contact=?,user_email=?,user_address=?,check_lab1=?,check_lab2=?,check_pick1=?,check_pick2=?,check_kit1=?,check_kit2=?,regidate=?,register=? where user_ID=?");
	$stmt->bind_param("sssssssssssss", $person, $phone, $email, $address, $lab1, $lab2, $pick1, $pick2, $kit1, $kit2, $regidate, $register, $userid);

	$person   = $_POST['person'];
	$phone    = $_POST['phone'];
	$email    = $_POST['email'];
	$address  = $_POST['address'];
	$lab1     = $_POST['lab1'];
	$lab2     = $_POST['lab2'];
	$pick1    = $_POST['pick1'];
	$pick2    = $_POST['pick2'];
	$kit1     = $_POST['kit1'];
	$kit2     = $_POST['kit2'];
	// $report1  = $_POST['report1'];
	// $report2  = $_POST['report2'];
	// $report3  = $_POST['report3'];
	$regidate = date('Ymd');
	if (isset($_SESSION['login_user'])) {
	    $register = $_SESSION['login_user'];
	} else {
	    $register = 'superadmin';
	}
	$userid   = $_POST['userid'];

	// $protocol = strip_tags($protocol);
	// $userid = strip_tags($userid);
	// $password = strip_tags($password); 

	if ($stmt->execute() === TRUE) {
	    echo '수정되었습니다';
	} else {
	    echo "Error: " . $connClis->error;
	}
	$stmt->close();
} else { //user
	$userid = $_SESSION['login_user'];
	$person   = $_POST['person'];
	$phone    = $_POST['phone'];
	$email    = $_POST['email'];
	$address  = $_POST['address'];
	$pickupLoc    = $_POST['pickupLoc'];
	$pickupTime  = $_POST['pickupTime'];

	$sql = "UPDATE csm01_users set user_name='$person',user_contact='$phone',user_email='$email',user_address='$address', desig_locaiton='$pickupLoc', desig_time='$pickupTime' where user_ID='$userid'";

	if ($connClis->query($sql) === TRUE) {
	    echo '수정되었습니다';
	} else {
	    echo "Error: " . $sql . "<br>" . $connClis->error;
	}
}

$connClis->close();

?>
