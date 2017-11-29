<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

if($_SESSION['manager'] == 't'){
	$sql = "SELECT DISTINCT manager_name, mobile, user_ID, role FROM csm03_spl_pickup_request_staff where user_PW!='' ORDER BY user_ID ASC";

	$result = $connClis->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
			// echo $row['pl_protocol_cd'];
			echo "<option>{$row['user_ID']}</option>";		
		}
	} else {
		echo "0 results";
	}
} else { //staff
	echo "<option id='staff' selected>{$_SESSION['login_user']}</option>";
}


?>
