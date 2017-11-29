<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

$order_no = $_POST['order_no'];
$id = $_POST['id'];
$kitname = $_POST['kitname'];
$quantity = $_POST['quantity'];
$requester = $_POST['requester'];
$request_date = date("Ymd");
$regidate = date("Ymd");;
$register = $_SESSION['login_user'];

//insert kit
$sql = "INSERT INTO csm04_KIT_order_detail (order_no,id,kit_name,reqest_qty,requester,request_date,regidate,register) VALUES ('$order_no','$id','$kitname','$quantity','$requester','$request_date','$regidate','$register')";

if ($connClis->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}

?>
