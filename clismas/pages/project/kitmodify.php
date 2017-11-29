<?php 
	//display error 
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once '../clisconnect.php';

$id = $_POST['id'];
$kitname = $_POST['kitname'];
$pattern = '/^[ㄱ-ㅎㅏ-ㅣ가-힣\s\w()-]+$/';

if (preg_match($pattern, $kitname)) {
	$sql = "UPDATE csm04_protocol_KIT set kit_name='$kitname' where id='$id'";

	if ($connClis->query($sql) === TRUE) {
	    //echo "1";
	} else {
	    echo "Error: " . $sql . "<br>" . $connClis->error;
	}

	$sql = "UPDATE csm04_KIT_order_detail set kit_name='$kitname' where id='$id'";

	if ($connClis->query($sql) === TRUE) {
	    echo "1";
	} else {
	    echo "Error: " . $sql . "<br>" . $connClis->error;
	}

} else {
	echo "Kit Name은 문자,순자,(),-,_ 만 가능합니다";
}

$connClis->close();
?>
