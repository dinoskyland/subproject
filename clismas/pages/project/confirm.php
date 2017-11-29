<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';

if (isset($_POST['userid'])) {
    $userid = $_POST['userid'];
    
    //$sql = "SELECT pl_protocol_cd, pl_protocol_name FROM bim07_protocolbase WHERE pl_protocol_cd LIKE '%{$query}%' OR pl_protocol_name LIKE '%{$query}%'";
    $sql = "SELECT user_ID FROM csm01_users WHERE user_ID='$userid'";
    $result = $connClis->query($sql);
    
    $array = array();
    if ($result->num_rows > 0) {
        // id is already taken
        echo 1;
    } else {
        // good to use
        echo 0;
    }
    //RETURN JSON ARRAY
    $connClis->close();
}
?>