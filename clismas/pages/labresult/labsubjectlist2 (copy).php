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
    1 => 'sbj_initial',
    2 => 'sbj_no',
    //3 => 'sbj_random_no',
    //4 => 'sbjf_sample_date1',
    5 => 'sbj_gender',
    6 => 'sbj_birthdate',
    //7 => 't_visit_cd',
    //8 => 't_visit_cd2'
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
$subjectCode        = $_POST['subjectCode'];
$protocol = $_SESSION['protocol'];
$site     = $_SESSION['site'];

$requestData = $_REQUEST;

if ($subjectNo) {
    $sql = "SELECT DISTINCT bim05_subjects.sbj_cd, bim05_subjects.sbj_no, bim05_subjects.sbj_initial, sbj_random_no, sbj_birthdate, sbj_gender, t_receipt_cd, t_visit_cd, t_visit_name, t_sbj_cd  
        FROM bim05_subjects 
        INNER JOIN lrm02_test_result 
        ON bim05_subjects.sbj_cd=t_sbj_cd 
        where bim05_subjects.sbj_no='$subjectNo' AND ptl_cd='$protocol' AND sbj_site='$site' AND $periodFrom <= SUBSTR(t_receipt_cd,1,6) AND SUBSTR(t_receipt_cd,1,6) <= $periodTo";
} else if ($subjectInitial) {
    $sql = "SELECT DISTINCT bim05_subjects.sbj_cd, bim05_subjects.sbj_no, bim05_subjects.sbj_initial, sbj_random_no, sbj_birthdate, sbj_gender, t_receipt_cd, t_visit_cd, t_visit_name, t_sbj_cd
        FROM bim05_subjects 
        INNER JOIN lrm02_test_result 
        ON bim05_subjects.sbj_cd=t_sbj_cd 
        where bim05_subjects.sbj_initial='$subjectInitial' AND ptl_cd='$protocol' AND sbj_site='$site' AND $periodFrom <= SUBSTR(t_receipt_cd,1,6) AND SUBSTR(t_receipt_cd,1,6) <= $periodTo";
} else { //all subjects
    $sql = "SELECT DISTINCT bim05_subjects.sbj_cd, bim05_subjects.sbj_no, bim05_subjects.sbj_initial, sbj_random_no, sbj_birthdate, sbj_gender, t_receipt_cd, t_visit_cd, t_visit_name, t_sbj_cd 
        FROM bim05_subjects 
        INNER JOIN lrm02_test_result 
        ON bim05_subjects.sbj_cd=t_sbj_cd 
        where ptl_cd='$protocol' AND sbj_site='$site' AND $periodFrom <= SUBSTR(t_receipt_cd,1,6) AND SUBSTR(t_receipt_cd,1,6) <= $periodTo";
}

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

$sql .= " ORDER BY sbj_cd ASC, t_visit_cd DESC, {$columns[$requestData['order'][0]['column']]} {$requestData['order'][0]['dir']} LIMIT {$requestData['start']}, {$requestData['length']}";

$jason_data = array();
$i = 0;
$sbj_cd = null;
$t_visit_cd = null;
$counter = 0;

$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($sbj_cd != $row['sbj_cd']){
            $jason_data[$i] = $row;
            if ($i > 0 && $counter == 0){
                $i--;
                $jason_data[$i++]['prev'] = "";
            } else { $counter = 0; }

            $sbj_cd = $row['sbj_cd'];
            $t_visit_cd = $row['t_visit_cd'];            

            $sql = "SELECT sbjf_sample_date1  
                FROM rim01_receipt_base  
                where sbj_cd='$sbj_cd' AND rb_visit_cd='$t_visit_cd' LIMIT 1";
            $resultSampleDate = $conn->query($sql);
            if ($resultSampleDate->num_rows > 0) {
                $rowSampleDate = $resultSampleDate->fetch_assoc();
                $rowSampleDate = $rowSampleDate['sbjf_sample_date1'];
            } else {            
                $rowSampleDate = "";
            }

            $jason_data[$i++]['sbjf_sample_date1'] = $rowSampleDate;

        } else if ($t_visit_cd != $row['t_visit_cd']){
            if ($counter == 0) {
                $counter++;
                $i--;
                $jason_data[$i++]['prev'] = $row['t_visit_name'];
            }
        }             
   }
} else {
    //echo "0 results";
}

if ($i > 0 && $counter == 0){
    $i--;
    $jason_data[$i++]['prev'] = "";
}


$json = array(
    "draw" => intval($_REQUEST['draw']),
    "recordsTotal" => $totaldata,
    "recordsFiltered" => $totalfiltered,
    "data" => $jason_data
);
echo json_encode($json);
?>