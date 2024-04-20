<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	include('include/checklogin.php');
	check_login();
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Reg Users | View Medical History</title>
		<!-- CSS -->
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
<body>
	<div id="application">		
		<?php include('include/sidebar.php');?>
		<div class="application-content">
			<?php include('include/header.php');?>
			<div class="main-content" >
				<div class="wrap-content container" id="container">
					<!-- select: PATE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Users | Medical History</h1></div>
							<ol class="breadcrumb">
								<li><span>Users</span></li>
								<li class="active"><span>View Medical History</span></li>
							</ol>
						</div>
					</section>
					<!-- selection : CONTENT -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">
								<h5 class="over-title margin-bottom-15">View <span class="text-bold">Medical History</span></h5>										
								<table id="patient-table" class="table table-hover" >
									<thead>
										<tr>
											<th class="center">#</th>
											<th>Patient Name</th>
											<th>Patient Contact Number</th>
											<th>Patient Gender </th>
											<th>Creation Date </th>
											<th>Updation Date </th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>											
										<?php
											$userID=$_SESSION['id'];
											$qUser=mysqli_query($deal,"SELECT tblpatient.* 
																FROM patient JOIN users ON users.email=tblpatient.PatientEmail 
																WHERE users.id='$userID'");
											$count=1;												
											while($resultset=mysqli_fetch_array($qUser))
											{
										?>
											<tr>
												<td class="center"><?php echo $count;?>.</td>
												<td class="hidden-xs"><?php echo $resultset['PatientName'];?></td>
												<td><?php echo $resultset['PatientContno'];?></td>
												<td><?php echo $resultset['PatientGender'];?></td>
												<td><?php echo $resultset['CreationDate'];?></td>
												<td><?php echo $resultset['UpdationDate'];?></td>
												<td><a href="infoMedhistory.php?infoid=<?php echo $resultset['ID'];?>">
													<i class="fa fa-eye"></i></a>
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
	</div>
	<!--  FOOTER -->
	<?php include('include/footer.php');?>	
	<?php include('include/setting.php');?>
	<!-- JAVASCRIPT -->
	<script src="assign/js/main.js"></script>
	<script src="assign/js/form-elements.js"></script>
	<script>
		jQuery(document).ready(function() {
			Main.init();
			FormElements.init();
		});
	</script>
</body>
</html>
