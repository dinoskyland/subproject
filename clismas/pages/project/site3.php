<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../limsconnect.php';
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$prevProtocol = $_POST['prevProtocol']; 
$prevSite = $_POST['prevSite']; 

$sql = "SELECT ps_site_cd, ps_site_name FROM bim07_protocol_site where protocol_cd='$prevProtocol'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
        if ($prevSite == $row['ps_site_name']) {
			echo "<option selected>{$row['ps_site_name']}</option>";	
		} else {
			echo "<option>{$row['ps_site_name']}</option>";	
		}
	}
} else {
	echo "<option>{$_SESSION['site']}</option>";
}


?>
