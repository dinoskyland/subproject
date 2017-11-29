<?php
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 
//if not manager, go to blank.php
if ($_SESSION['manager'] == 'f') {
	header('Location: blank.php'); // Redirecting To Home Page	
}

$_SESSION['page']="project/kitsetup.php";
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
	<!-- Theme style -->
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/iCheck/flat/blue.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
 <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
<!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- selectpicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">
<style>
td{text-align: center;}
</style>
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">

		<?php
			include "../menuVariables.php";
			$project = "active";
			$kitsetup = "active";
			include "../menu.php";
		?>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					안건별KIT설정
				</h1>
				<ol class="breadcrumb">
					<li>Home</a></li>
					<li class="active">Project</li>
					<li class="active">안건별KIT설정</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- Main row -->
				<div class="box">
					<!-- Chat box -->
					<div class="box box-success">
						<!-- form start -->
						<form class="form-horizontal">
							<div class="box-body">
								<div class="form-group">
									<label for="address" class="col-md-2 control-label">안건코드</label>
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
									<label for="protocolname" class="col-md-2 control-label">안건명</label>
									<div class="col-md-10">
										<p class="margin" name='protocolname' id='protocolname'></p>
									</div>
								</div>
								<!-- /.form group -->

								<!-- Date range -->
								<div class="form-group">
									<label for="period" class="col-md-2 control-label">Study 시작/종료</label>
									<div class="col-md-10">
										<p class="margin" id='period'></p>
									</div>
								</div>
								<!-- /.form group -->


								<div class="form-group">
									<label for="" class="col-md-2 control-label">안건설명</label>
									<div class="col-md-10">
										<p class="margin" id='info'></p>
									</div>
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label for="sponsor" class="col-md-2 control-label">제약사명</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<p class="margin" id='sponsor'></p>
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label class="col-md-2 control-label">Visit Name / Material(for Kit Order)</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<table class="table table-bordered">
													<tr>
														<th>Visit Name / Material</th>
														<th></th>
													</tr>
													<tr>
														<td>
															<input type='text' class='form-control' id="kitname" name="kitname">
														</td>
														<td>
															<button type="button" class="btn btn-primary" id="kitinsert" name='kitinsert' style="width: 100%">추가</button>
														</td>
													</tr>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

							</div>
							<!-- /.box-body -->
							<!-- /.form group -->
						</form>
					</div>
					<!-- /.box box-success -->
				</div>
				<!-- /.box -->


				<div class="box">
					<div class="box-header">
						<h3 class="box-title" id='kitList'>Kit List</h3>
					</div>
					<!-- /.box-header -->
					<form class="form-horizontal">
						<div class="box-body">
							<table id="kitListTable" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Kit No.</th>
										<th>안건코드</th>
										<th>Kit Name</th>
										<th>등록날자</th>
										<th>등록인</th>
										<th>수정</th>
										<th>삭제</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</form>
				</div>
				<!-- /.box -->


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

	<script type="text/javascript" src="kitsetup.js"></script>

	<!-- selectpicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

</body>
</html>
