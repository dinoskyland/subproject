<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
include_once '../clisconnect.php';

$protocolname='';
$site='';
$person='';
$phone='';
$email='';
$address='';
$lab1='';
$lab2='';
$pick1='';
$pick2='';
$kit1='';
$kit2='';
$report1='';
$report2='';
$report3='';

$staffperson='';
$staffphone='';
$staffrole='';


if (isset($_POST['search'])) { // modify user
	$userid = $_POST['userid'];
	$_SESSION['usermodify']=$userid;
		//echo $protocol;
	$sql = "SELECT * FROM csm01_users WHERE user_ID='$userid'";

	$result = $connClis->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
		//echo "<tr>";
			$protocolname=$row['protocol_name'];
			$site=$row['site_name'];
			$person=$row['user_name'];
			$phone=$row['user_contact'];
			$email=$row['user_email'];
			$address=$row['user_address'];
			$lab1=$row['check_lab1'];
			$lab2=$row['check_lab2'];
			$pick1=$row['check_pick1'];
			$pick2=$row['check_pick2'];
			$kit1=$row['check_kit1'];
			$kit2=$row['check_kit2'];
		}		
	} else {
		//echo "0 results";
	}
	siteOption();	
} else if (isset($_POST['staffsearch'])) { //modify staff
	$temp = explode('/', $_POST['staffuserid']);
	$staffperson = $temp[0];
	$staffphone = $temp[1];
	$staffrole = $temp[2];
	$staffId = $temp[3];
	$_SESSION['usermodify']=$staffId;

}

function siteOption(){
	include_once '../limsconnect.php';
	global $site;
	global $protocolname;
	$siteList="";

	$sql = "SELECT ps_site_cd, ps_site_name FROM bim07_protocol_site where protocol_name='$protocolname'";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
			// echo $row['pl_protocol_cd'];
			if ($row['ps_site_name'] == $site) {
				$siteList = $siteList . "<option selected='selected'>{$row['ps_site_name']}</option>";			
			} else {
				$siteList = $siteList . "<option>{$row['ps_site_name']}</option>";	
			}
		}
	} else {
		echo "0 results";
	}
	$site=$siteList;
}

?>