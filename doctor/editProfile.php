<?php
	session_start();
	error_reporting(0);
	include('../define/config.php');
	if(strlen($_SESSION['id']==0)) {
		header('location:logout.php');
	} else{
		if(isset($_POST['submit']))
		{
			$docSpecial=$_POST['doctorspecial'];
			$docName=$_POST['doctorname'];
			$docAdd=$_POST['clinicaddress'];
			$docFees=$_POST['doctorfees'];
			$docContact=$_POST['doctorcontact'];
			$docEmail=$_POST['doctoremail'];
			$editDoc=mysqli_query($deal,"UPDATE doctors SET specilization='$docSpecial',
															doctorName='$docName',
															address='$docAdd',
															docFees='$docFees',
															contactno='$docContact' 
															where id='".$_SESSION['id']."'");
			if($sql)
			{
			echo "<script>alert('Doctor Details updated Successfully');</script>";
			}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Doctr | Edit Doctor Details</title>
		<!-- CSS -->
		<link rel="stylesheet" href="../assign/css/styles.css">
		<link rel="stylesheet" href="../assign/css/plugins.css">
		<link rel="stylesheet" href="../assign/css/themes/theme-1.css" id="skin_color" />


	</head>
<body>
	<div id="application">		
		<?php include('../define/sidebar.php');?>
		<div class="application-content">
			<?php include('../define/header.php');?>
			<div class="main-content" >
				<div id="container" class="wrap-content container" >
					<!-- section: PAGE TITLE -->
					<section id="page-title">
						<div class="row">
							<div class="col-sm-8"><h1 class="mainTitle">Doctor | Edit Doctor </h1></div>
								<ol class="breadcrumb">
									<li><span>Doctor</span></li>
									<li class="active"><span>Edit Doctor</span></li>
								</ol>
						</div>
					</section>						
					<!-- section: CONTENT -->
					<div class="container-fluid container-fullw bg-white">
						<div class="row">
							<div class="col-md-12">									
								<div class="row margin-top-30">
									<div class="col-lg-8 col-md-12">
										<div class="panel panel-white">
											<div class="panel-heading"><h5 class="panel-title">Edit Doctor</h5></div>
										<div class="panel-body">
										<?php 
											$docid=$_SESSION['dlogin'];
											$qDoc=mysqli_query($deal,"SELECT * FROM doctors WHERE docEmail='$docid'");
											while($resultset=mysqli_fetch_array($qDoc))
											{
											?>
											<h4><?php echo htmlentities($resultset['doctorName']);?>'s Profile</h4>
											<p><b>Profile Reg. Date: </b>
												<?php echo htmlentities($resultset['creationDate']);?>
											</p>
												<?php if($resultset['updationDate']){?>
												<p><b>Profile Last Updation Date: </b>
													<?php echo htmlentities($resultset['updationDate']);?>
												</p>
											<?php } ?>
											<hr />
											<form name="addDoctor" role="form"  method="post" onSubmit="return valid();">
												<div class="form-group">
													<label for="DoctorSpecial">Doctor Specialization</label>
							 						<select name="doctorspecial" class="form-control" required="required">
														<option value="<?php echo htmlentities($resultset['specilization']);?>">
																<?php echo htmlentities($resutltset['specilization']);?>
														</option>
															<?php $qDS=mysqli_query($deal,"SELECT * FROM doctorSpecialized");
															while($data=mysqli_fetch_array($qDS))
															{
															?>
														<option value="<?php echo htmlentities($data['specilization']);?>">
															<?php echo htmlentities($data['specilization']);?>
														</option>
														<?php } ?>																
													</select>
												</div>
												<div class="form-group">
													<label for="DoctorName">Doctor Name</label>
													<input name="doctorname" type="text"  class="form-control" 
													       value="<?php echo htmlentities($resultset['doctorName']);?>" >
														</div>
												<div class="form-group">
													<label for="Address">Doctor Clinic Address</label>
													<textarea name="clinicaddress" class="form-control">
														<?php echo htmlentities($resultset['address']);?>
												    </textarea>
												</div>
												<div class="form-group">
													<label for="ConsultancyFees">Consultancy Fees</label>
													<input name="doctorfees" type="text"  class="form-control" required="required" 
													        value="<?php echo htmlentities($resultseet['docFees']);?>" >
												</div>	
												<div class="form-group">
													<label for="DoctorContact">Doctor Contact no</label>
													<input name="doctorcontact" type="text"  class="form-control" required="required"  
													       value="<?php echo htmlentities($resultset['contactno']);?>">
												</div>
												<div class="form-group">
													<label for="DoctorEmail">Doctor Email</label>
													<input name="doctoremail" type="email"  class="form-control"  readonly="readonly"  
													        value="<?php echo htmlentities($resultset['docEmail']);?>">
												</div>	
												<?php } ?>																												
												<button name="submit" type="submit"  class="btn btn-o btn-primary">
													Update
												</button>
											</form>
										</div>
									</div>
								</div>											
							</div>
						</div>									
					</div>					
				</div>
			</div>
		</div>
	</div>
		<!-- FOOTER -->
	<?php include('../define/footer.php');?>			
	<?php include('../define/setting.php');?>
	<!-- JAVASCRIPT -->
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
