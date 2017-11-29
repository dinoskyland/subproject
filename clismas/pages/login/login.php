<?php
include_once __DIR__ . '/../clisconnect.php';

if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$error = ''; // display error message on login page

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is empty";
    } else if (empty($_POST["staff"])) {
        // Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM csm01_users WHERE user_ID='$username'";
        
        $result = $connClis->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $hash = $row['user_PW'];
                if (password_verify($password, $hash)) {
                    $_SESSION['manager']      = $row["manager_checked"];
                    $_SESSION['protocol']     = $row["protocol_cd"];
                    $_SESSION['protocolname'] = $row["protocol_name"];
                    $_SESSION['site']         = $row["site_name"];
                    $_SESSION['login_user']   = $row["user_ID"];
                    $_SESSION['person']       = $row["user_name"];
                    $_SESSION['phone']        = $row["user_contact"];
                    $_SESSION['address']      = $row["user_address"];
                    $_SESSION['pickupLoc']      = $row["desig_locaiton"];
                    $_SESSION['pickupTime']      = $row["desig_time"];
                    $_SESSION['role']         = '';
                    $_SESSION['lab1']         = $row["check_lab1"];
                    $_SESSION['lab2']         = $row["check_lab2"];
                    $_SESSION['pick1']        = $row["check_pick1"];
                    $_SESSION['pick2']        = $row["check_pick2"];
                    $_SESSION['kit1']         = $row["check_kit1"];
                    $_SESSION['kit2']         = $row["check_kit2"];
                    $_SESSION['report1']      = $row["check_report1"];
                    $_SESSION['report2']      = $row["check_report2"];
                    $_SESSION['report3']      = $row["check_report3"];
                    $_SESSION['staff']        = 'f';
                    
                    if ($_SESSION['manager'] == 't') { //manager
                        $_SESSION['page'] = "project/kitsetup.php";
                    } else { //user
                        if ($_SESSION['lab1'] == 't') {
                            $_SESSION['page'] = "labresult/labresult.php";
                        } else if ($_SESSION['pick1'] == 't') {
                            $_SESSION['page'] = "pickup/pickuprequest.php";
                        } else {
                            $_SESSION['page'] = "kit/kitorder.php";
                        }                         
                    }
                } else {
                    $error = 'Invalid Password';
                }
                
                if (!empty($_POST["remember"])) {
                    setcookie("username", $username, time() + (365 * 24 * 60 * 60));
                    setcookie("password", $password, time() + (365 * 24 * 60 * 60));
                } else {
                    if (isset($_COOKIE["username"])) {
                        setcookie("username", "");
                    }
                    if (isset($_COOKIE["password"])) {
                        setcookie("password", "");
                    }
                }
                //getPickupStaff();
            }
        } else {
            $error = "Invaild Username";
        }
    } else { //staff
        // Define $username and $password
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $sql = "SELECT protocol_cd, user_ID, user_PW, site_name, manager_name, mobile, role FROM csm03_spl_pickup_request_staff WHERE user_ID='$username'";
        
        $result = $connClis->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
        
    }
}

?>