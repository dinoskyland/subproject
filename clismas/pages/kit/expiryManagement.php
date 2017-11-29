<?php
if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

//if not allowed, go to blank.php
if ($_SESSION['manager'] == 'f' and $_SESSION['kit1'] == 'f') {
	header('Location: ../project/blank.php'); // Redirecting To Home Page	
}

$_SESSION['page']="kit/kitorder.php";
if(!isset($_SESSION['login_user'])){
	header('Location: ../../index.php'); // Redirecting To Home Page
}
$user=$_SESSION['login_user'];
if($_SESSION['manager'] == 't'){
	$level='Manager';
	$_SESSION['site'] = null;
	$_SESSION['protocol'] = null;
	$_SESSION['protocolname'] = null;
} else {
	$level='User';	
}


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
  	td, th {
  		text-align: center;
  	}
  	#expiration {
  		z-index:1151 !important; 
  	}
  </style>
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">

		<!-- =============================================== -->

		<?php
		include "../menuVariables.php";
		$kitorder = "active";
		$expiryManagement = "active";
		include "../menu.php";
		?>

		<!-- =============================================== -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					Kit Expiry Management
				</h1>
				<ol class="breadcrumb">
					<li>Home</a></li>
					<li class="active">Kit Order</li>
					<li class="active">Kit Expiry Management</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content">
				<!-- Main row -->
				<div class="box">
					<!-- Chat box -->
					<div class="box box-success">
						<form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							<div class="box-body">
								<div class="form-group">
									<label for="protocol" class="col-md-2 control-label">안건코드</label>
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
										<div class="row">
											<div class="col-md-5">
												<p class="margin" name='protocolname' id='protocolname'></p>
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

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


								<div class="form-group">
									<label for="address" class="col-md-2 control-label">배송주소</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<input type="text" class="form-control" id="address" name="address">
											</div>
											<div class="col-md-5">
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label for="phone" class="col-md-2 control-label">전화번호</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<input type="text" class="form-control" id="phone" name="phone">
											</div>
											<div class="col-md-5">
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label for="requester" class="col-md-2 control-label">요청자</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<input type="text" class="form-control" id="requester", name="requester">
											</div>
											<div class="col-md-5">
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

								<!-- Date -->
								<div class="form-group">
									<label for="datepicker" class="col-md-2 control-label">수령희망일</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<div class="input-group date">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
												</div>
											</div>
											<div class="col-md-5">
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label class="col-md-2 control-label">Visit Name / Material(for Kit Order)</label>
									<div class="col-md-7">
										<table class="table table-bordered" id="kittable">
											<thead>
												<tr>						
													<th >Visit Name / Material</th>
													<th style="width: 10%">Quantity</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								</div>
								<!-- /.form group -->

								<div class="form-group">
									<label class="col-md-2 control-label"></label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-5">
												<button type="button" class="btn btn-primary" name="order" id="order">Submit Order</button>
											</div>
										</div>
									</div>
								</div>
								<!-- /.form group -->
							</div>
							<!-- /.box-body -->
						</form>
					</div>
					<!-- /.box box-success -->
				</div>
				<!-- /.box -->

				<div class="box">
					<div class="box-header">
						<h3 class="box-title" id='yourOrder'>Your Order</h3>
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<table id="yourOrderTable" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Order No.</th>
									<th>Site</th>
									<th>요청일</th>
									<th>요청자</th>
									<th>수령희망일</th>
									<th>Order Sum</th>
									<th>Expiration Date</th>
									<th>Shipped Date</th>
									<th>Received Date</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
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


	<!-- Button modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id='myModal'>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Order Number:
						<span id='delivery_order_no', name='delivery_order_no'>
						</span>
					</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="deliverytable">
						<thead>
							<tr>						
								<th class='kitname'>Expiration Date</th>
								<th><input type='text' class='form-control pull-right' id='expiration'></th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id='delivered'>Save</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Button modal -->
	<div class="modal fade" tabindex="-1" role="dialog" id='myModalOrderSum'>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Order Number:
						<span id='orderSumTitle', name='orderSumTitle'>
						</span>
					</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered" id="orderSumTable">
						<thead>
							<tr>						
								<th>Visit Name/Material</th>
								<th>Quantity</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<!-- jQuery 2.2.4 -->
	<script src="http://code.jquery.com/jquery-2.2.4.min.js" ></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="../../bootstrap/js/bootstrap.min.js"></script>
	<!-- selectpicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
	<!-- bootstrap datepicker -->
	<script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="../../plugins/datepicker/locales/bootstrap-datepicker.kr.js"></script>
	<!-- Underscore -->
<!-- 	<script src="../../plugins/underscore/underscore.min.js"></script>
 -->	<!-- iCheck 1.0.1 -->
	<script src="../../plugins/iCheck/icheck.min.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/app.min.js"></script>
	<!-- DataTables -->
	<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
	<script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>	
	<script src="kitorder.js"></script>

	<!-- Page script -->
<!-- 	<script type="underscore/template" id="protocol-option-tpl">
		<% _.each(items, function(item) { %>
			<option id="<%= item.pl_protocol_name %>"><%= item.pl_protocol_cd %></option>
		<% }) %>
	</script> -->
	
</body>
</html>
