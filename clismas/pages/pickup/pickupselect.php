<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once 'limsconnect.php';
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
$protocol = $_SESSION['protocol']; // from protocolsearch2.php when registering.
$site=$_SESSION['site'];

//manager
if ($_SESSION['manager'] == 't') {
	$sql = "SELECT pl_protocol_cd FROM bim07_protocolbase";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
			// echo $row['pl_protocol_cd'];
			if ($row['pl_protocol_cd'] == $protocol) {
				echo "<option selected='selected'>{$row['pl_protocol_cd']}</option>";	
			} else {
				echo "<option>{$row['pl_protocol_cd']}</option>";						
			}
		}		
	} else {
		echo "0 results";
	}
} else { //user
	echo "<option selected='selected'>$protocol</option>";	
	$site=$_SESSION['site'];
	$person=$_SESSION['person'];
	$address=$_SESSION['address'];
	$phone=$_SESSION['phone'];
	$requester=$_SESSION['person'];
}



$conn->close();

?>
