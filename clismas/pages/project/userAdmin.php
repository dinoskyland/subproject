<?php
// echo "<pre>";
// print_r($_REQUEST);
// echo "</pre>";
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$columns = array(
    // datatable column index  => database column name
    0 => 'protocol_cd',
    1 => 'site_name',
    2 => 'user_name',
    3 => 'user_ID',
    4 => 'user_email',
    5 => 'user_contact'
);

$requestData = $_REQUEST;
$protocol = $_SESSION['protocol'];
$site = $_SESSION['site'];

if (empty($_SESSION['site'])) {
    $sql = "SELECT * FROM csm01_users WHERE manager_checked='f'";    
} else {
    $sql = "SELECT * FROM csm01_users WHERE manager_checked='f' and protocol_cd='$protocol' and site_name='$site'";    
}

$result        = $connClis->query($sql);
$totaldata     = $result->num_rows;
$totalfiltered = $result->num_rows;

if (!empty($requestData['search']['value'])) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql .= " And (site_name LIKE '" . $requestData['search']['value'] . "%' ";
    $sql .= " OR user_name LIKE '" . $requestData['search']['value'] . "%')";
    //print_r($sql);
    $result        = $connClis->query($sql);
    $totalfiltered = $result->num_rows;
}
// when there is a search parameter then we have to modify total number filtered rows as per search result. 

$sql .= " ORDER BY {$columns[$requestData['order'][0]['column']]} {$requestData['order'][0]['dir']} LIMIT {$requestData['start']}, {$requestData['length']}";

$jason_data = array();

$result = $connClis->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        
        $jason_data[] = $row;
        
    }
} else {
    //echo "0 results";
}


$json = array(
    "draw" => intval($_REQUEST['draw']),
    "recordsTotal" => $totaldata,
    "recordsFiltered" => $totalfiltered,
    "data" => $jason_data
);
echo json_encode($json);
?>