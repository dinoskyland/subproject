<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';

$order_no=substr(date("Ymd"),2);

$sql = "SELECT order_no FROM csm04_KIT_order where order_no like '$order_no%' ORDER BY order_no DESC LIMIT 1";
$result = $connClis->query($sql);
//number of rows
//$numResults = $result->num_rows;

if ($result->num_rows == 0) {
	$order_no = $order_no . '001';
} else {
	while($row = $result->fetch_assoc()) {
		// last row
		$counter = substr($row['order_no'], 6);
		$counter++;
		if ($counter > 99) {
			$order_no = $order_no . $counter;
		} else if ($counter > 9) {
			$order_no = $order_no . '0' . $counter;
		} else {
			$order_no = $order_no . '00' . $counter;
		//echo $order_no;
		}
		
	}		

}

echo $order_no;
?>
