<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
	header('location:logout.php');
	} else{

	if(isset($_GET['del']))
			{
				$userID=$_GET['uid'];
					mysqli_query($deal,"DELETE FROM users WHERE id ='$userID'");
					$_SESSION['msg']="data deleted !!";
			}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Manage Users</title>
		<!-- custom css -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />
	</head>
<body>
	<div id="application">		
	<?php include('../define/sidebar.php');?>
		<div class="appplication-content">				
			<?php include('../define/header.php');?>										
			<div class="main-content" >
				<div id="container" class="wrap-content container" >
				<!-- start: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8">
								<h1 class="mainTitle">Admin | Manage Users</h1>
							</div>
							<ol class="breadcrumb">
								<li><span>Admin</span></li>
								<li class="active"><span>Manage Users</span></li>
							</ol>
						</div>
					</section>
					<!-- end: PAGE TITLE -->
					<!-- content -->
					<div class="container-fluid container-fullw bg-white">						
						<div class="row">
							<div class="col-md-12">
							<h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Users</span></h5>
							<p style="color:red;">
							    <?php echo htmlentities($_SESSION['msg']);?>
								<?php echo htmlentities($_SESSION['msg']="");?>
							</p>	
							<table class="table table-hover" id="users-table">
								<thead>
									<tr>
										<th class="center">#</th>
										<th>Full Name</th>
										<th class="hidden-xs">Adress</th>
										<th>City</th>
										<th>Gender </th>
										<th>Email </th>
										<th>Creation Date </th>
										<th>Updation Date </th>
										<th>Action</th>												
									</tr>
								</thead>
								<tbody>
								<?php
									$qUser=mysqli_query($deal,"SELECT * FROM users");
									$count=1;
									while($recordset=mysqli_fetch_array($qUser))
									{
								?>
									<tr>
										<td class="center"><?php echo $count;?>.</td>
										<td class="hidden-xs"><?php echo $recordset['fullName'];?></td>
										<td><?php echo $recordset['address'];?></td>
										<td><?php echo $recordset['city'];?></td>
										<td><?php echo $recordset['gender'];?></td>
										<td><?php echo $recordset['email'];?></td>
										<td><?php echo $recordset['regDate'];?></td>
										<td><?php echo $recordset['updationDate'];?></td>
										<td >
											<div class="visible-md visible-lg hidden-sm hidden-xs">																				
												<a href="manageUsers.php?uid=<?php echo $recordset['id']?>&del=delete" 
												   onClick="return confirm('Are you sure you want to delete?')"
												   class="btn btn-transparent btn-xs tooltips" tooltip-placement="top" tooltip="Remove">
												   <i class="fa fa-times fa fa-white"></i>
											    </a>
											</div>											
										</td>
									</tr>											
									<?php $count=$count+1; }?>																						
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>						
	</div>				
	<!-- FOOTER -->
	<?php include('../define/footer.php');?>
	<?php include('../define/setting.php');?>
	<!-- javascript -->
	<script src="../assign/js/main.js"></script>		
	<script src="../assign/js/form-elements.js"></script>
	<script>
			jQuery(document).ready(function() {
			Main.init();
			FormElements.init();
		});
	</script>	
	</body>
</html>
<?php } ?>