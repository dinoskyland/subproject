<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$userid = $_POST['userid'];
$site = $_POST['site'];
$person = $_POST['person'];
$phone = $_POST['phone'];
$staffrole = $_POST['staffrole'];

$sql = "DELETE FROM csm03_spl_pickup_request_staff WHERE user_ID='$userid' 
		AND register IS NULL";
if ($connClis->query($sql) === TRUE) {
    //echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

foreach ($site as &$value) {
    //echo $value;
	$stmt = $connClis->prepare("INSERT INTO csm03_spl_pickup_request_staff (user_ID,site_name,role,mobile,manager_name) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param("sssss", $userid, $value, $staffrole, $phone, $person);

	if ($stmt->execute() === TRUE) {
		$added = true;
	} else {
	    echo "Error: " . $connClis->error;
	}
	$stmt->close();
}

/*for ($i = 1; $i <= 13; $i++){
	if ($hospitalAllocated !='') {
	}	
}
*/
echo "할당되었습니다";

?>
