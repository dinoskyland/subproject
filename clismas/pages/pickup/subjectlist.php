<?php
//get subject info from bim05_subjects table with protocol and site
//which is used in modal

//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../limsconnect.php';

$options='';
$protocol=$_SESSION['protocol'];
$site=$_SESSION['site'];

$sql = "SELECT sbj_cd,sbj_no FROM bim05_subjects where ptl_cd='$protocol' and sbj_site='$site' ORDER BY sbj_no ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $options .= "<option id='{$row['sbj_cd']}'>{$row['sbj_no']}</option>";
    }
} else {
    echo "0 results";
}

echo $options;
?>
