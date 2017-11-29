<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../limsconnect.php';

if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$columns = array(
    // datatable column index  => database column name
    0 => 't_receipt_cd',
    3 => 'sbj_initial',
    4 => 'sbj_no',
);

$buttonTestResult = $_POST['buttonTestResult'];
if ($buttonTestResult == 'false') { //'test result' button not pressed
//echo "buttonTestResult2".$buttonTestResult;
    $json = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => 0,
        "recordsFiltered" => 0,
        "data" => array()
    );
    echo json_encode($json);
    exit();
}

$periodFrom       = $_POST['periodFrom'];
$periodTo         = $_POST['periodTo'];
$periodCondition  = $_POST['periodCondition'];
$protocol = $_SESSION['protocol'];
$site     = $_SESSION['site'];

$requestData = $_REQUEST;

$sql = "SELECT bim05_subjects.sbj_cd, bim05_subjects.sbj_no, bim05_subjects.sbj_initial, t_receipt_cd, t_visit_cd, t_visit_name 
        FROM bim05_subjects 
        INNER JOIN lrm02_test_result 
        ON bim05_subjects.sbj_cd=t_sbj_cd 
        INNER JOIN rim01_receipt_base 
        ON bim05_subjects.sbj_cd=rim01_receipt_base.sbj_cd
        where ptl_cd='$protocol' AND sbj_site='$site' AND $periodFrom <= SUBSTR(t_receipt_cd,1,6) AND SUBSTR(t_receipt_cd,1,6) <= $periodTo";

$result        = $conn->query($sql);
$totaldata     = $result->num_rows;
$totalfiltered = $result->num_rows;

if (!empty($requestData['search']['value'])) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql .= " And (bim05_subjects.sbj_cd LIKE '" . $requestData['search']['value'] . "%' ";
    $sql .= " OR bim05_subjects.sbj_no LIKE '" . $requestData['search']['value'] . "%')";
    $result        = $conn->query($sql);
    $totalfiltered = $result->num_rows;
}
// when there is a search parameter then we have to modify total number filtered rows as per search result. 
$sql .= " GROUP BY sbj_cd";    

$sql .= " ORDER BY {$columns[$requestData['order'][0]['column']]} {$requestData['order'][0]['dir']} LIMIT {$requestData['start']}, {$requestData['length']}";

$jason_data = array();

$result = $conn->query($sql);
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