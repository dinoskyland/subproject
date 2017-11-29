<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$order_no = $_POST['order_no']; 
$id = $_POST['id'];
$quantity = $_POST['quantity']; 

$sql = "UPDATE csm04_KIT_order_detail set send_qty='$quantity', send_date='".date('Ymd')."' where order_no='$order_no' and id='$id'";

if ($connClis->query($sql) === TRUE) {
    echo 1;
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}


?>
