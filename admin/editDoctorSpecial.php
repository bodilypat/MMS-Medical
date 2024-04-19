<?php
	session_start();
	error_reporting(0);
	include('include/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
		$dsid=intval($_GET['eid']);// get value
		if(isset($_POST['submit']))
		{
			$docSpecial=$_POST['doctorSpecial'];
			$editDS=mysqli_query($deal,"UPDATE  doctorSpecilization 
			                         SET specilization='$docSpecial' 
									 WHERE id='$dsid'");
			if($editDS)
			{
				$_SESSION['msg']="Doctor Specialization updated successfully !!";
			}			
		} 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | Edit Doctor Specialization</title>
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
					<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Admin | Edit Doctor Specialization</h1></div>
							<ol class="breadcrumb">
								<li><span>Admin</span></li>
								<li class="active"><span>Edit Doctor Specialization</span></li>
							</ol>
						</div>
					</section>
					<!-- section:Content -->						
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">									
								<div class="row margin-top-30">
									<div class="col-lg-6 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Edit Doctor Specialization</h5></div>
												<div class="panel-body">
													<p style="color:red;">
														<?php echo htmlentities($_SESSION['msg']);?>
														<?php echo htmlentities($_SESSION['msg']="");?>
													</p>	
													<form name="doctorspec" role="form" method="post" >
														<div class="form-group">
															<label for="EditDoctorSpecial">Edit Doctor Specialization</label>
															<?php 

																$dsid=intval($_GET['id']);
																$qDS=mysqli_query($deal,"SELECT * 
																	                     FROM doctorSpecilization 
																						 WHERE id='$dsid'");
																while($result=mysqli_fetch_array($qDS))
																{														
															?>		
															<input name="doctorSpecial" type="text" class="form-control" 
															       value="<?php echo $result['specilization'];?>" >
															<?php } ?>
														</div>																																																					
														<button type="submit" name="submit" class="btn btn-o btn-primary">
															Update
														</button>
													</form>
												</div>
											</div>
										</div>											
									</div>
								</div>
							<div class="col-lg-12 col-md-12">
								<div class="panel panel-white"></div>
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
	<!-- JAVASCRIPTS -->
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
