<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$staffId = $_POST['staffid'];
$cancelSite = $_POST['cancelSite'];

foreach ($cancelSite as &$value) {
	$sql = "DELETE FROM csm03_spl_pickup_request_staff WHERE user_ID='$staffId' AND site_name='$value'";
	if ($connClis->query($sql) === TRUE) {
	    echo "Record deleted successfully";
	} else {
	    echo "Error deleting record: " . $conn->error;
	}
}	
echo "삭제되었습니다";

?>
