<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$order_no = $_POST['order_no']; 
$order_sum = $_POST['order_sum']; 
$expiration = $_POST['expiration']; 

$sql = "UPDATE csm04_KIT_order set order_sum='$order_sum', expired_date='$expiration', senddate='".date('Ymd')."', status='shipped' where order_no='$order_no'";

if ($connClis->query($sql) === TRUE) {
    echo 1;
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}


?>
