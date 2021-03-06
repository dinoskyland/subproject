<?php
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

if ($_SESSION['manager'] == 'f') {
	header('Location: blank.php'); // Redirecting To Home Page	
}

$_SESSION['page']="project/usermodify.php";
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
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- selectpicker -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <style>
    .tab-content {
      margin: 15px;
    }

    .table {
      margin-top: 30px;
    }

  </style>

</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<?php
		include "../menuVariables.php";
		$project = "active";
		$usermodifyForManager = "active";
		include "../menu.php";
		?>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					사용자관리
				</h1>
				<ol class="breadcrumb">
					<li>Home</a></li>
					<li class="active">Project</li>
					<li class="active">사용자관리</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
	          <div class="box box-default">
					<ul class="nav nav-tabs">
					  <li class="active"><a href="#tab1" data-toggle="tab">사용자 관리</a></li>
					  <li><a href="#tab2" data-toggle="tab">Pickup Staff 관리</a></li>
					</ul>
					<div class="tab-content">
					        <div class="tab-pane active" id="tab1">
								<div class="form-group form-horizontal">
									<div class="row">
										<label for="protocol" class="col-md-2 control-label">Protocol no.</label>
										<div class="col-md-5">
											<select class="form-control selectpicker" data-live-search="true" name="protocol" id='protocol' title='protocol'>
											</select>
										</div>
									</div>
								</div>

								<div class="row" style="margin-bottom: 15px">
									<div class="form-group form-horizontal">
										<label for="site" class="col-md-2 control-label">Site</label>
										<div class="col-md-5">
											<select class='form-control selectpicker' name='site' id='site' title='Site'>
											</select>
										</div>							
									</div>
								</div>
								<!-- /.form group -->
								<table id="userAdminTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Protocol no.</th>
											<th>Site</th>
											<th>Name</th>
											<th>ID</th>
											<th>Email</th>
											<th>Contact</th>
											<th>Lab Report</th>
											<th>Authority</th>
											<th>Status</th>
											<th>Edit</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
					        </div>
					        
					        <div class="tab-pane" id="tab2">
					            <h4>Pickup Staff 관리</h4>
								<table id="pickupAdminTable" class="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Protocol no.</th>
											<th>Site</th>
											<th>Name</th>
											<th>ID</th>
											<th>Email</th>
											<th>Contact</th>
											<th>Lab Report</th>
											<th>Authority</th>
											<th>Status</th>
											<th>Edit</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
					        </div>
					</div><!-- tab content -->
		        </div>

			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
<!-- 		<footer class="main-footer">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.3.5
			</div>
			<strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
			reserved.
		</footer> -->
		<div class="control-sidebar-bg"></div>
	</div>
	<!-- ./wrapper -->

	<!-- jQuery 2.2.4 -->
	<script src="http://code.jquery.com/jquery-2.2.4.min.js" ></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/app.min.js"></script>
	<!-- selectpicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

	<!-- DataTables -->
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>	
	<script src="kitorder.js"></script>

	<script src="usermodifyForManager.js"></script>
</body>
</html>
