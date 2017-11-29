<?php
//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../limsconnect.php';
if (!isset($_SESSION)) {
    session_start(); // Starting Session
}

$protocol    = $_SESSION['protocol'];
$subjectCode = $_POST['subjectCode'];

$sbj_no            = null;
$sbj_siteno        = null;
$sbj_site          = null;
$sbj_PI            = null;
$sbj_birthdate     = null;
$sbj_gender        = null;
$sbj_initial       = null;
$sbj_allocation_no = null;
$sbj_random_no     = null;
$sbj_screening_no  = null;
$sbjf_sample_date1 = null;
$sbjf_sample_time1 = null;
$sbjf_weight       = null;
$sbjf_age          = null;
$sbjf_fasting      = null;
$sbjf_visit        = null;

function matching($d)
{
    global $sbj_no;
    global $sbj_siteno;
    global $sbj_site;
    global $sbj_PI;
    global $sbj_birthdate;
    global $sbj_gender;
    global $sbj_initial;
    global $sbj_allocation_no;
    global $sbj_random_no;
    global $sbj_screening_no;
    global $sbjf_sample_date1;
    global $sbjf_sample_time1;
    global $sbjf_weight;
    global $sbjf_age;
    global $sbjf_fasting;
    global $sbjf_visit;

    $val = null;

    switch ($d) {
        case "Subject No.":
            $val =  $sbj_no;
            break;
        case "Site No.":
            $val =  $sbj_siteno;
            break;
        case "Site Name":
            $val =  $sbj_site;
            break;
        case "PI Name":
            $val =  $sbj_PI;
            break;
        case "Date of Birth":
            $val =  $sbj_birthdate;
            break;
        case "Sampling Date":
            $val =  $sbjf_sample_date1;
            break;
        case "Sampling Time":
            $val =  $sbjf_sample_time1;
            break;
        case "Sex":
            $val =  $sbj_gender;
            break;
        case "Subject Initial":
            $val =  $sbj_initial;
            break;
        case "Allocation No.":
            $val =  $sbj_allocation_no;
            break;
        case "Random No.":
            $val =  $sbj_random_no;
            break;
        case "Screening No.":
            $val =  $sbj_screening_no;
            break;
        case "Report Date":
            //$val =  $sbj_no;
            break;
        case "Weight(kg)":
            $val =  $sbjf_weight;
            break;
        case "Age":
            $val =  $sbjf_age;
            break;
        case "Fasting":
            $val =  $sbjf_fasting;
            break;
        case "Visit":
            $val =  $sbjf_visit;
            break;
        case "Sample":
            //$val =  $sbj_no;
            break;
        case "Sample":
            //$val =  $sbj_no;
            break;
        case "Sample":
            //$val =  $sbj_no;
            break;
        default:
    }
    return $val;
}


//field 0,1,2,3,4,7,8,9,10,11 
$sql    = "SELECT * FROM bim05_subjects where sbj_cd='$subjectCode'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $sbj_no            = $row["sbj_no"];
        $sbj_siteno        = $row["sbj_siteno"];
        $sbj_site          = $row["sbj_site"];
        $sbj_PI            = $row["sbj_PI"];
        $sbj_birthdate     = $row["sbj_birthdate"];
        $sbj_gender        = $row["sbj_gender"];
        $sbj_initial       = $row["sbj_initial"];
        $sbj_allocation_no = $row["sbj_allocation_no"];
        $sbj_random_no     = $row["sbj_random_no"];
        $sbj_screening_no  = $row["sbj_screening_no"];
    }
} else {
    //0 results
}

//field 5,6,13,14,15,16
$sql    = "SELECT * FROM rim01_receipt_base where sbj_cd='$subjectCode' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $sbjf_sample_date1 = $row["sbjf_sample_date1"];
        $sbjf_sample_time1 = $row["sbjf_sample_time1"];
        $sbjf_weight       = $row["sbjf_weight"];
        $sbjf_age          = $row["sbjf_age"];
        $sbjf_fasting      = $row["sbjf_fasting"];
        $sbjf_visit        = $row["sbjf_visit"];
    }
} else {
    //0 results
}

function insertTr($j)
{
    $val = null;

    if (($j % 3) == 0) {
        $val = "</tr><tr>";
        echo " j " . $j;
    }
    return $val;
}

function insertMatching($t, $d)
{
    global $j;
    $val = null;
    if ($t) {
        $j++;
        $val = "<td class='title'><span style='font-weight:bold;'>$t</span></td>";
        $val .= "<td>" . matching($d) . "</td>";
        $val .= insertTr($j);
    }
    return $val;
}

$content = null;
$j = 0;
$sql = "SELECT * FROM bim08_lab_report_print where protocol_cd='$protocol'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $content = "<tr>";
        $content .= insertMatching($row['t00'], $row['d00']);
        $content .= insertMatching($row['t01'], $row['d01']);
        $content .= insertMatching($row['t02'], $row['d02']);
        $content .= insertMatching($row['t03'], $row['d03']);
        $content .= insertMatching($row['t10'], $row['d10']);
        $content .= insertMatching($row['t11'], $row['d11']);
        $content .= insertMatching($row['t12'], $row['d12']);
        $content .= insertMatching($row['t13'], $row['d13']);
        $content .= insertMatching($row['t20'], $row['d20']);
        $content .= insertMatching($row['t21'], $row['d21']);
        $content .= insertMatching($row['t22'], $row['d22']);
        $content .= insertMatching($row['t23'], $row['d23']);
        $content .= insertMatching($row['t30'], $row['d30']);
        $content .= insertMatching($row['t31'], $row['d31']);
        $content .= insertMatching($row['t32'], $row['d32']);
        $content .= insertMatching($row['t33'], $row['d33']);
        $content .= insertMatching($row['t40'], $row['d40']);
        $content .= insertMatching($row['t41'], $row['d41']);
        $content .= insertMatching($row['t42'], $row['d42']);
        $content .= insertMatching($row['t43'], $row['d43']);
        $content .= insertMatching($row['t50'], $row['d50']);
       
        if (($j % 3) == 1) {
            $content .= "<td class='title'></td><td></td>";
            $content .= "<td class='title'></td><td></td>";
            $content .= "</tr>";
        } else if (($j  % 3) == 2) {
            $content .= "<td class='title'></td><td></td>";
            $content .= "</tr>";
        } else {
            $content = substr($content, 0, strlen($content) - 6);
        }
        echo $content;
        
    }
} else {
    //0 results
}


?>
