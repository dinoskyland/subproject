<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
    session_start(); // Starting Session
} 

// prepare and bind

$stmt = $connClis->prepare("INSERT INTO csm01_users (manager_checked,user_ID,user_PW,user_name,user_contact,regidate,register) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $manager, $userid, $password, $person, $phone, $regidate, $register);

$manager = $_POST['manager'];
$userid = $_POST['userid'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$person = $_POST['person'];
$phone = $_POST['phone'];
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
