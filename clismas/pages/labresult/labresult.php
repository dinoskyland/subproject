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
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">

		<?php
			include "../menuVariables.php";
			$labresult = "active";
			$labresultSub = "active";
			include "../menu.php";
		?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Real Time Test Result
				</h1>
				<ol class="breadcrumb">
					<li>Home</a></li>
					<li class="active">Lab Result</li>
					<li class="active">Real Time Test Result</li>
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
								
								<!-- Date range -->
								<div class="form-group">
									<label for="period" class="col-md-2 control-label">Period</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5 offset-md-5">
												<input type="text" class="form-control pull-right" id="period">
											</div>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label class="col-md-2 control-label"></label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-2">
												<label style="margin-top:5px;" for='periodAll'></label>
												<input type="radio" name="periodCondition" id='periodAll' class="minimal" value='all'>All
											</div>
											<div class="col-md-2">
												<label style="margin-top:5px;" for='periodPeriod'></label>
												<input type="radio" name="periodCondition" id='periodPeriod' class="minimal" value="period" checked>Period
											</div>
										</div>
									</div>
								</div>

								<!-- text input -->
								<div class="form-group">
									<label class="col-sm-2 control-label">Reference Criteria</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-2">
												<p class="margin">Subject Initial</p>
											</div>
											<div class="col-md-2">
<!-- 												<input type="text" class="form-control" name="subjectInitial" id='subjectInitial'>
 -->											
												<select class='form-control selectpicker' data-live-search="true" name='subjectInitial' id='subjectInitial' title='Initial'>
												</select>
 											</div>
											<div class="col-md-2">
												<p class="margin">Subject No.</p>
											</div>
											<div class="col-md-2">
<!-- 												<input type="text" class="form-control" name="subjectNo" id='subjectNo'>
 -->											
												<select class='form-control selectpicker' data-live-search="true" name='subjectNo' id='subjectNo' title='No.'>
												</select>
 											</div>
											<div class="col-md-2">
												<button type="button" class="btn btn-primary" name="result" id="result">Test Result</button>
											</div>
										</div>
									</div>
								</div>

							</div>
							<!-- /.box-body -->

						</form>
					</div>
					<!-- /.box (chat box) -->
				</div>
				<!-- /.row (main row) -->


				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Subject List</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="subjectList" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Registration</th>
									<th>Subject Initial</th>
									<th>Subject No.</th>
									<th>Random No.</th>
									<th>Sampling Date</th>
									<th>Sex</th>
									<th>DOB</th>
									<th>Visit</th>
									<th>Previous Visit</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
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
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
<script src="labresult.js"></script>

</body>
</html>
