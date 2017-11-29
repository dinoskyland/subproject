<?php
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

/*if ($_SESSION['manager'] == 'f') {
	header('Location: blank.php'); // Redirecting To Home Page	
}*/

$_SESSION['page']="project/usermodifyForManagerEdit.php";
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../../plugins/iCheck/flat/blue.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<?php
		include "../menuVariables.php";
		$project = "active";
		$usermodify = "active";
		include "../menu.php";
		?>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					사용자정보수정
				</h1>
				<ol class="breadcrumb">
					<li>Home</a></li>
					<li class="active">Project</li>
					<li class="active">사용자정보수정</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- Main row -->
				<div class="box">
					<!-- Chat box -->
					<div class="box-header">
					</div>
					<form class="form-horizontal">
						<div class="box-body">

							<div class="form-group user-group manager-group">
								<label for="address" class="col-md-2 control-label">User ID</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="userid" id='userid'>
<!-- 									<select class="form-control selectpicker" data-live-search="true" name="userid" id='userid' title='user id'>
									</select>
 -->								</div>
							</div>

							<div class="form-group pickup-group">
								<label for="address" class="col-md-2 control-label">Staff ID</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="staffid" id='staffid'>
<!-- 									<select class="form-control selectpicker" data-live-search="true" name="staffid" id='staffid' title='user id'>
									</select>
 -->								</div>
							</div>

<!-- 							<div class="form-group">
								<label for="manager" class="col-md-2 control-label"></label>
								<div class="col-md-2">
									<input type="checkbox" class='minimal' id='pickup'> Pickup Staff
								</div>
							</div>

 -->							<div class="form-group user-group">
								<label for="protocolname" class="col-md-2 control-label">안건명</label>
								<div class="col-md-5">
									<p class="margin" name='protocolname' id='protocolname'></p>
								</div>
								<div class="col-md-5">
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group user-primary-group staff-primary-group">
								<label for="address" class="col-md-2 control-label">담당자명</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="person" id='person'>
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group user-primary-group staff-primary-group">
								<label for="phone" class="col-md-2 control-label">연락처</label>
								<div class="col-md-5">
									<input type="text" class="form-control" data-inputmask='"mask": "99[9]-999[9]-9999"' data-mask name="phone" id="phone">
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group user-group user-primary-group">
								<label for="address" class="col-md-2 control-label">이메일</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="email" id="email">
								</div>
							</div>
							<!-- /.form group -->
							<div class="form-group user-group user-primary-group">
								<label for="address" class="col-md-2 control-label">주소</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="address" id="address">
								</div>
							</div>
							<!-- /.form group -->
							<div class="form-group pickup-group staff-primary-group">
								<label for="address" class="col-md-2 control-label">직급</label>
								<div class="col-md-5">
									<select class="form-control selectpicker" style="width: 100%;" name="staffrole" id='staffrole'>
										<option selected='selected'>주담당자</option>	
										<option>부담당자</option>	
									</select>
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group user-group user-primary-group">
								<label for="address" class="col-md-2 control-label">Pickup Location</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="pickupLoc" id="pickupLoc">
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group user-group user-primary-group">
								<label for="address" class="col-md-2 control-label">Pickup Time</label>
								<div class="col-md-5">
									<input type="text" class="form-control" name="pickupTime" id="pickupTime">
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group pickup-group">
								<label for="assignSite" class="col-md-2 control-label">Assign Site</label>
								<div class="col-md-5">
									<select class='form-control selectpicker' name='assignSite' id='assignSite' title='Site' multiple>
									</select>
								</div>
							</div>
							<!-- /.form group -->

							<div class="form-group user-group">
								<label class="col-md-2 control-label">권한</label>
								<div class="col-md-10">
									<div class="row">
										<div class="col-md-2">
											Lab Resut
										</div>
										<div class="col-md-3">
											<input type="checkbox" class='minimal' id="lab1"> Real Time Test Result
										</div>
										<div class="col-md-3">
											<input type="checkbox" class='minimal' id="lab2"> Result Statistics
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											Pickup Request
										</div>
										<div class="col-md-3">
											<input type="checkbox" class='minimal' id='pick1'> Pickup Request
										</div>
										<div class="col-md-3">
											<input type="checkbox" class='minimal' id='pick2'> Pickup Request History
										</div>
									</div>
									<div class="row">
										<div class="col-md-2">
											Kit Order
										</div>
										<div class="col-md-3">
											<input type="checkbox" class='minimal' id='kit1'> Kit Order
										</div>
										<div class="col-md-3">
											<input type="checkbox" class='minimal' id='kit2'> Order History
										</div>
									</div>
								</div>
							</div>
							<!-- /.form-group -->

							<div class="form-group  user-primary-group staff-primary-group">
								<label class="col-md-2 control-label"></label>
								<div class="col-md-10">
									<div class="row">
										<div class="col-md-2">
											<button type="button" class="btn btn-primary" name="submit" style="width:100px" id="submit">  수정</button>
										</div>
										<div class="col-md-2">
											<button type="button" class="btn btn-primary" name="userdelete" style="width:100px" id="userdelete">  삭제</button>
										</div>
										<div class="col-md-6">
										</div>
									</div>
								</div>
							</div>
							<!-- /.form group -->
						</div>
						<!-- /.box-body -->
					</form>
					<!-- /.box box-success -->
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
	<!-- InputMask -->
	<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
	<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
	<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
	<!-- bootstrap datepicker -->
	<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<!-- iCheck 1.0.1 -->
	<script src="../../plugins/iCheck/icheck.min.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/app.min.js"></script>

	<script type="text/javascript" src="usermodify.js"></script>
	<!-- selectpicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

</body>
</html>
