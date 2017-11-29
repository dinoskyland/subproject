<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../limsconnect.php';

$subjectCode = $_POST['subjectCode'];
$visitName   = $_POST['visitName'];
$subjectSex  = $_POST['subjectSex'];

//bottom
$sql = "SELECT DISTINCT lrm02_test_result.t_test_name as t_test_name, lrm02_test_result.t_final_rep_status as t_final_rep_status, lrm02_test_result.t_numeric_result1 as t_numeric_result1, lrm02_test_result.t_text_result as t_text_result, lrm02_test_result.t_test_result_type as t_test_result_type, lrm02_test_result.t_RT_status as t_RT_status, lrm02_test_result.t_CV_status as t_CV_status, lrm02_test_result.t_CRR_status as t_CRR_status, lrm02_test_result.t_HL_status as t_HL_status, lrm02_test_result.t_test_cd as t_test_cd, lrm02_test_result.t_b_web as t_b_web 
    FROM lrm02_test_result 
    INNER JOIN bim07_protocol_test 
    ON lrm02_test_result.t_test_cd = bim07_protocol_test.pt_test_cd 
    where lrm02_test_result.t_sbj_cd='$subjectCode' and lrm02_test_result.t_visit_name='$visitName' ORDER BY bim07_protocol_test.pt_seq_no ASC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        print_r($row["t_test_name"]);
        $t_test_name        = $row["t_test_name"];
        $t_final_rep_status = $row["t_final_rep_status"];
        $t_test_result_type = $row["t_test_result_type"];
        $t_numeric_result1  = $row["t_numeric_result1"];
        $t_text_result      = $row["t_text_result"];
        $t_RT_status        = $row["t_RT_status"];
        $t_CV_status        = $row["t_CV_status"];
        $t_CRR_status       = $row["t_CRR_status"];
        $t_HL_status       = $row["t_HL_status"];
        $t_b_web          = $row["t_b_web"];
        $t_test_cd          = $row["t_test_cd"];
        
        if ($t_final_rep_status == '최종확인' && $t_b_web == 'N') {
            echo "<tr>";
            echo "<td>" . $t_test_name . "</td>";
            echo "<td>$t_HL_status</td>";
            if ($t_test_result_type == '수치') {
                echo "<td>$t_numeric_result1</td>";
                $sql        = "SELECT tn_min_value, tn_max_value, tn_base_unit FROM bim06_02_test_normalvalue_m where testbase_cd='$t_test_cd' and tn_sex='$subjectSex'";
                $resultSub1 = $conn->query($sql);
                if ($resultSub1->num_rows > 0) {
                    // output data of each row
                    $row = $resultSub1->fetch_assoc();
                    $tn_min_value = $row["tn_min_value"];
                    $tn_max_value = $row["tn_max_value"];
                    $tn_base_unit = $row["tn_base_unit"];
                    echo "<td>$tn_min_value-$tn_max_value $tn_base_unit</td>";    
                } else {
                    echo "<td>0 result</td>";
                }
            } else if ($t_test_result_type == '문자') {
                echo "<td>$t_text_result</td>";
                $sql        = "SELECT tnd_value_detail FROM bim06_02_test_normalvalue_d where testbase_cd='$t_test_cd' and tnd_sex='$subjectSex' ORDER BY tnd_d_no ASC";
                $resultSub1 = $conn->query($sql);
                if ($resultSub1->num_rows > 0) {
                    // output data of each row
                    echo '<td>';
                    while ($row = $resultSub1->fetch_assoc()) {
                        $tnd_value_detail = $row["tnd_value_detail"];
                        echo "$tnd_value_detail" . '<br>';
                    }
                    echo '</td>';
                } else {
                    echo "<td>0 result</td>";
                }
            } else { //문자+숫자 
                echo "<td>" . $t_numeric_result1 . ' / ' . $t_text_result . "</td>";
                $sql        = "SELECT tn_min_value, tn_max_value, tn_base_unit FROM bim06_02_test_normalvalue_m where testbase_cd='$t_test_cd' and tn_sex='$subjectSex'";
                $resultSub1 = $conn->query($sql);
                if ($resultSub1->num_rows > 0) {
                    // output data of each row
                    $row = $resultSub1->fetch_assoc();
                    $tn_min_value = $row["tn_min_value"];
                    $tn_max_value = $row["tn_max_value"];
                    $tn_base_unit = $row["tn_base_unit"];
                    echo "<td>$tn_min_value-$tn_max_value $tn_base_unit";    
                } else {
                    echo "<td>0 result";
                }
                $sql        = "SELECT tnd_value_detail FROM bim06_02_test_normalvalue_d where testbase_cd='$t_test_cd' and tnd_sex='$subjectSex' ORDER BY tnd_d_no ASC";
                $resultSub1 = $conn->query($sql);
                if ($resultSub1->num_rows > 0) {
                    // output data of each row
                    while ($row = $resultSub1->fetch_assoc()) {
                        echo "<br>" . $row["tnd_value_detail"];
                    }
                    echo '</td>';
                } else {
                    echo "<br>0 result</td>";
                }
            }
            echo "</tr>";
        }
    }
} else {
    echo "<tr><td>lrm02_test_result: 0 results</td></tr>";
}


?>
