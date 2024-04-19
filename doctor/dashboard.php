<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) 
	{
		header('location:logout.php');
	} else{

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Doctor  | Dashboard</title>
		<!-- CSS -->		
		<link rel="stylesheet" href="assign/css/styles.css">
		<link rel="stylesheet" href="assign/css/plugins.css">
		<link rel="stylesheet" href="assign/css/themes/theme-1.css" id="skin_color" />

	</head>
<body>
	<div id="application">		
		<?php include('include/sidebar.php');?>
			<div class="application-content">				
				<?php include('include/header.php');?>										
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- section: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8"><h1 class="mainTitle">Doctor | Dashboard</h1></div>
								<ol class="breadcrumb">
									<li><span>User</span></li>
									<li class="active"><span>Dashboard</span></li>
								</ol>
							</div>
						</section>
						<!-- section: CONTEXT  -->
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> <i class="fa fa-square fa-stack-2x text-primary"></i> <i class="fa fa-smile-o fa-stack-1x fa-inverse"></i> </span>
											<h2 class="StepTitle">My Profile</h2>											
											<p class="links cl-effect-1"><a href="editProfile.php">Update Profile</a></p>
										</div>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"> 
												 <i class="fa fa-square fa-stack-2x text-primary"></i> 
												 <i class="fa fa-paperclip fa-stack-1x fa-inverse"></i> 
											</span>
											<h2 class="StepTitle">My Appointments</h2>
											<p class="cl-effect-1"><a href="appointmentHistory.php">View Appointment History</a></p>
										</div>
									</div>
								</div>
							</div>
						</div>		
						<!-- end: SELECT BOXES -->			
					</div>
				</div>
			</div>
			<!--FOOTER -->
	<?php include('include/footer.php');?>
	<?php include('include/setting.php');?>	
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
<?php } ?>
