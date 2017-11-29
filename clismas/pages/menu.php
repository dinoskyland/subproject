
<header class="main-header">
	<!-- Logo -->
	<a href="../labresult/labresult.php" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>CLISMAS</b></span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>CLISMAS</b></span>
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<span class="hidden-xs"><?=$user?></span>
					</a>
					<ul class="dropdown-menu">
						<!-- Menu Footer-->
						<li class="user-footer">
							<div>
								<a href="../login/logout.php" class="btn btn-default btn-flat">Log out</a>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>

<aside class='main-sidebar'>
	<!-- sidebar: style can be found in sidebar.less -->
	<section class='sidebar'>
		<!-- Sidebar user panel -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class='sidebar-menu'>

			<?php
			if($_SESSION['staff'] == 'f' and $_SESSION['manager'] == 'f'){
				//user
				echo "
				<li class='$labresult treeview'>
					<a href='#'>
						<i class='fa fa-flask'></i><span>Lab Result</span>
						<span class='pull-right-container'>
							<i class='fa fa-angle-left pull-right'></i>
						</span>
					</a>
					<ul class='treeview-menu'>
						<li class='$labresult'><a href='../labresult/labresult.php'><i class='fa fa-circle-o'></i> Real Time Test Result</a></li>
						<li class='$statistics'><a href='../labresult/statistics.php'><i class='fa fa-circle-o'></i> Result Statistics</a></li>
					</ul>
				</li>
				<li class='$pickuprequest'>
					<a href='../pickup/pickuprequest.php'>
						<i class='fa fa-plus-square'></i><span>Pickup Request</span>
					</a>
				</li>					
				<li class='$kitorder treeview'>
					<a href='#'>
						<i class='fa fa-reorder'></i><span>Kit Order</span>
						<span class='pull-right-container'>
							<i class='fa fa-angle-left pull-right'></i>
						</span>
					</a>
					<ul class='treeview-menu'>
						<li class='$kitorderSub'><a href='../kit/kitorder.php'><i class='fa fa-circle-o'></i> Kit Order</a></li>
						<li class='$orderHistory'><a href='../kit/orderHistory.php'><i class='fa fa-circle-o'></i> Order History</a></li>
						<li class='$expiryManagement'><a href='../kit/expiryManagement.php'><i class='fa fa-circle-o'></i> Kit Expiry Management</a></li>
					</ul>
				</li>
				<li class='treeview $project'>
					<a href='#'>
						<i class='fa fa-wrench'></i><span>Admin</span>
						<span class='pull-right-container'>
							<i class='fa fa-angle-left pull-right'></i>
						</span>
					</a>
					<ul class='treeview-menu'>
						<li class='$usermodify'><a href='../project/usermodify.php'><i class='fa fa-circle-o'></i> 사용자정보수정</a></li>
					</ul>
				</li>";
			} else if ($_SESSION['staff'] == 't'){
				echo "
				<li class='$pickuprequest'>
					<a href='pickuprequest.php' id='pickuprequest'>
						<i class='fa fa-plus-square'></i><span>Pickup Request</span>
					</a>
				</li>
				<li class='treeview $project'>
					<a href='#'>
						<i class='fa fa-wrench'></i><span>Admin</span>
						<span class='pull-right-container'>
							<i class='fa fa-angle-left pull-right'></i>
						</span>
					</a>
					<ul class='treeview-menu'>
						<li class='$usermodify'><a href='../project/usermodify.php'><i class='fa fa-circle-o'></i> 사용자관리</a></li>
					</ul>
				</li>";
			} else if($_SESSION['manager'] == 't'){
				echo "
				<li class='$labresult treeview'>
					<a href='#'>
						<i class='fa fa-flask'></i><span>Lab Result</span>
						<span class='pull-right-container'>
							<i class='fa fa-angle-left pull-right'></i>
						</span>
					</a>
					<ul class='treeview-menu'>
						<li class='$labresult'><a href='../labresult/labresult.php'><i class='fa fa-circle-o'></i> Real Time Test Result</a></li>
						<li class='$statistics'><a href='../labresult/statistics.php'><i class='fa fa-circle-o'></i> Result Statistics</a></li>
					</ul>
				</li>
				<li class='$pickuprequest'>
					<a href='../pickup/pickuprequest.php'>
						<i class='fa fa-plus-square'></i><span>Pickup Request</span>
					</a>
				</li>					
				<li class='$kitorder treeview'>
					<a href='#'>
						<i class='fa fa-reorder'></i><span>Kit Order</span>
						<span class='pull-right-container'>
							<i class='fa fa-angle-left pull-right'></i>
						</span>
					</a>
					<ul class='treeview-menu'>
						<li class='$kitorderSub'><a href='../kit/kitorder.php'><i class='fa fa-circle-o'></i> Kit Order</a></li>
						<li class='$orderHistory'><a href='../kit/orderHistory.php'><i class='fa fa-circle-o'></i> Order History</a></li>
						<li class='$expiryManagement'><a href='../kit/expiryManagement.php'><i class='fa fa-circle-o'></i> Kit Expiry Management</a></li>
					</ul>
				</li>
			<li class='treeview $resultreport'>
				<a href='#'>
					<i class='fa fa-file-o'></i><span>Result Report</span>
					<span class='pull-right-container'>
						<i class='fa fa-angle-left pull-right'></i>
					</span>
				</a>
				<ul class='treeview-menu'>
					<li class='$resultreportSub'><a href='../report/resultreport.php'><i class='fa fa-circle-o'></i> Result Report</a></li>
					<li class='$reReport'><a href='../report/reReport.php'><i class='fa fa-circle-o'></i> Re-Report</a></li>
					<li class='$reportLog'><a href='../report/reportLog.php'><i class='fa fa-circle-o'></i> Report Log</a></li>
				</ul>
			</li>
			<li class='treeview $project'>
				<a href='#'>
					<i class='fa fa-wrench'></i><span>Admin</span>
					<span class='pull-right-container'>
						<i class='fa fa-angle-left pull-right'></i>
					</span>
				</a>
				<ul class='treeview-menu'>
					<li class='$kitsetup'><a href='../project/kitsetup.php'><i class='fa fa-circle-o'></i> 안건별KIT설정</a></li>
					<li class='$register'><a href='../project/register.php'><i class='fa fa-circle-o'></i> 사용자등록</a></li>
					<li class='$usermodifyForManager'><a href='../project/usermodifyForManager.php'><i class='fa fa-circle-o'></i> 사용자관리</a></li>
					<li class='$materialInventory'><a href='../project/materialInventory.php'><i class='fa fa-circle-o'></i> Material Inventory</a></li>
				</ul>
			</li>";
		}

		?>
		</ul>
	</section>
<!-- /.sidebar -->
</aside>