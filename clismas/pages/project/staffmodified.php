<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

include_once '../clisconnect.php';
/*if($_SESSION['manager'] == 't'){
	// prepare and bind
	$stmt = $connClis->prepare("UPDATE csm03_spl_pickup_request_staff set manager_name=?,mobile=?,role=? where user_ID=? AND user_PW!=''");
	$stmt->bind_param("ssss", $person, $phone, $staffrole, $staffid);

	$person = $_POST['person'];
	$phone  = $_POST['phone'];
	$staffrole   = $_POST['staffrole'];
	$staffid   = $_POST['staffid'];

	// $protocol = strip_tags($protocol);
	// $userid = strip_tags($userid);
	// $password = strip_tags($password); 

	if ($stmt->execute() === TRUE) {
	    echo '수정되었습니다';
	} else {
	    echo "Error: " . $connClis->error;
	}
	$stmt->close();
} else { //staff
*/	$staffid = $_SESSION['login_user'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$person = $_POST['person'];
	$phone  = $_POST['phone'];
	$staffrole   = $_POST['staffrole'];

	$sql = "UPDATE csm03_spl_pickup_request_staff set manager_name='$person',mobile='$phone',role='$staffrole' where user_ID='$staffid'";

	if ($connClis->query($sql) === TRUE) {
	    // echo '수정되었습니다';
	} else {
	    echo "Error: " . $sql . "<br>" . $connClis->error;
	}
	
	$sql = "UPDATE csm03_spl_pickup_request_staff set manager_name='$person',mobile='$phone',role='$staffrole' where user_ID='$staffid' and register is null";

	if ($connClis->query($sql) === TRUE) {
	    // echo '수정되었습니다';
	} else {
	    echo "Error: " . $sql . "<br>" . $connClis->error;
	}
/*}*/

$connClis->close();

?>
