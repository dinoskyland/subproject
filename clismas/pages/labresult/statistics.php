<?php

if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

//if not allowed, go to blank.php
if ($_SESSION['manager'] == 'f' and $_SESSION['lab1'] == 'f') {
	header('Location: ../project/blank.php'); // Redirecting To Home Page	
}

$_SESSION['page']="labresult/labresult.php";
if(!isset($_SESSION['login_user'])){
	header('Location: ../../index.php'); // Redirecting To Home Page
}

include "../userInfo.php";

?>

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
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- selectpicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style>
  	td, th{text-align: center;}

  	/*modal with scrool bar*/  	
  	.modal .modal-body {
  		max-height: 640px;
  		overflow-y: auto;
  	}

/*	.bar {
	  fill: steelblue;
	}
*/
	.axis text {
	  font: 15px Helvetica;
	}

	.label {
	  font: 15px Helvetica;
	}

	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}

	.x.axis path {
	  display: none;
	}

	.line {
  fill: none;
  stroke: steelblue;
  stroke-width: 1.5px;
}

.axis--x path {
  display: none;
}

  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<?php
		include "../menuVariables.php";
		$labresult = "active";
		$statistics = "active";
		include "../menu.php";
		?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Result Statistics
				</h1>
				<ol class="breadcrumb">
					<li>Home</a></li>
					<li class="active">Lab Result</li>
					<li class="active">Result Statistics</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- Main row -->
				<div class="box">
					<!-- Chat box -->
					<div class="box box-success">
						<form class="form-horizontal" method="post" action="">
							<div class="box-body">
								<div class="form-group">
									<label for="protocol" class="col-md-2 control-label">Protocol no.</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<select class="form-control selectpicker" data-live-search="true" name="protocol" id='protocol' title='protocol'>
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="site" class="col-md-2 control-label">Site</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<select class='form-control selectpicker' name='site' id='site' title='Site'>
												</select>
											</div>									
										</div>										
									</div>
								</div>
								<!-- /.form group -->
								
							</div>
							<!-- /.box-body -->

						</form>
					</div>
					<!-- /.box (chat box) -->
				</div>
				<!-- /.row (main row) -->


				<!-- BAR CHART -->
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">대상자 등록현황</h3>
					</div>
					<div class="box-body">
						<svg width="800" height="250" class="bar-chart"></svg>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->

				<!-- line CHART -->
				<div class="box box-info">
					<!-- text input -->
					<div class="box-header with-border">
						<h3 class="box-title">검사 결과 그래프</h3>
					</div>
					
 					<div class="form-group">
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-1">
									<p class="margin">Subject Initial</p>
								</div>
								<div class="col-md-2">
									<select class='form-control selectpicker' data-live-search="true" name='subjectInitial' id='subjectInitial' title='Initial'>
									</select>
								</div>
								<div class="col-md-1">
									<p class="margin">Subject No.</p>
								</div>
								<div class="col-md-2">
									<select class='form-control selectpicker' data-live-search="true" name='subjectNo' id='subjectNo' title='No.'>
									</select>
								</div>
								<div class="col-md-1">
									<p class="margin">Test Name</p>
								</div>
								<div class="col-md-2">
									<select class='form-control selectpicker' data-live-search="true" name='testName' id='testName' title='Test Name'>
									</select>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-primary" name="result" id="result">Test Result</button>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body">
						<svg width="800" height="300" class="line-chart"></svg>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->


			</section>
			<!-- /.content -->
		</div>
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->

	<!-- jQuery 2.2.4 -->
	<script src="http://code.jquery.com/jquery-2.2.4.min.js" ></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<!-- selectpicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
	<!-- date-range-picker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
	<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
	<!-- SlimScroll 1.3.0 -->
	<script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
	<!-- iCheck 1.0.1 -->
	<script src="../../plugins/iCheck/icheck.min.js"></script>
	<!-- FastClick -->
	<script src="../../plugins/fastclick/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/app.min.js"></script>
	<!-- D3 4.4 -->
	<script src="https://d3js.org/d3.v4.min.js"></script>
	<!-- W 1.6.3  -->
	<!-- handles common tasks related to window resizing  -->
	<script src="../../plugins/W/W.min.js"></script>

	<script src="statistics.js"></script>

</body>
</html>
