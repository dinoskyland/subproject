<?php			
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');
if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$_SESSION['site'] = $_POST['site']; // from protocolsearch2.php when registering.
echo $_SESSION['site'];
?>
