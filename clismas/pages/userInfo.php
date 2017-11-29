<?php
	if(!isset($_SESSION)) 
	{ 
		session_start(); // Starting Session
	} 


	if($_SESSION['manager'] == 't'){
		$user='Manager '.$_SESSION['person']."님";
		$level='Manager';
		$_SESSION['site'] = null;
		$_SESSION['protocol'] = null;
		$_SESSION['protocolname'] = null;
	} else if($_SESSION['staff'] == 't'){
		$user='Pickup Staff '.$_SESSION['person']."님";
		$level='Pickup Staff';
	} else {
		$user=$_SESSION['protocolname'].", ".$_SESSION['site'].", ".$_SESSION['person']."님";
		$level='User';	
	}
?>  