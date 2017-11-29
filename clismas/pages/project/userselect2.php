<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

if($_SESSION['manager'] == 't'){
	$sql = "SELECT * FROM csm01_users where user_ID!='super' ORDER BY user_ID ASC";

	$result = $connClis->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
			// echo $row['user_ID'];
			echo "<option id='{$row['manager_checked']}'>{$row['user_ID']}</option>";						
		}		
	} else {
		echo "0 results";
	}
} else { //user
	echo "<option id='user' selected>{$_SESSION['login_user']}</option>";
}
//manager

//$connClis->close();

?>
