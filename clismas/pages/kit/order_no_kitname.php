<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$order_no = $_GET['order_no']; //from buttonset.php
//echo $order_no;
$sql = "SELECT * FROM csm04_KIT_order_detail where order_no='$order_no'";

$json=array();
$result = $connClis->query($sql);    
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $json[]=$row;
    }
} else {
	echo "0 results";
}    
echo json_encode($json);

?>
