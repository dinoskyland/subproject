<?php
//display error 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 'On');

include_once '../clisconnect.php';

if(!isset($_SESSION)) { 
	session_start(); // Starting Session
} 

$error=''; // display error message on login page

		// Define $username and $password
		$username='a';
		$password='a';
		
        $sql = "SELECT protocol_cd, user_ID, user_PW, site_name, manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE user_ID='$username'";

		$result = $connClis->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$hash = $row['user_PW'];
				if (password_verify($password, $hash)) {
                         $_SESSION['manager']      = 'f';
                         $_SESSION['protocol']     = '';
                         $_SESSION['protocolname'] = '';
                         $_SESSION['site']         = '';
                         $_SESSION['login_user']   = $row["user_ID"];
                         $_SESSION['person']       = $row["manager_name"];
                         $_SESSION['phone']        = $row["mobile"];
                         $_SESSION['address']      = '';
                         $_SESSION['role']         = $row["role"];
                         $_SESSION['pick1']        = 't';
                         $_SESSION['staff']        = 't';
                         if (!isset($_SESSION['page'])) {
                             $_SESSION['page'] = "pickup/pickuprequest.php";
                         }
				} else {
				    $error = 'Invalid Password';
				}

			}
		} else {
			$error = "Invaild Username";
		}



?>