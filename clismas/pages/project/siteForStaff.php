<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$id = $_SESSION['login_user']; 

$sql = "SELECT site_name FROM csm03_spl_pickup_request_staff where user_ID='$id' and register IS NULL";

$result = $connClis->query($sql);

if ($result->num_rows > 0) {
// output data of each row
	while($row = $result->fetch_assoc()) {
		// echo $row['pl_protocol_cd'];
		echo $row['site_name'] . '<br />';	
	}
} else {
	echo "0 result";		
}


?>
