<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
	 header('location:logout.php');
	  } else{
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin  | Dashboard</title>
		
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
						<!-- PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | Dashboard</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>Admin</span>
									</li>
									<li class="active">
										<span>Dashboard</span>
									</li>
								</ol>
							</div>
						</section>
						<!-- end: -->
						<!-- menu-->
							<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> 
												<i class="fa fa-square fa-stack-2x text-primary"></i> 
												<i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> 
											</span>
											<h2 class="StepTitle">Manage Users</h2>											
											<p class="links cl-effect-1">
												<a href="ManageUsers.php">
												    <?php $qUser = mysqli_query($deal,"SELECT * FROM users ");
													      $nrUer = mysqli_num_rows($qUser);
													 {
											    	?>
											        Total Users :<?php echo htmlentities($nrUser);  } ?>		
												</a>
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-users fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">Manage Doctors</h2>										
											<p class="cl-effect-1">
												<a href="ManageDoctors.php">
													<?php $qDoc = mysqli_query($deal,"SELECT * FROM doctors ");
													  $nrDoc = mysqli_num_rows($qDoc);
													  {
													?>
													Total Doctors :<?php echo htmlentities($nrDoc);  } ?>		
												</a>												
											</p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-terminal fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle"> Appointments</h2>											
											<p class="links cl-effect-1">
												<a href="bookAppointment.php">
													<a href="appointmentHistory.php">
												       <?php $qApp= mysqli_query($deal,"SELECT * FROM appointment");
                                                             $nrApp = mysqli_num_rows($qApp);
                                                             {
                                                       ?>
											                Total Appointments :<?php echo htmlentities($nrApp);  } ?>	
												    </a>
												</a>
											</p>
										</div>
									</div>
								</div>
                                <div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> 
												<i class="fa fa-square fa-stack-2x text-primary"></i> 
												<i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> 
											</span>
											<h2 class="StepTitle">Manage Patients</h2>			
											<p class="links cl-effect-1">
												<a href="managePatient.php">
												   <?php $qPat = mysqli_query($deal,"SELECT * FROM patients ");
										                 $nrPat = mysqli_num_rows($qPat);
														{
													?>
														Total Patients :<?php echo htmlentities($nrPat); } ?>		
												</a>
											</p>
										</div>
									</div>
								</div>
			                    <div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> 
												<i class="ti-files fa-1x text-primary"></i> 
												<i class="fa fa-terminal fa-stack-1x fa-inverse"></i> 
											</span>
											<h2 class="StepTitle"> Enquire </h2>											
											<p class="links cl-effect-1">
												<a href="bookAppointment.php">
													<a href="unreadQueries.php">
														<?php 
															$qCon= mysqli_query($deal,"SELECT * FROM contactus where  IsRead is null");
															$nrCon = mysqli_num_rows($qCon);
													?>
															Total New Queries :<?php echo htmlentities($nrCon);   ?>	
													</a>
												</a>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>																	
					</div>
				</div>
			</div>
			<!-- FOOTER -->
			<?php include('include/footer.php');?>
			<?php include('include/setting.php');?>
		</div>
	</div>	
	<script src="assets/js/main.js"></script>
	<script src="assets/js/form-elements.js"></script>
	<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>		
	</body>
</html>
<?php } ?>
