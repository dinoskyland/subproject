<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';

if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$columns = array(
    // datatable column index  => database column name
    0 => 'id',
    1 => 'protocol_cd',
    2 => 'kit_name',
    3 => 'regidate',
    4 => 'register'
);

$protocol = $_SESSION['protocol'];
$requestData = $_REQUEST;

//select kit
$sql = "SELECT * FROM csm04_protocol_KIT where protocol_cd='$protocol'";
$result = $connClis->query($sql);

$result        = $connClis->query($sql);
$totaldata     = $result->num_rows;
$totalfiltered = $result->num_rows;

if (!empty($requestData['search']['value'])) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql .= " And (kit_name LIKE '" . $requestData['search']['value'] . "%' ";
    $sql .= " OR register LIKE '" . $requestData['search']['value'] . "%')";
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
