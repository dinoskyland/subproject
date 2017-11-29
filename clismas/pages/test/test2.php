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
    0 =>'order_no',
    1 => 'site_name',
    2 => 'request_date',
    3 => 'requester',
    4 => 'desired_date',
    5 => 'order_sum',
    6 => 'expired_date',
    7 => 'senddate',
    8 => 'received_date',
    9 => 'status'
);

    $site     = $_SESSION['site'];
    $protocol = $_SESSION['protocol'];

    $requestData= $_REQUEST;
    
    $sql = "SELECT * FROM csm04_KIT_order WHERE protocol_cd='$protocol' and site_name='$site'";
    // $sql = "SELECT order_no, site_name, request_date, requester, desired_date, order_sum, expired_date, senddate, received_date FROM csm04_KIT_order WHERE protocol_cd='$protocol' and site_name='$site'";

    $result = $connClis->query($sql);
    $totaldata = $result->num_rows;
    $totalfiltered = $result->num_rows;

	if( !empty($requestData['search']['value']) ) {   
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
		$sql.=" And (requester LIKE '".$requestData['search']['value']."%' ";    
		$sql.=" OR order_no LIKE '".$requestData['search']['value']."%')";
	    $result = $connClis->query($sql);
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
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => $totaldata,
                "recordsFiltered" => $totalfiltered,
                "data"            => $jason_data
            );
echo json_encode($json);
 ?>