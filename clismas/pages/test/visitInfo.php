
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CLISMAS</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

</head>
<body class="hold-transition skin-blue">
	<div class="box-body">
		<p>Subject Information</p>

		<table class="table table-bordered">
			<tr>
				<td style="width: 10px">Site</td>
				<td style="width: 10px">#</td>
				<td style="width: 10px">Random No.</td>
				<td style="width: 10px">#</td>
				<td style="width: 10px">Visit</td>
				<td style="width: 10px">#</td>
			</tr>
			<tr>
				<td>1.</td>
				<td>Update software</td>
				<td>Update software</td>
				<td>Update software</td>
				<td>Update software</td>
				<td>Update software</td>
			</tr>
			<tr>
				<td>2.</td>
				<td>Clean database</td>
				<td>Clean database</td>
				<td>Clean database</td>
				<td>Clean database</td>
				<td>Clean database</td>
			</tr>
			<tr>
				<td>3.</td>
				<td>Cron job running</td>
				<td>Cron job running</td>
				<td>Cron job running</td>
				<td>Cron job running</td>
				<td>Cron job running</td>
			</tr>
		</table>
	</div>
	<div class="box-body">
		<p>Result</p>
		<table class="table table-bordered">
			<tr>
				<td style="width: 10px">No.</td>
				<td style="width: 10px">Item</td>
				<td style="width: 10px">Result</td>
				<td style="width: 10px">Abn</td>
				<td style="width: 10px">Reference</td>
			</tr>
			<?php			
	//display error 
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set('display_startup_errors', 1);

	if($_SERVER['SERVER_NAME']=="localhost"){
		$servername = "112.148.73.107";			
	} else {
		$servername = "localhost";			
	}		
	$username = "clismas";
	$password = "clis0001";
	$dbname = "clismas";

	// Create connection
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	// Check connection
	if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT sp_cd,sp_name,protocol_name,site_name,user_ID FROM csm01_users";
	$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
		//echo "<tr>";
		echo "<tr>";
		echo "<td>".$row["sp_cd"]."</td>";
		echo "<td>".$row["sp_name"]."</td>";
		echo "<td>".$row["protocol_name"]."</td>";
		echo "<td>".$row["site_name"]."</td>";
		echo "<td>".$row["user_ID"]."</td>";
		echo "</tr>";
		}
	} else {
	echo "0 results";
	}
	mysqli_close($conn);
?>
		</table>
	</div>
	<!-- /.box-body -->

	<!-- Bootstrap 3.3.6 -->
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
