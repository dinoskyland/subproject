<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
    session_start(); // Starting Session
} 

// prepare and bind

$stmt = $connClis->prepare("INSERT INTO csm03_spl_pickup_request_staff (user_ID,user_PW,manager_name,mobile,role,regidate,register) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $userid, $password, $person, $phone, $role, $regidate, $register);

$userid = $_POST['userid'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$person = $_POST['person'];
$phone = $_POST['phone'];
$role = $_POST['role'];
$regidate = date('Ymd');
$register = $_SESSION['login_user'];

// $protocol = strip_tags($protocol);
// $userid = strip_tags($userid);
// $password = strip_tags($password); 

if ($stmt->execute() === TRUE) {
    echo '1';
} else {
    echo "Error: " . $connClis->error;
}
$stmt->close();
$connClis->close();

?>
