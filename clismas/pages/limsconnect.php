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
$conn = new mysqli($servername, 'lims', 'lims0001', 'lims');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>