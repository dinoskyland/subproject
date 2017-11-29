<?php
//display error 

if ($_SERVER['SERVER_NAME'] == "localhost") {
    $servername = "112.148.73.107";
} else {
    $servername = "localhost";
}
/*$username = "lims";
$password = "lims0001";
$dbname   = "lims";
$conn = new mysqli($servername, $username, $password, $dbname);
*/
// Create connection
$connClis = new mysqli($servername, 'clismas', 'clis0001', 'clismas');

// Check connection
if ($connClis->connect_error) {
    die("Connection failed: " . $connClis->connect_error);
}
?>