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

$dong=false;
$jang=false;
$shil=false;
$options='';
$protocol=$_SESSION['protocol'];
$visitName=$_SESSION['visitName'];    

$sql = "SELECT ps_spl_condition FROM bim07_protocol_samples where protocol_cd='$protocol' AND ps_visit_name='$visitName' ORDER BY ps_spl_condition ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
    	$condition = $row['ps_spl_condition'];
    	if ($condition == '냉동') {
	        $dong = true;
    	}
		if ($condition == '냉장') {
	        $jang = true;
    	}
    	if ($condition == '실온') {
	        $shil = true;
    	}
    }
} else {
    echo "0 results";
}
$dong == true ? $options = "<td class='dong'>Y</td>": $options = "<td class='dong'></td>";
$jang == true ? $options .= "<td class='jang'>Y</td>": $options .= "<td class='jang'></td>";
$shil == true ? $options .= "<td class='shil'>Y</td>": $options .= "<td class='shil'></td>";    	

echo $options;
?>
