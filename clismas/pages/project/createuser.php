<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
    session_start(); // Starting Session
} 

// prepare and bind
$stmt = $connClis->prepare("INSERT INTO csm01_users (manager_checked,protocol_cd,protocol_name,site_name,user_ID,user_PW,user_name,user_contact,user_email,user_address,desig_time,desig_locaiton,check_lab1,check_lab2,check_pick1,check_pick2,check_kit1,check_kit2,regidate,register) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssssssssssss", $manager, $protocol, $protocolname, $site, $userid, $password, $person, $phone, $email, $address, $pickupTime, $pickupLoc, $lab1, $lab2, $pick1, $pick2, $kit1, $kit2, $regidate, $register);

$manager = $_POST['manager'];
$protocol = $_POST['protocol'];
$protocolname = $_POST['protocolname'];
$site = $_POST['site'];
$userid = $_POST['userid'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$person = $_POST['person'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$pickupLoc = $_POST['pickupLoc'];
$pickupTime = $_POST['pickupTime'];
$lab1 = $_POST['lab1'];
$lab2 = $_POST['lab2'];
$pick1 = $_POST['pick1'];
$pick2 = $_POST['pick2'];
$kit1 = $_POST['kit1'];
$kit2 = $_POST['kit2'];
// $report1 = $_POST['report1'];
// $report2 = $_POST['report2'];
// $report3 = $_POST['report3'];
$regidate = date('Ymd');
if(isset($_SESSION['login_user'])){
	$register = $_SESSION['login_user'];
} else {
	$register = 'superadmin';
}

if ($stmt->execute() === TRUE) {
    echo '1';
} else {
    echo "Error: " . $connClis->error;
}
$stmt->close();
$connClis->close();

?>
