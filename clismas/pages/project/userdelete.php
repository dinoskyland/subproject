<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

include_once '../clisconnect.php';

$userid = $_POST['userid'];

$stmt = $connClis->prepare("DELETE from csm01_users where user_ID=?");
$stmt->bind_param("s", $userid);

if ($stmt->execute() === TRUE) {
	if ($_SESSION['login_user'] == $userid) { //if self-deleting
		session_destroy();
	}
    echo '삭제되었습니다';		
} else {
    echo "Error: " . $connClis->error;
}
$stmt->close();

?>
