<?php 
	//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once '../clisconnect.php';

$deletable = true;
$id = $_POST['id'];
$sql = "SELECT order_no FROM csm04_KIT_order_detail where id='$id'";
$result = $connClis->query($sql);


if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$order_no = $row["order_no"];
		$sql = "SELECT status, order_no FROM csm04_KIT_order where order_no='$order_no'";
		$result2 = $connClis->query($sql);

		if ($result2->num_rows > 0) {
			while($row = $result2->fetch_assoc()) {	
		
				if ($row["status"] == 'requested' || $row["status"] == 'shipped') {
				//if ($row["status"] != null) {
					// if status is set
					// you can't delete this kit...
					$deletable = false;
				} else {
					// received or canceled
				}
		
			}
		} else {
			//0 result
		}
	
	}
} else { // kits from order_detail == 0
	//0 result
}

if ($deletable) {
	// if status is not set
	//delete kit
	$sql = "DELETE FROM csm04_protocol_KIT WHERE id='$id'";
	if ($connClis->query($sql) === TRUE) {
	    echo 1;
	} else {
	    echo "Error: " . $sql . "<br>" . $connClis->error;
	}
	
} else {
	echo 2;
}

?>
