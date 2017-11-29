<?php

if(!isset($_SESSION)) 
{ 
	session_start(); // Starting Session
} 

//if not allowed, go to blank.php
if ($_SESSION['manager'] == 'f' and $_SESSION['pick1'] == 'f') {
	header('Location: ../project/blank.php'); // Redirecting To Home Page	
}

$_SESSION['page']="pickup/pickuprequest.php";
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
        <!-- Date Picker -->
        <link rel="stylesheet" href="../../plugins/datepicker/datepicker3.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.bootstrap.min.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="../../plugins/iCheck/all.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
        <style>
            td,
            th {
                text-align: center;
            }
        </style>
    </head>
    <!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->

    <body class="hold-transition skin-blue sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">


            <?php
			include "../menuVariables.php";
			$pickuprequest = "active";
			include "../menu.php";
		?>

                <!-- =============================================== -->

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1>
                            Pickup Request
                        </h1>
                        <ol class="breadcrumb">
                            <li>Home</a>
                            </li>
                            <li class="active">Pickup Request</li>
                        </ol>
                    </section>

                    <!-- Main content -->
                    <section class="content">
                        <!-- Main row -->
                        <div class="box" id='top'>
                            <!-- Chat box -->
                            <div class="box box-success">
                                <form class="form-horizontal">
                                    <div class="box-body">
                                        <div class="form-group" id='protocolFormGroup'>
                                            <label for="protocol" class="col-md-2 control-label">Protocol no.</label>
                                            <div class="col-md-5">
                                                <select class="form-control selectpicker" data-live-search="true" name="protocol" id='protocol' title='protocol'>
												</select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="protocolname" class="col-md-2 control-label">안건명</label>
                                            <div class="col-md-5">
                                                <p class="margin" name='protocolname' id='protocolname'></p>
                                            </div>
                                        </div>
                                        <!-- /.form group -->

                                        <div class="form-group">
                                            <label for="site" class="col-md-2 control-label">Site</label>
                                            <div class="col-md-5">
                                                <select class='form-control selectpicker' name='site' id='site' title='Site'>
												</select>
                                            </div>
                                        </div>
                                        <!-- /.form group -->

                                        <!-- Date -->
                                        <div class="form-group">
                                            <label for="datepicker" class="col-md-2 control-label">Pickup Date/Time</label>
                                            <div class="col-md-2" style='padding-right:0px;'>
                                                <div class="input-group date">
                                                    <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
                                                </div>
                                            </div>
                                            <div class="col-md-2" style='padding-right:0px;'>
                                                <input type="text" class="form-control" id="pickupTime" name="pickupTime">
                                                <!-- 												<p class="margin" id='visitTime'>09:00am - 10:00am</p>
 -->
                                            </div>
                                            <!-- 											<div class="col-md-2" style='padding-left:0px; padding-right:0px; margin-right:0px; font-weight: bold; width:80px'>
												<p class="margin" style="">문자발송</p>
											</div>
 -->
                                            <!-- /.input group -->

                                            <!-- 											<div class="col-md-5" style='margin-left:0px; padding-left:0px;'>
												<p class="margin" id='sendtext'>09:00 am</p>
											</div>
 -->
                                        </div>
                                        <div class="form-group">
                                            <label for="datepicker" class="col-md-2 control-label">Pickup Location</label>
                                            <div class="col-md-2" style='padding-right:0px;'>
                                                <input type="text" class="form-control" id="pickupLoc" name="pickupLoc">
                                            </div>
                                        </div>
                                        <!-- /.form group -->
                                        <!-- text input -->

                                        <!-- 								<div class="form-group">
									<label class="col-md-2 control-label">Pickup Time</label>
									<div class="col-md-10">
										<p class="margin" id='visitTime'>09:00am - 10:00am</p>
									</div>
								</div>

 -->
                                        <!-- radio -->
                                        <!-- 								<div class="form-group">
									<label class="col-md-2 control-label">Storage Condition</label>
									<div class="col-md-10">
										<div class="row">
											<div class="col-md-2">
												<label style="margin-top:5px";>
													<input type="radio" name="dong" class="minimal" value='dongYes' checked>
													동결검체있음
												</label>
											</div>
											<div class="col-md-2">
												<label style="margin-top:5px";>
													<input type="radio" name="dong" class="minimal" value="dongNo">
													동결검체없음
												</label>
											</div>
										</div>
									</div>
								</div>

 -->
                                        <div class="form-group">
                                            <label for='quantity' class="col-md-2 control-label">Quantity</label>
                                            <div class="col-md-2">
                                                <!-- 												<input type="text" class="form-control" id="quantity" name="quantity">
 -->
                                                <select class="form-control selectpicker" name="quantity" id='quantity' title='0'>
												</select>
                                            </div>
                                        </div>

                                        <div class="form-group" id='quantityTableShow'>
                                            <label class="col-md-2 control-label"></label>
                                            <div class="col-md-8" id='quantityTableDiv'>
                                                <table class="table table-bordered" id="quantityTable2">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 30%">Subject No.</th>
                                                            <th>visit</th>
                                                            <th>동결검체</th>
                                                            <th>냉장검체</th>
                                                            <th>실온검체</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- text input -->
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Pickup Staff</label>
                                            <!-- 									<div class="col-md-8">
										<p class="margin" >주담당자 <span id='staff1' name='<?=$staff1name?>' style='padding-left:10px'><?=$staff1phone?></span></p>
									</div>
									<div class="col-md-8 col-md-offset-2">
										<p class="margin">부담당자 <span id='staff2' name='<?=$staff2name?>' style='padding-left:10px'><?=$staff2phone?></span></p>
									</div>
 -->
                                            <div class="col-md-10">
                                                <p class="margin">
                                                    <span id='staff1'></span>
                                                    <span id='staffSeperator'></span>
                                                    <span id='staff2'></span>
                                                </p>
                                            </div>
                                        </div>
                                        <!-- /.form-group -->
                                        <div class="form-group">
                                            <label class="col-md-2 control-label">Requestor</label>
                                            <div class="col-md-10">
                                                <p class="margin" name='phone' id='phone'></p>
                                            </div>
                                        </div>

                                        <!-- text input -->
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box box-success -->

                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title" id='pickupRequestTitle'>Request List</h3>
                            </div>
                            <!-- /.box-header -->
                            <form class="form-horizontal checked">
                                <div class="box-body">
                                    <table id="subjectListTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Request No.</th>
                                                <th>Protocol</th>
                                                <th>Site</th>
                                                <th>Requester</th>
                                                <th>Subject No.</th>
                                                <th>Visit</th>
                                                <th>동결/냉장/실온</th>
                                                <th>Pickup</th>
                                                <th>Status</th>
                                                <th>Changed at</th>
                                                <th>By</th>
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

        <!-- Button modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id='myModal'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Order No.
                            <span id='delivery_order_no' , name='delivery_order_no'>
						</span>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="myModalTable">
                            <thead>
                                <tr>
                                    <th>동결검체</th>
                                    <th>냉장검체</th>
                                    <th>실온검체</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id='pickedup'>Save</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- Button modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id='pickupModal'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <table class="table table-bordered" id="pickupModalTable">
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <!-- jQuery 2.2.4 -->
        <script src="http://code.jquery.com/jquery-2.2.4.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../../bootstrap/js/bootstrap.min.js"></script>
        <!-- selectpicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="../../plugins/datepicker/locales/bootstrap-datepicker.kr.js"></script>
        <!-- bootstrap time picker -->
        <script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="../../plugins/iCheck/icheck.min.js"></script>
        <!-- Underscore -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
        <!-- AdminLTE App -->
        <script src="../../dist/js/app.min.js"></script>
        <!-- DataTables -->
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.1.0/js/responsive.bootstrap.min.js"></script>
        <script type="text/javascript" src="pickuprequest.js"></script>

    </body>

    </html>