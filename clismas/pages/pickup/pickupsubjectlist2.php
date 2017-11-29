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
    0 => 'pick_req_cd',
    1 => 'protocol_name',
    2 => 'site_name',
    3 => 'requester',
    4 => 'sbj_no',
    5 => 'visit_name',
    7 => 'pickup_date',
    8 => 'status'
);

$site     = $_SESSION['site'];
$protocolname = $_SESSION['protocolname'];
$staffName = $_SESSION['person'];
$login_user = $_SESSION['login_user'];

$requestData = $_REQUEST;

if ($_SESSION['staff'] == 't') {
    $sql = "SELECT request.pick_req_cd as pick_req_cd, request.protocol_name as protocol_name, request.site_name as site_name,request.requester as requester,request.pickup_date as pickup_date,detail.id as id,detail.sbj_no as sbj_no,detail.visit_name as visit_name,detail.spl_freezed_cnt as spl_freezed_cnt,detail.spl_cold_cnt as spl_cold_cnt,detail.spl_room_temp_cnt as spl_room_temp_cnt,detail.spl_freezed_picked as spl_freezed_picked,detail.spl_cold_picked as spl_cold_picked,detail.spl_room_temp_picked as spl_room_temp_picked,detail.status as status, detail.regidate as regidate, detail.change_datetime as change_datetime,detail.changer as changer 
        FROM csm03_spl_pickup_request request INNER JOIN csm03_pickup_request_detail detail 
        ON detail.pick_req_cd=request.pick_req_cd 
        where request.m_manager_name='$staffName' OR request.s_manager_name='$staffName'";

} else if ($protocolname == null) {
    $sql = "SELECT request.pick_req_cd as pick_req_cd, request.protocol_name as protocol_name, request.site_name as site_name,request.requester as requester,request.pickup_date as pickup_date, detail.id as id,detail.sbj_no as sbj_no,detail.visit_name as visit_name,detail.spl_freezed_cnt as spl_freezed_cnt,detail.spl_cold_cnt as spl_cold_cnt,detail.spl_room_temp_cnt as spl_room_temp_cnt,detail.spl_freezed_picked as spl_freezed_picked,detail.spl_cold_picked as spl_cold_picked,detail.spl_room_temp_picked as spl_room_temp_picked,detail.status as status, detail.regidate as regidate, detail.change_datetime as change_datetime,detail.changer as changer 
        FROM csm03_spl_pickup_request request INNER JOIN csm03_pickup_request_detail detail 
        ON detail.pick_req_cd=request.pick_req_cd";
} else {
    $sql = "SELECT request.pick_req_cd as pick_req_cd, request.protocol_name as protocol_name, request.site_name as site_name,request.requester as requester,request.pickup_date as pickup_date,detail.id as id,detail.sbj_no as sbj_no,detail.visit_name as visit_name,detail.spl_freezed_cnt as spl_freezed_cnt,detail.spl_cold_cnt as spl_cold_cnt,detail.spl_room_temp_cnt as spl_room_temp_cnt,detail.spl_freezed_picked as spl_freezed_picked,detail.spl_cold_picked as spl_cold_picked,detail.spl_room_temp_picked as spl_room_temp_picked,detail.status as status, detail.regidate as regidate, detail.change_datetime as change_datetime,detail.changer as changer 
        FROM csm03_spl_pickup_request request INNER JOIN csm03_pickup_request_detail detail 
        ON detail.pick_req_cd=request.pick_req_cd 
        where request.protocol_name='$protocolname' and request.site_name='$site'";    
}

$result        = $connClis->query($sql);
$totaldata     = $result->num_rows;
$totalfiltered = $result->num_rows;

if (!empty($requestData['search']['value'])) {
    // if there is a search parameter, $requestData['search']['value'] contains search parameter
    $sql .= " And (status LIKE '" . $requestData['search']['value'] . "%' ";
    $sql .= " OR pickup_date LIKE '" . $requestData['search']['value'] . "%')";
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