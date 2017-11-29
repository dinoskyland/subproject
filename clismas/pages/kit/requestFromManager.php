<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$protocol = $_SESSION['protocol']; 
$site = $_SESSION['site']; // from protocolsearch2.php when registering.
//$manager = $_SESSION['login_user'];
$manager = $_SESSION['person'];
$json = array();

$sql = "SELECT user_name person, user_contact phone, user_address address FROM csm01_users where protocol_cd='$protocol' AND site_name='$site'";

$result = $connClis->query($sql);

if ($result->num_rows > 0) {
// output data of each row
    while($row = $result->fetch_assoc()) {
        // echo $row['pl_protocol_cd'];
        $json[] = $row; 
    }
} else {
    $json[] = ['person' => '', 'phone' => '', 'address' => '']; 

}

$json[] = ['manager' => $manager];

echo json_encode($json);
?>
