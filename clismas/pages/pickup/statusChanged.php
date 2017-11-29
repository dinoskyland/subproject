<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$id = $_POST['id']; 
$statusOriginal = $_POST['statusOriginal']; 
// $pickupDong = $_POST['pickupDong']; 
// $pickupNang = $_POST['pickupNang'];
// $pickupShil = $_POST['pickupShil']; 
$regidate = date("Y-m-d h:ia");
//$register = $_SESSION['login_user'];
$register = $_SESSION['person'];

switch ($_SESSION['staff']) {
    case "t": //pickup staff
		echo 'I am staff ';
		switch ($statusOriginal) {
		    case "requested":
				$sql = "UPDATE csm03_pickup_request_detail set status='complete', change_datetime='$regidate', changer='$register' where id='$id'";
		        break;
		    case "complete":
				$sql = "UPDATE csm03_pickup_request_detail set status='canceled', change_datetime='$regidate', changer='$register' where id='$id'";
		        break;
		    case "canceled":
				$sql = "UPDATE csm03_pickup_request_detail set status='requested', change_datetime='$regidate', changer='$register' where id='$id'";
		        break;
       	}
		break;
    case "f": //user or manager
		echo 'I am user or manager ';
		switch ($statusOriginal) {
		    case "requested":
				$sql = "UPDATE csm03_pickup_request_detail set status='canceled', change_datetime='$regidate', changer='$register' where id='$id'";
		        break;
		    case "canceled":
				$sql = "UPDATE csm03_pickup_request_detail set status='requested', change_datetime='$regidate', changer='$register' where id='$id'";
		        break;
        }
    	break;
}

if ($connClis->query($sql) === TRUE) {
    echo $sql;
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}


?>
