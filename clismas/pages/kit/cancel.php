<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';

$order_no = $_POST['order_no']; 

$sql = "UPDATE csm04_KIT_order set cancel_date='".date('Ymd')."', status='canceled' where order_no='$order_no'";

if ($connClis->query($sql) === TRUE) {
    //echo 1;
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}

/*$sql = "DELETE FROM csm04_KIT_order_detail where order_no='$order_no'";

if ($connClis->query($sql) === TRUE) {
    echo 1;
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}*/


?>
