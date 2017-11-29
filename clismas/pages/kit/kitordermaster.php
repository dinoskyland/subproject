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
$protocol = $_POST['protocol'];
$protocolname = $_POST['protocolname'];
$site = $_POST['site'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$requester = $_POST['requester'];
$desired_date = $_POST['datepicker'];
$ordersummary = $_POST['ordersummary'];
$register = $_SESSION['login_user'];
$request_date = date("Ymd");
$regidate = date("Ymd");;


//insert kit
$sql = "INSERT INTO csm04_KIT_order (order_no,protocol_cd,protocol_name,site_name,shipping_addr,contact_no,requester,desired_date,order_sum,status,request_date,regidate,register) VALUES ('$order_no','$protocol','$protocolname','$site','$address','$phone','$requester','$desired_date','$ordersummary','requested','$request_date','$regidate','$register')";

if ($connClis->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $connClis->error;
}




?>
